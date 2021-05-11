<?php
require_once 'db/OrderModel.php';
require_once 'db/CustomerModel.php';
require_once 'db/ShipmentModel.php';


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
            case RESTConstants::METHOD_PUT:
                return $this->handlePUTRequest($uri, $payload);
            case RESTConstants::METHOD_POST:
                return $this->handlePOSTRequest($uri, $payload);
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

    /**
     * This method forwards PUT requests for the customer-rep endpoint
     * @param $uri array of input parameters
     * @return array|void results
     */
    private function handlePUTRequest($uri, $payload)
    {
        if ($uri[0] == "order" && sizeof($uri) == 3) {
            // Get order id
            $orderId = $uri[2];

            // Forward
            switch (strtolower($uri[1])) {
                case "open":
                    return $this->changeOrderState($orderId, "open");
                case "available":
                    return $this->changeOrderState($orderId, "available");
            }
        }
    }

    /**
     * This method forwards POST requests for the customer-rep endpoint
     * @param $uri array of input parameters
     * @return array|void results
     */
    private function handlePOSTRequest($uri, $payload) {
        if ($uri[0] == "order" && sizeof($uri) == 3) {
            // Get order id
            $orderId = $uri[2];

            // Forward
            switch (strtolower($uri[1])) {
                case "ship":
                    return $this->createShipment($orderId, $payload);
            }
        }
    }

    /**
     * Change order status of a given order
     * @param mixed $orderId order id
     * @param string $state state to change to
     * @return array results
     */
    public function changeOrderState(mixed $orderId, string $state): array
    {
        $resource['status'] = $state;
        $resource['order_no'] = $orderId;
        $order = (new OrderModel())->updateResource($resource);


        // Return result
        if ($order) {
            $res['result'] = "Status of order " . $orderId. " changed to " . $state . "!";
            $res['status'] = RESTConstants::HTTP_OK;
        } else {
            $res['result'] = "Status of order " . $orderId. " was not updated. Order might not exist";
            $res['status'] = RESTConstants::HTTP_BAD_REQUEST;
        }

        $res['exist'] = $order;
        return $res;
    }


    /**
     * Will create a shipment request on an order
     * @param mixed $orderId order id
     * @return array results
     */
    private function createShipment(mixed $orderId): array
    {
        // Check if order exist
        $res = $this->changeOrderState($orderId, "ready to be shipped");
        if ($res['exist'] == false) {
            return $res;
        }

        // Get customer info
        $order = (new OrderModel())->getResource($orderId);
        $customerID = $order[0]['customer_id'];
        $customer = (new CustomerModel())->getResource($customerID);

        // Set info
        $customerName = $customer[0]['name'];
        $customerAddress = $customer[0]['address_id'];


        // Create shipment
        $resource = array();
        $resource['customer_name'] = $customerName;
        $resource['address_id'] = $customerAddress;
        $shipmentId = (new ShipmentModel())->createResource($resource);


        // Prepare results
        $results['Shipment No'] = $shipmentId;
        $results['Status'] = $res['result'];

        // Return results
        $res['result'] = $results;
        $res['status'] = RESTConstants::HTTP_CREATED;
        return $res;
    }
}