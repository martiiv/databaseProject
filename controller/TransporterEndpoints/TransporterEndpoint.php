<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';


/**
 * Class TransporterEndpoint is responsible for providing the transporters a way to retrieve all orders
 * that are waiting to be picked up, and a way to update an order when it has been picked up.
 */
class TransporterEndpoint
{
    /**
     * Handler for the transporter endpoint
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array $payload of the request
     * @return array results
     * @throws APIException
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array
    {
        return match ($requestMethod) {
            RESTConstants::METHOD_GET => $this->handleGetRequest($uri),
            RESTConstants::METHOD_PUT => $this->handlePutRequest($uri),
            default => throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod),
        };
    }

    /**
     * This method will handler all get requests from customer:
     *  GET Order -> will return all orders, all orders from one customer or one order given an id.
     * @param array $uri of input parameters
     * @return array List of order(s)
     */
    private function handleGetRequest(array $uri): array
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

    /**
     * This method handles all the PUT requests made in the transporter endpoint.
     * In this case, update an order with pickup date and changes the status
     * @param array $uri of input parameters
     * @return array with results: The shipment
     */
    private function handlePutRequest(array $uri): array
    {
        if ($uri[0] == 'pickup' && sizeof($uri) == 2) {
            $shipment_no = $uri[1];
            $shipment = (new ShipmentModel())->updateResource(['pickup_date' => date("Y/m/d"), 'state' => 1], '', $shipment_no);
            $res['result'] = $shipment;
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
    }

}