<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';
require_once 'db/ProductModel.php';
require_once 'CustomerRepEndpoint.php';


/**
 * Class StorekeeperEndpoint is responsible for providing everything that a storekeeper needs, for instance:
 * - update an order's state
 */
class StorekeeperEndpoint
{
    /**
     * Handler for the storekeeper endpoint
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array $payload of the request
     * @return array results
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array
    {
        return match ($requestMethod) {
            RESTConstants::METHOD_GET => $this->handleGet($uri, $queries),
            RESTConstants::METHOD_PUT => $this->handleUpdate($uri),
            RESTConstants::METHOD_POST => $this->handleCreateSki($uri, $payload),
            default => throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod),
        };
    }

    /**
     * Function HandleGet taken from CustomerRepEndpoint
     * Used to get orders with skis available state
     * @param array $uri of input parameters
     * @param array $queries array of queries included in the uri, i.e. ?state=state
     * @return array
     */
    private function handleGet(array $uri, array $queries): array
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
     * Function handleUpdate from CustomerRepEndpoint
     * Used to change order state according to project case
     * @param array $uri of input parameters
     * @return array
     */
    private function handleUpdate(array $uri): array
    {
        $update = new CustomerRepEndpoint();
        if ($uri[0] == "order" && sizeof($uri) == 3) {
            // Get order id
            $orderId = $uri[2];

            // Forward
            switch (strtolower($uri[1])) {
                case "ready":
                    return $update->changeOrderState($orderId, "ready");
                default: throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "Cannot change state to " . strtolower($uri[1]));
            }
        }
    }

    /**
     * Method for creating 'Finished' products
     * http://localhost/dbproject-33/storekeeper/ski
     *
     * @param array $uri of input parameters
     * @param body $payload /{model:amount,model:amount...} The body passed in structure ski_type model name and amount
     * @return array Returns the produced skis with product number and production date
     */
    private function handleCreateSki(array $uri, body $payload): array
    {
        if ($uri[0] == "ski" && count($uri) == 1) {
            $json = json_encode($payload);
            $data = json_decode($json, true);
            $products = array();

            foreach ($data as $key => $entry) {

                if ($entry == 0 || $key == "") {
                    throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "The ski_type provided or the amount is null");
                } else {
                    $filter = array(
                        'ski_type' => $key,
                        'amount' => intval($entry)
                    );

                    $temp = (new ProductModel)->createResource($filter);
                    $products = array_merge($products, $temp);
                }
            }

            $res['result'] = $products;
            $res['status'] = RESTConstants::HTTP_CREATED;
            return $res;

        } else {
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "The uri provided contains wrong syntax try: storekeeper/ski ");
            return $uri;
        }
    }
}