<?php
require_once 'db/SkiModel.php';
require_once 'controller/handlers/SkiModelHandler.php';


class PublicEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                return $this->handleGet($uri, $queries);
            default: //TODO Throw exception
        }
    }

    public function handleGet($uri, $queries){
        if($uri[0]=="skis" && sizeof($queries)==1){
            $ski_model = $queries['ski_model'];

            $ski_models = (new SkiModel())->getSkiType($ski_model);

        } else if($uri[0]=="skis" && sizeof($queries)==0){
            $ski_models = (new SkiModel())->getCollection();
        }

        $res['result'] = $ski_models;
        $res['status']= RESTConstants::HTTP_OK;
        return $res;
    }
}