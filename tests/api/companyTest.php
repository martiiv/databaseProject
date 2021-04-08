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
        //TODO HER LEGGER VI INN EN ORDRE SOM VI KAN TESTE MED OGSÅ OPPDATERER VI I FUNKSJONENE UNDER
        //TODO HER LEGGER VI INN EN PRODUCTION PLAN SOM VI KAN TESTE MED OGSÅ OPPDATERER VI I FUNKSJONENE UNDER
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
        $I->seeResponseContainsJson(array(['order_no'=> 15231, 'total_price'=>2500, 'status'=>'new', 'customer_id'=>3, 'shipment_no'=>1]));
    }

    /*
     * Method for getting specific order
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}
     */
    public function getOrder(ApiTester $I){
        $I->haveHttpHeader('Content-Type','application/json');
        $I->sendGet('/company/customer-rep/order/15231');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array(['order_no'=> 15231, 'total_price'=>2500, 'status'=>'new', 'customer_id'=>3, 'shipment_no'=>1]));

    }

    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=open}}
     */
    public function changeStatusOpen(ApiTester $I){
        $I->sendPut('/company/costumer-rep/order/15231?status=open',
            ['order_no' => 15231,
                'total_price' => 345000,
                'status' => 'open',
                'customer_id'=>3,
                'shipment_no'=>1]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 15231, 'total_price' => 345000, 'status' => 'open', 'customer_id'=>3, 'shipment_no'=>1]));
        $I->seeInDatabase(['order_no' => 15231, 'total_price' => 345000, 'status' => 'open', 'customer_id'=>3, 'shipment_no'=>1]);
    }

    /*
     * Method for changing the status of an order from open to available
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=available}}
     */
    public function changeStatusAvailable(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/costumer-rep/order/15231?status=available',
            ['order_no' => 15231,
                'total_price' => 345000,
                'status' => 'available',
                'customer_id'=>3,
                'shipment_no'=>1]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 15231, 'total_price' => 345000, 'status' => 'available', 'customer_id'=>3, 'shipment_no'=>1]));
        $I->seeInDatabase(['order_no' => 15231, 'total_price' => 345000, 'status' => 'available', 'customer_id'=>3, 'shipment_no'=>1]);
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
        $I->seeResponseContainsJson(['order_no' => 15231, 'total_price' => 345000, 'status' => 'skis_available', 'customer_id'=>3, 'shipment_no'=>1]);
    }


    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/company/storekeeper/order/{:id}{?state=ready}}
     */
    public function changeStatusReady(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/storekeeper/order/15231?state=ready',[
            'order_no' => 15231,
            'total_price' => 345000,
            'status' => 'ready',
            'customer_id'=>3,
            'shipment_no'=>1]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no'=> 'integer',
            'total_price'=>'integer',
            'status'=>'string',
            'customer_id'=>'integer',
            'shipment_no'=>'integer']);

        $I->seeResponseContainsJson(array(['order_no' => 15231, 'total_price' => 345000, 'status' => 'ready', 'customer_id'=>3, 'shipment_no'=>1]));
        $I->seeInDatabase(['order_no' => 15231, 'total_price' => 345000, 'status' => 'ready', 'customer_id'=>3, 'shipment_no'=>1]);
    }

    /*
     * Method for creating a shipment
     * Tests the following endpoint:
     * /company/customer-rep/shipment/
     */
    public function createShipmentTest(ApiTester $I){
        $I->sendPost('/company/costumer-rep/shipment/',[
            'shipment_no' =>4,
            'store_franchise_name' => 'XXL',
            'pickup_date' => '2021-05-31',
            'state' => 0,
            'transporter' => 'Einars levering',
            'driver_id' => 2]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'shipment_no' =>'integer',
            'store_franchise_name' => 'string',
            'pickup_date' => 'date',
            'state' => 'integer',
            'transporter' => 'string',
            'driver_id' => 'integer']);

        $I->seeResponseContainsJson(array([ 'shipment_no' =>3, 'store_franchise_name' => 'XXL', 'pickup_date' => '2021-05-31', 'state' => 0, 'transporter' => 'Einars levering', 'driver_id' => 2]));
        $I->seeInDatabase([ 'shipment_no' =>3, 'store_franchise_name' => 'XXL', 'pickup_date' => '2021-05-31', 'state' => 0, 'transporter' => 'Einars levering', 'driver_id' => 2]);
    }

    /*
     * Method for creating a ski
     * Tests the following endpoint:
     * /company/storekeeper/ski/{:id} //TODO ID må kanskje bort
     */
    public function createSkiTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/storekeeper/ski', [
            'model'=> 'Active',
            'ski_type'=>'classic',
            'temperature'=>'warm',
            'grip_system'=>'wax',
            'size'=>225,
            'weight_class'=>'20-30',
            'description'=>'bra ski',
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

        $I->seeResponseContainsJson(array(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'warm', 'grip_system'=>'wax', 'size'=>225, 'weight_class'=>'20-30', 'description'=>'bra ski', 'historical'=>0, 'photo_url'=>'u/tull/bildet', 'retail_price'=>3600, 'production_date'=>'21.07.2035']));
        $I->seeInDatabase(['model'=> 'Active', 'ski_type'=>'classic', 'temperature'=>'warm', 'grip_system'=>'wax', 'size'=>225, 'weight_class'=>'20-30', 'description'=>'bra ski', 'historical'=>0, 'photo_url'=>'u/tull/bildet', 'retail_price'=>3600, 'production_date'=>'21.07.2035']);
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
            'production_planner_number'=>3]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'start_date'=> 'date',
            'end_date'=>'date',
            'no_of_skis_per_day'=>'integer',
            'production_planner_number'=>'integer']);

        $I->seeResponseContainsJson(array([ 'start_date'=> '25-04-2021', 'end_date'=>'22-05-2021', 'no_of_skis_per_day'=>1600, 'production_planner_number'=>3]));
        $I->seeInDatabase([ 'start_date'=> '25-04-2021', 'end_date'=>'22-05-2021', 'no_of_skis_per_day'=>1600, 'production_planner_number'=>3]);
    }
}