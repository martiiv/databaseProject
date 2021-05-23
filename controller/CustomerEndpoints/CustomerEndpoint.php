<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';
require_once 'db/OrderItemsModel.php';
require_once 'db/ProductionPlanModel.php';


/**
 * Class CustomerEndpoint is responsible for providing the customer with functionality to create, get and delete an order.
 */
class CustomerEndpoint
{
    /**
     * Handler for the customer endpoint
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array $payload of the request
     * @return array results
     * @throws APIException
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array
    {
        return match ($requestMethod) {
            RESTConstants::METHOD_GET => $this->handleGetRequest($uri, $requestMethod),
            RESTConstants::METHOD_DELETE => $this->handleDeleteRequest($uri),
            RESTConstants::METHOD_POST => $this->handlePostRequest($uri, $payload),
            default => throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod),
        };
    }

    /**
     * This method will forward all get requests from customer
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @return array List of order(s)
     * @throws APIException
     */
    private function handleGetRequest(array $uri, string $requestMethod): array
    {
        return match ($uri[0]) {
            "order" => $this->getOrder($uri),
            "production" => $this->getProductionPlanSummary(),
            default => throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod),
        };
    }

    /**
     * GET Order -> will return all orders, all orders from one customer or one order given an id.
     * @param array $uri list of input parameters
     * @return array results
     */
    private function getOrder(array $uri)
    {
        $model = new OrderModel();
        if (count($uri) == 2) {
            $res['result'] = $model->getCollection($uri[1]);
        } elseif (count($uri) == 3) {
            $res['result'] = $model->getResource($uri[2]);
        }

        // return output
        $res['status'] = RESTConstants::HTTP_OK;
        return $res;
    }

    /**
     * This method will return a list of skies to be produced. Will include model and amount.
     * @return array results
     */
    private function getProductionPlanSummary(): array
    {
        $ski_model_list = array();
        $summary = array();
        $model = new ProductionPlanModel();
        $dates = $model->getDates();

        foreach ($dates as $date) {
            $ski_model_list[] = $model->getSki_models($date['start_date']);
        }

        foreach ($ski_model_list as $ski_model) {
            foreach ($ski_model as $ski) {
                if (!array_key_exists($ski['ski_type_model'], $summary)) {
                    $summary[$ski['ski_type_model']] = 0;
                }
                $summary[$ski['ski_type_model']] += $ski['amount'];
            }
        }

        // Prepare output
        $res['result'] = $summary;
        $res['status'] = RESTConstants::HTTP_OK;
        return $res;
    }

    /**
     * This method will delete an order.
     * It will essentially set status to canceled and delete shipment if ordered.
     * @param array $uri list of input parameters
     * @return array confirmation
     */
    private function handleDeleteRequest(array $uri): array
    {
        if ($uri[0] == "order" && count($uri) == 4) {

            $resource = array();
            $resource['order_no'] = $uri[3];
            $resource['status'] = "canceled";
            if ((new OrderModel())->updateResource($resource)) {
                // Get order details
                $order = (new OrderModel())->getResource($resource['order_no']);
                $shipmentId = $order[0]['shipment_no'];

                // Remove shipment
                if ($shipmentId != "") {
                    (new ShipmentModel())->deleteResource($order[0]['shipment_no']);
                }
            }

            //Prepare result
            $res['result'] = $uri[3] . " canceled";
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
    }

    /**
     * Add a new order with skies to the database.
     *
     * @param array $uri
     * @param array $payload order info with ski model and amount, e.g.: {"Active":2, "Intrasonic":4}
     * @return array Info about skies added
     * @throws APIException
     */
    private function handlePostRequest(array $uri, array $payload): array
    {
        if ($uri[0] == "order" && $uri[1] == "place" && count($uri) == 3) {
            $model = new SkiModel();
            $skis = array();

            $json = json_encode($payload);
            $data = json_decode($json, true);
            foreach ($data as $skitype => $amount) {
                $validType = $model->getSkiType($skitype);
                if (count($validType) < 1) {
                    throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "Invalid ski type: " . $skitype);
                } else {
                    $skis[$skitype] = $validType[0];
                }
            }

            // Prepare filter
            $filter = array();
            $filter['total_price'] = 0;
            $filter['status'] = "new";
            $filter['customer_id'] = $uri[2];

            // Get total price
            foreach ($skis as $skitype => $ski) {
                $filter['total_price'] += ((int)$ski['retail_price']) * ((int)$data[$skitype]);
            }

            $order_no = (new OrderModel())->createResource($filter);

            //Add skies to order items
            $filterItems = array();
            $filterItems['order_no'] = $order_no;
            foreach ($data as $skitype => $amount) {
                $filterItems['ski_type'] = $skitype;
                $filterItems['amount'] = $amount;
                (new OrderItemsModel())->addSkiToOrder($filterItems);
            }

            // Prepare output
            $result = array();
            $result['Order_no'] = $order_no;
            $result['Total Price'] = $filter['total_price'];
            $result['Items Ordered'] = $data;
            $res['result'] = $result;
            $res['status'] = RESTConstants::HTTP_CREATED;
            return $res;
        }
    }
}