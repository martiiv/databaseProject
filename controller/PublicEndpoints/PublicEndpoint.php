<?php
require_once 'db/SkiModel.php';


/**
 * Class PublicEndpoint is responsible for giving the public access to the API.
 * Will provide basic information, like all the skies existing and their information.
 */
class PublicEndpoint
{

    /**
     * Handler for the public endpoint
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array $payload of the request
     * @return array  results
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGet($uri, $queries);
            default: //TODO Throw exception
        }
    }

    /**
     * This method will handle all the GET requests made in the public endpoint.
     * In this case, return all the skies or a ski of a specific model
     * @param $uri list of input parameters
     * @param $queries included in the uri, i.e. ?state=state
     * @return array results
     */
    public function handleGet($uri, $queries): array
    {
        if ($uri[0] == "skis" && sizeof($queries) == 1) {
            $ski_model = $queries['ski_model'];

            $ski_models = (new SkiModel())->getSkiType($ski_model);

        } else if ($uri[0] == "skis" && sizeof($queries) == 0) {
            $ski_models = (new SkiModel())->getCollection();
        } else {
            ///throw new ....
        }

        $res['result'] = $ski_models;
        $res['status'] = RESTConstants::HTTP_OK;
        return $res;
    }
}