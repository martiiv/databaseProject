<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';
require_once 'db/ProductModel.php';
require_once 'controller/handlers/ProductHandler.php';
require_once 'CustomerRepEndpoint.php';

class StorekeeperEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_PUT:
                return $this->handleUpdate($uri);

            case RESTConstants::METHOD_POST:
                return $this->handleCreateSki($uri, $payload);

            default: //TODO Throw exception
        }
    }

    /**
     * Function handleUpdate from CustomerRepEndpoint
     * Used to change order state according to project case
     * @param $uri
     * @param $queries
     * @param $payload
     * @return array
     */
    private function handleUpdate($uri): array
    {
        $update = new CustomerRepEndpoint();
        if ($uri[0] == "order" && sizeof($uri) == 3) {
            // Get order id
            $orderId = $uri[2];

            // Forward
            switch (strtolower($uri[1])) {
                case "ready":
                    return $update->changeOrderState($orderId, "ready");
            }
        }
    }

    /**
     * Method for creating 'Finished' products
     * http://localhost/dbproject-33/storekeeper/ski
     *
     * @param $uri /ski : The url passed into the function
     * @param $payload /{model:amount,model:amount...} The body passed in structure ski_type model name and amount
     * @return array Returns the produced skis with product number and production date
     */
    private function handleCreateSki($uri, $payload): array
    {
        if ($uri[0] == "ski" && count($uri) == 1) {
            $json = json_encode($payload);
            $data = json_decode($json, true);
            $products = array();

            foreach ($data as $key => $entry) {

                if ($entry == 0 || $key == "") {
                    print "The ski_type provided or the amount is null \n";
                    //throw; //TODO Throw exception

                } else {
                    $filter = array(
                        'ski_type' => $key,
                        'amount' => intval($entry)
                    );

                    $products = (new ProductHandler())->createResource($filter);
                }
            }
            $res['product_no'] = $products['product_no'] ?? "";
            $res['result'] = $products;
            $res['status'] = RESTConstants::HTTP_CREATED;
            return $res;

        } else {
            print("The uri provided contains wrong syntax try: storekeeper/ski \n");
            //throw; //TODO Throw exception
            return $uri;
        }
    }
}