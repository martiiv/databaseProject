<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';
require_once 'db/OrderItemsModel.php';
require_once 'db/ProductionPlanModel.php';


class CustomerEndpoint
{
    /**
     * This method will forward the request based on requestMethod.
     * @param $uri
     * @param $requestMethod
     * @param $queries
     * @param $payload
     * @return array
     * @throws APIException
     */
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGetRequest($uri, $requestMethod);
            case RESTConstants::METHOD_DELETE:
                return $this->handleDeleteRequest($uri);
            case RESTConstants::METHOD_POST:
                return $this->handlePostRequest($uri, $payload);
            default:
                throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod);
        }
    }

    /**
     * This method will forward all get requests from customer
     * @param $uri list of input parameters
     * @return array List of order(s)
     */
    private function handleGetRequest($uri, $requestMethod): array
    {
        switch ($uri[0]) {
            case "order":
                return $this->getOrder($uri);
            case "production":
                return $this->getProductionPlanSummary();
            default:
                throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod);
        }
    }

    /**
     * GET Order -> will return all orders, all orders from one customer or one order given an id.
     * @param $uri list of input parameters
     * @return array results
     */
    private function getOrder($uri)
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
     * @param $uri list of input parameters
     * @return array results
     */
    private function getProductionPlanSummary()
    {
        $ski_model_list = array();
        $summary = array();
        $model = new ProductionPlanModel();
        $dates= $model->getDates();

        foreach ($dates as $date){
            $ski_model_list[] = $model->getSki_models($date['start_date']);
        }

        foreach ($ski_model_list as $ski_model){
            foreach ($ski_model as $ski){
                if(!array_key_exists($ski['ski_type_model'], $summary)){
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
     * @param $uri list of input parameters
     * @return array confirmation
     */
    private function handleDeleteRequest($uri)
    {
        if ($uri[0] == "order" && count($uri) == 4) {

            $resource = array();
            $resource['order_no'] = $uri[3];
            $resource['status'] = "canceled";
            if ((new OrderModel())->updateResource($resource))  {
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
     * @param $uri
     * @param $payload order info with ski model and amount, e.g.: {"Active":2, "Intrasonic":4}
     * @return array Info about skies added
     * @throws APIException
     */
    private function handlePostRequest($uri, $payload): array
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