<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';


class CustomerEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGetRequest($uri, $queries, $payload);
            case RESTConstants::METHOD_DELETE:
                return $this->handleDelete($uri, $queries, $payload);
            default: //TODO Throw exception
        }
    }

    private function handleGetRequest($uri, $queries, $payload): array
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

    private function handleDelete($uri, $queries, $payload)
    {
        if ($uri[0] == "order" && count($uri) == 4) {

            $resource = array();
            $resource['order_no'] = $uri[3];
            $resource['status'] = "canceled";
            $shipment_no = (new OrderModel())->updateResource($resource);

            // TODO: delete shipment will not work because of improper database design.
            (new ShipmentModel())->deleteResource($shipment_no);

            $res['result'] = $uri[3] . " canceled";
            $res['status'] =  RESTConstants::HTTP_OK;
            return $res;
        }
        else {
            //TODO Throw exception
        }
    }
}