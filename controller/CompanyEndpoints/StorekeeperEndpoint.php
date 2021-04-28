<?php
require_once 'db/OrderModel.php';
require_once 'db/ShipmentModel.php';
require_once 'db/SkiModel.php';

class StorekeeperEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_PUT:
                return $this->handleUpdate($uri, $queries, $payload);

            case RESTConstants::METHOD_POST:
                return $this->handleCreateSki($uri, $payload);

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
                $res['status'] = RESTConstants::HTTP_OK;
            } else {
                $res['result'] = "Order: " . $uri[2] . " failed to update.";
                $res['status'] = RESTConstants::HTTP_FORBIDDEN;
            }
            return $res;
        } else {
            //TODO Throw exception
        }
        return $uri;
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

            foreach ($data as $key => $entry) {
                print $key. ":". $entry."\n";
                if ($entry == "") {
                    print "One of the entries are empty \n";
                    //throw; //TODO Throw exception
                }
            }
            $product = (new SkiModelHandler())->createResource($data);
            print "Right after ski creation";
            print $product;

            return  $product;
        } else {
            //throw; //TODO Throw exception
        }
        return $uri;
    }
}