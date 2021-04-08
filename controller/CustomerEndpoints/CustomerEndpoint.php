<?php
require_once 'db/OrderModel.php';


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

}