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
            if ($uri[4] == ("ready")) {
                $resource['status'] = $uri[4];
                (new OrderModel())->updateResource($resource);

                // TODO - add check if order_no exists
                $res['result'] = "Order: " . $uri[2] . " successfully updated";
                $res['status'] =  RESTConstants::HTTP_OK;
            } else {
                $res['result'] = "Order: " . $uri[2] . " failed to update.";
                $res['status'] =  RESTConstants::HTTP_FORBIDDEN;
            }
            return $res;
        }
        else {
            //TODO Throw exception
        }
    }
}