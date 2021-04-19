<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';
require_once 'db/OrderItemsModel.php';


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
                return $this->handleGetRequest($uri);
            case RESTConstants::METHOD_DELETE:
                return $this->handleDeleteRequest($uri);
            case RESTConstants::METHOD_POST:
                return $this->handlePostRequest($uri, $payload);
            default: throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod);
        }
    }

    /**
     * This method will handler all get requests from customer:
     *  GET Order -> will return all orders, all orders from one customer or one order given an id.
     * @param $uri list of input parameters
     * @return array List of order(s)
     */
    private function handleGetRequest($uri): array
    {
        $res = array();
        $model = null;
        switch ($uri[0]) {
            case "order":
                $model = new OrderModel();
                if (count($uri) == 2) {
                    $res['result'] = $model->getCollection($uri[1]);
                } elseif (count($uri) == 3) {
                    $res['result'] = $model->getResource($uri[2]);
                }
                $res['status'] =  RESTConstants::HTTP_OK;
            case "production":
                //TODO: Return production plan
        }
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
            $shipment_no = (new OrderModel())->updateResource($resource);

            // TODO: delete shipment will not work because of improper database design.
            if ($shipment_no != null) {
                (new ShipmentModel())->deleteResource($shipment_no);
            }


            $res['result'] = $uri[3] . " canceled";
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
        else {
            //TODO Throw exception
        }
    }

    /**
     * Add a new order with skies to the database.
     *
     * NOTE: Order_id will be auto generated, but it has not been done yet.
     * @param $uri
     * @param $payload order info with ski model and amount, e.g.: {"Active":2, "Intrasonic":4}
     * @return array Info about skies added
     * @throws APIException
     */
    private function handlePostRequest($uri, $payload): array
    {
        if ($uri[0] == "order" && $uri[1] == "place" && count($uri) == 4) {
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
            $filter['order_no'] = $uri[3];
            $filter['total_price'] = 0;
            $filter['status'] = "new";
            $filter['customer_id'] = $uri[2];

            // Get total price
            foreach ($skis as $skitype => $ski) {
                $filter['total_price'] += ((int) $ski['retail_price']) * ((int) $data[$skitype]);
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