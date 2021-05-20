<?php
require_once 'db/OrderModel.php';
require_once 'db/CustomerModel.php';
require_once 'db/ShipmentModel.php';


/**
 * Class CustomerRepEndpoint is responsible for handling everything that a customer rep might need to do,
 * for instance: get orders with a given state, update orders states, create shipment request for an order...
 */
class CustomerRepEndpoint
{
    /**
     * Handler for the customer-rep endpoint
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array payload  of the request
     * @return array results
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGETRequest($uri, $queries);
            case RESTConstants::METHOD_PUT:
                return $this->handlePUTRequest($uri);
            case RESTConstants::METHOD_POST:
                return $this->handlePOSTRequest($uri, $payload);
            default: //TODO Throw exception
        }
    }

    /**
     * Get all the orders with a given state/status
     * @param array $uri of input parameters
     * @param array $queries of queries included in the uri, i.e. ?state=state
     * @return array all the orders with a given status
     */
    private function handleGETRequest(array $uri, array $queries): array
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
     * @param array $uri of input parameters
     * @return array of results
     */
    private function handlePUTRequest(array $uri): array
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
     * @param array $uri of input parameters
     * @param array $payload of the request
     * @return array results
     */
    private function handlePOSTRequest(array $uri, array $payload): array
    {
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
     * @param int $orderId order id
     * @param string $state state to change to
     * @return array results
     */
    public function changeOrderState(int $orderId, string $state): array
    {
        $resource['status'] = $state;
        $resource['order_no'] = $orderId;
        $order = (new OrderModel())->updateResource($resource);


        // Return result
        if ($order) {
            $res['result'] = "Status of order " . $orderId . " changed to " . $state . "!";
            $res['status'] = RESTConstants::HTTP_OK;
        } else {
            $res['result'] = "Status of order " . $orderId . " was not updated. Order might not exist";
            $res['status'] = RESTConstants::HTTP_BAD_REQUEST;
        }

        $res['exist'] = $order;
        return $res;
    }


    /**
     * Will create a shipment request for an order
     * @param mixed $orderId order id
     * @return array results
     */
    private function createShipment(int $orderId): array
    {
        // Check if order exist
        $res = $this->changeOrderState($orderId, "ready to be shipped");
        if ($res['exist'] == false) {
            return $res;
        }

        // Get customer info
        $order = (new OrderModel())->getResource($orderId);
        $customerID = $order[0]['customer_id'];
        $customer = (new CustomerModel())->getAddress($customerID);

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