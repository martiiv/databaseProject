<?php
require_once 'Authorisation.php';

/**
 * Class PublicEndpointCest for testing the public endpoint
 * Tests:
 *      getSkiModels DONE Get info on ski_types with model filter
 */
class PublicEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * Function getSkiModels for testing the public endpoint
     * Sends in a get requests and returns all the available skiis (historical 0)
     * @param ApiTester $I
     */
    public function getSkiModels(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('public/skis');
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            "model" => "string",
            "ski_type" => "string",
            "temperature" => "string",
            "grip_system" => "string",
            "size" => "string",
            "weight_class" => "string",
            "description" => "string",
            'historical' => "string",
            "photo_url" => "NULL",
            "retail_price" => "string"
        ]);

        $I->seeResponseContainsJson(array(["model" => "Active Pro", "ski_type" => "skate", "temperature" => "warm", "grip_system" => "intelligrip", "size" => "147", "weight_class" => "30-40", "description" => "Rævva ski", "historical" => "0", "photo_url" => null, "retail_price" => "1400"]));
    }


    /**
     * Function getSkiModels for testing the public endpoint
     * Sends in a get requests and returns the Active Pro ski model
     * @param ApiTester $I
     */
    public function getSki(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('public/skis?ski_model=Active Pro');
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            "model" => "string",
            "ski_type" => "string",
            "temperature" => "string",
            "grip_system" => "string",
            "size" => "string",
            "weight_class" => "string",
            "description" => "string",
            'historical' => "string",
            "photo_url" => "NULL",
            "retail_price" => "string"
        ]);

        $I->dontSeeResponseContainsJson(array(["model" => "Active", "ski_type" => "skate", "temperature" => "warm", "grip_system" => "intelligrip", "size" => "147", "weight_class" => "30-40", "description" => "Rævva ski", "historical" => "0", "photo_url" => null, "retail_price" => "1400"]));
        $I->seeResponseContainsJson(array(["model" => "Active Pro", "ski_type" => "skate", "temperature" => "warm", "grip_system" => "intelligrip", "size" => "147", "weight_class" => "30-40", "description" => "Rævva ski", "historical" => "0", "photo_url" => null, "retail_price" => "1400"]));
    }
}
