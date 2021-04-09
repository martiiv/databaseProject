<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';

class StorekeeperEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_PUT:
                return $this->handleUpdate($uri, $queries, $payload);
            default: //TODO Throw exception
        }
    }

    private function handleUpdate($uri, $queries, $payload): array
    {
        if ($uri[0] == "order" && count($uri) == 6) {

            $resource = array();
            $resource['order_no'] = $uri[2];
            $resource['status'] = $uri[4];
            $shipment_no = (new OrderModel())->updateResource($resource);

            $res['result'] = "Order: " . $uri[2] . " successfully updated";
            $res['status'] =  RESTConstants::HTTP_OK;
            return $res;
        }
        else {
            //TODO Throw exception
        }
    }
}