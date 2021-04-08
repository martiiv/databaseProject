<?php

/**
 * Class transporterTest for testing the transporter endpoint
 * @author Martin Iversen
 * @version 0.75
 * @date 08.04.2021
 */
class transporterTest extends \Codeception\Test\Unit
{
    /**
     * @var \ApiTester
     */
    protected ApiTester $I;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /*
     * Method for getting all orders with the status=ready
     * Tests the following endpoint:
     * /transporter/shipment
     */
    public function getOrderShipment(ApiTester $I){
        $I->sendGet('/transporter/shipment');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(['order_no' => 15231, 'total_price' => 345000, 'status' => 'ready', 'customer_id'=>3, 'shipment_no'=>1]);
    }

    /*
     * Method for updating the state of a shipment
     * Tests the following endpoint:
     * /transporter/shipment/{:shipment_id}
     */
    public function updateShipmentsTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/transporter/shipment/1',[
            'shipment_no' => 1,
            'store_franchise_name' => 'XXL',
            'pickup_date' => '2021-04-25',
            'state' => 1,
            'transporting_company' => 'Einars levering',
            'driver_id' => 2]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseMatchesJsonType([
            'shipment_no' => 'integer',
            'store_franchise_name' => 'string',
            'pickup_date' => 'date',
            'state' => 'integer',
            'transporting_company' => 'string',
            'driver_id' => 'integer']);

        $I->seeResponseContainsJson(array(['shipment_no' => 1, 'store_franchise_name' => 'XXL', 'pickup_date' => '2021-04-25', 'state' => 1, 'transporting_company' => 'Einars levering', 'driver_id' => 2]));
        $I->seeInDatabase(['shipment_no' => 1, 'store_franchise_name' => 'XXL', 'pickup_date' => '2021-04-25', 'state' => 1, 'transporting_company' => 'Einars levering', 'driver_id' => 2]);
    }
}