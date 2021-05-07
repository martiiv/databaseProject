<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';

class TransporterEndpoint
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
            case RESTConstants::METHOD_PUT:
                return $this->handlePutRequest($uri);

            default:
                throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod);
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
        if ($uri[0] == "orders" && sizeof($uri) == 1) {

            // Get all orders with given state
            $orders = (new OrderModel())->getCollection(null, 'ready');

            // Return result
            $res['result'] = $orders;
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
    }

    private function handlePutRequest($uri): array{
        if($uri[0] == 'pickup' && sizeof($uri) == 2){
            $shipment_no = $uri[1];
            $shipment = (new ShipmentModel())->updateResource(['pickup_date'=>date("Y/m/d"),'state'=> 1],'',$shipment_no);
            $res['result'] = $shipment;
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
    }

}