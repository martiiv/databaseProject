<?php


class CustomerRepEndpoint
{
    /**
     * Handler for the customer-rep endpoint
     * @param $uri list of input parameters
     * @param $requestMethod method requested like GET, POST, PUT....
     * @param $queries queries included in the uri, i.e. ?state=state
     * @param $payload body of the request
     * @return array results
     */
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGETRequest($uri, $queries);
            default: //TODO Throw exception
        }
    }

    /**
     * Get all the orders with a given state/status
     * @param $uri array of input parameters
     * @param $queries queries included in the uri, i.e. ?state=state
     * @return array all the orders with a given status
     */
    private function handleGETRequest($uri, $queries): array
    {
        if ($uri[0] == "order" && sizeof($queries) == 1) {
            //get state
            $state = $queries['state'];

            // Get all orders with given state
            $orders = (new OrderModel())->getCollection(null, $state);

            // Return result
            $res['result'] = $orders;
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
    }
}