<?php

/**
 * Class publicTest for testing the public endpoint
 * @author Martin Iversen
 * @version 0.75
 * @date 08.04.2020
 */
class publicTest extends \Codeception\Test\Unit
{
    /**
     * @var \ApiTester
     */
    protected $I;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /*
     * Method for listing all available skiis
     * Tests the following endpoint:
     * /public
     */
    public function getSkiis(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/public');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'model'=> 'string',
            'ski_type'=>'string',
            'temperature'=>'string',
            'grip_system'=>'string',
            'size'=>'integer',
            'weight_class'=>'string',
            'description'=>'string',
            'historical'=>'integer',
            'photo_url'=>'string',
            'retail_price'=>'integer',
            'production_date'=>'date']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'cold', 'grip_system'=>'wax', 'size'=>142, 'weight_class'=>'20-30', 'description'=>'Bra ski', 'historical'=>0, 'photo_url'=>'bildet', 'retail_price'=>1200, 'production_date'=>'2021-03-20']);
        $I->seeInDatabase(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'cold', 'grip_system'=>'wax', 'size'=>142, 'weight_class'=>'20-30', 'description'=>'Bra ski', 'historical'=>0, 'photo_url'=>'bildet', 'retail_price'=>1200, 'production_date'=>'2021-03-20']);

    }


    /*
     * Method for listing a specific skii model
     * Tests the following endpoint:
     * /public{?model={:model}}
     */
    public function getSki(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/public?model=Active');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'model'=> 'string',
            'ski_type'=>'string',
            'temperature'=>'string',
            'grip_system'=>'string',
            'size'=>'integer',
            'weight_class'=>'string',
            'description'=>'string',
            'historical'=>'integer',
            'photo_url'=>'string',
            'retail_price'=>'integer',
            'production_date'=>'date']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'cold', 'grip_system'=>'wax', 'size'=>142, 'weight_class'=>'20-30', 'description'=>'Bra ski', 'historical'=>0, 'photo_url'=>'bildet', 'retail_price'=>1200, 'production_date'=>'2021-03-20']);
        $I->seeInDatabase(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'cold', 'grip_system'=>'wax', 'size'=>142, 'weight_class'=>'20-30', 'description'=>'Bra ski', 'historical'=>0, 'photo_url'=>'bildet', 'retail_price'=>1200, 'production_date'=>'2021-03-20']);

    }

}