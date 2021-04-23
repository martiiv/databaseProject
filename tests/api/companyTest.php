<?php
/**
 * Test class for the company endpoints
 * Tests all the endpoints mentioned in the endpoint list concerning company
 * @author Martin Iversen
 * @version 0.75
 * @date 08.04.2021
 */
class companyTest extends \Codeception\Test\Unit
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
        //TODO SLETT ALT SOM ER LAGD
    }

    /*
     * Method for getting orders
     * Tests the following endpoint:
     * /company/customer-rep/order
     */
    public function getOrders(ApiTester $I){
        $I->haveHttpHeader('Content-Type','application/json');
        $I->sendGet('/company/customer-rep/order/');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> 10005, 'total_price'=>12000, 'status'=>'ready', 'customer_id'=>10001, 'shipment_no'=>NULL]));
    }

    /*
     * Method for getting specific order
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}
     */
    public function getOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type','application/json');
        $I->sendGet('/company/customer-rep/order/10006');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> 10006, 'total_price'=>2500, 'status'=>'new', 'customer_id'=>10002, 'shipment_no'=>10001]));

    }

    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=open}}
     */
    public function changeStatusOpen(ApiTester $I){
        $I->sendPut('/company/costumer-rep/order/10006?status=open');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'open', 'customer_id'=>10002, 'shipment_no'=>10001]));
        $I->seeInDatabase(['order_no' => 10006, 'total_price' => 2500, 'status' => 'open', 'customer_id'=>10002, 'shipment_no'=>10001]);
    }

    /*
     * Method for changing the status of an order from open to available
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=available}}
     */
    public function changeStatusAvailable(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/costumer-rep/order/10006?status=skis_available');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'skis_available', 'customer_id'=>10002, 'shipment_no'=>10001]));
        $I->seeInDatabase(['order_no' => 10006, 'total_price' => 2500, 'status' => 'skis_available', 'customer_id'=>10002, 'shipment_no'=>10001]);
    }

    /*
     * Method for getting all the available skiis
     * Tests the following endpoint:
     * /company/storekeeper/order/available/
     */
    public function getAvailableSkisTest(ApiTester $I){
        $I->sendGet('/company/storekeeper/order/available');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, json_decode($I->grabResponse()));
        $I->seeResponseContainsJson(['order_no' => 10007, 'total_price' => 34000, 'status' => 'skis_available', 'customer_id'=>10000, 'shipment_no'=>10000]);
    }


    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/company/storekeeper/order/{:id}{?state=ready}}
     */
    public function changeStatusReady(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/storekeeper/order/10006?state=ready');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'ready', 'customer_id'=>10002, 'shipment_no'=>10001]));
        $I->seeInDatabase(['order_no' => 10006, 'total_price' => 2500, 'status' => 'ready', 'customer_id'=>10002, 'shipment_no'=>10001]);
    }

    /*
     * Method for creating a shipment
     * Tests the following endpoint:
     * /company/customer-rep/shipment/
     * TODO FÅ TAK I SHIPMENT ID
     */
    public function createShipmentTest(ApiTester $I){
        $I->sendPost('/company/costumer-rep/shipment/{:id}', [
            'customer_name' => 'XXL',
            'pickup_date' => '21.05.2022',
            'state' => '0',
            'driver_id' => 2,
            'transporter' => 'Gro Anitas postservice',
            'address_id' => 10001]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'shipment_no' =>'integer',
            'store_franchise_name' => 'string',
            'pickup_date' => 'date',
            'state' => 'integer',
            'transporter' => 'string',
            'driver_id' => 'integer']);

        $I->seeResponseContainsJson(array(['shipment_no' =>'FIKS D HER','customer_name' => 'XXL', 'pickup_date' => '21.05.2022', 'state' => '0', 'driver_id' => 2, 'transporter' => 'Gro Anitas postservice', 'address_id' => 10001]));
        $I->seeInDatabase(['shipment_no' =>'FIKS D HER','customer_name' => 'XXL', 'pickup_date' => '21.05.2022', 'state' => '0', 'driver_id' => 2, 'transporter' => 'Gro Anitas postservice', 'address_id' => 10001]);
    }

    /*
     * Method for creating a ski
     * Tests the following endpoint:
     * /company/storekeeper/ski/
     */
    public function createSkiTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/storekeeper/ski',[
            'model'=> 'Active',
            'ski_type'=>'classic',
            'temperature'=>'warm',
            'grip_system'=>'wax',
            'size'=>225,
            'weight_class'=>'20-30',
            'description'=>'Test ski',
            'historical'=>0,
            'photo_url'=>'u/tull/bildet',
            'retail_price'=>3600,
            'production_date'=>'21.07.2035']);

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

        $I->seeResponseContainsJson(array(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'warm', 'grip_system'=>'wax', 'size'=>225, 'weight_class'=>'20-30', 'description'=>'Test ski', 'historical'=>0, 'photo_url'=>'u/tull/bildet', 'retail_price'=>3600, 'production_date'=>'21.07.2035']));
        $I->seeInDatabase(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'warm', 'grip_system'=>'wax', 'size'=>225, 'weight_class'=>'20-30', 'description'=>'Test ski', 'historical'=>0, 'photo_url'=>'u/tull/bildet', 'retail_price'=>3600, 'production_date'=>'21.07.2035']);
    }

    /*
     * Method for uploading a production plan
     * Tests the following endpoint:
     * /company/planner/production
     */
    public function uploadPlanTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/planner/production', [
            'start_date'=> '25-04-2021',
            'end_date'=>'22-05-2021',
            'no_of_skis_per_day'=>1600,
            'production_planner_number'=>10004]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'start_date'=> 'date',
            'end_date'=>'date',
            'no_of_skis_per_day'=>'integer',
            'production_planner_number'=>'integer']);

        $I->seeResponseContainsJson(array([ 'start_date'=> '25-04-2021', 'end_date'=>'22-05-2021', 'no_of_skis_per_day'=>1600, 'production_planner_number'=>10004]));
        $I->seeInDatabase([ 'start_date'=> '25-04-2021', 'end_date'=>'22-05-2021', 'no_of_skis_per_day'=>1600, 'production_planner_number'=>10004]);
    }
}