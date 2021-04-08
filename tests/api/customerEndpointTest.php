<?php

/**
 * Class customerEndpointTest created for testing functionality within the customer endpoints
 * @author Martin Iversen
 * @version 0.75
 * TODO FIKSE SINCE FILTER PÅ ORDER
 * TODO FINNE EN ASSERT SJEKK FOR DELETE
 */
class customerEndpointTest extends \Codeception\Test\Unit
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
     * Method for creating order
     * Tests the following endpoint:
     * /customer/order/place/{:customer_id}
     */
    public function addOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/customer/order/place/1', [
            'order_no'=> 453221,
            'total_price'=>25000,
            'status'=>'new',
            'customer_id'=>1,
            'shipment_no'=>NULL]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no'=> 453221,'total_price'=>25000, 'status'=>'new', 'customer_id'=>1, 'shipment_no'=>NULL]));
        $I->seeInDatabase(['order_no'=> 453221,'total_price'=>25000, 'status'=>'new', 'customer_id'=>1, 'shipment_no'=>NULL]);
    }

    /*
     * Method for listing all orders
     * Tests the following endpoint:
     * /customer/order/{:customer_id}{?since={:since}}
     * TODO LEGG IN DATO I ORDRE FOR Å FÅ TIL SINCE
     */
    public function listOrders(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/customer/order/1?since={:since}}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> '453221','total_price'=>25000, 'status'=>'new', 'customer_id'=>1, 'shipment_no'=>NULL]));
    }

    /*
     * Method for listing a specific order
     * Tests the following endpoint:
     * /customer/order/{:customer_id}/{:order_id}
     */
    public function listOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/customer/order/1/453221');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> 453221,'total_price'=>25000, 'status'=>'new', 'customer_id'=>1, 'shipment_no'=>NULL]));
    }

    /*
     * Method for splitting an order
     * Tests the following endpoint:
     * /customer/order/{:customer_id}/{:order_id}/split
     */
    public function splitOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/customer/order/1/453221/split',[
            'order_no'=> 642123,
            'total_price'=>3500,
            'status'=>'new',
            'customer_id'=>1,
            'shipment_no'=>NULL]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 642123, 'total_price' => 3500, 'status' => 'new', 'customer_id'=>1, 'shipment_no'=>NULL]));
        $I->seeInDatabase(['order_no' => 642123, 'total_price' => 3500, 'status' => 'new', 'customer_id'=>1, 'shipment_no'=>NULL]);
    }

    /*
     * Method for deleting an order
     * Tests the following endpoint:
     * /customer/order/cancel/{:customer_id}/{:order_id}
     * TODO ASSERT EQUALS ER LITT USIKKER HER
     */
    public function cancelOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/customer/order/cancel/1/453221');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(0,count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> '453221','total_price'=>25000, 'status'=>'new', 'customer_id'=>1, 'shipment_no'=>NULL]));
    }

    /*
     * Method for getting the current production plan
     * Tests the following endpoint:
     * /customer/production
     */
    public function getProductionPlan(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/customer/production');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'start_date'=>'date',
            'end_date'=>'date',
            'no_of_skis_per_day'=>'integer',
            'production_planner_number'=>'integer']);

        $I->seeResponseContainsJson(['start_date'=>'2021-04-22','end_date'=>'2021-05-19', 'no_of_skis'=>1500, 'production_planner_number'=>5]);
    }
}