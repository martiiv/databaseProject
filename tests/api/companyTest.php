<?php

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
    }

    /*
     * Method for getting orders
     * Tests the following endpoint:
     * /company/customer-rep/order
     */
    public function getOrders()
    {

        $this->I->haveHttpHeader('Content-Type', 'application/json');
        $this->I->sendGet('/company/customer-rep/order/');
        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->assertEquals(1, count(json_decode($this->I->grabResponse())));
        $this->I->seeResponseContainsJson(array(['order_no' => 10005, 'total_price' => 12000, 'status' => 'ready', 'customer_id' => 10001, 'shipment_no' => NULL]));
    }

    /*
     * Method for getting specific order
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}
     */
    public function getOrder()
    {
        $this->I->haveHttpHeader('Content-Type', 'application/json');
        $this->I->sendGet('/company/customer-rep/order/10006');
        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->assertEquals(1, count(json_decode($this->I->grabResponse())));
        $this->I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'new', 'customer_id' => 10002, 'shipment_no' => 10001]));

    }

    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=open}}
     */
    public function changeStatusOpen()
    {
        $this->I->sendPut('/company/costumer-rep/order/10006?status=open');

        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'open', 'customer_id' => 10002, 'shipment_no' => 10001]));
        $this->I->seeInDatabase('orders', ['order_no' => 10006, 'total_price' => 2500, 'status' => 'open', 'customer_id' => 10002, 'shipment_no' => 10001]);
    }

    /*
     * Method for changing the status of an order from open to available
     * Tests the following endpoint:
     * /company/customer-rep/order/{:id}{?state=available}}
     */
    public function changeStatusAvailable()
    {
        $this->I->haveHttpHeader('Content-Type', 'application/json');
        $this->I->sendPut('/company/costumer-rep/order/10006?status=skis_available');

        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'skis_available', 'customer_id' => 10002, 'shipment_no' => 10001]));
        $this->I->seeInDatabase('orders', ['order_no' => 10006, 'total_price' => 2500, 'status' => 'skis_available', 'customer_id' => 10002, 'shipment_no' => 10001]);
    }

    /*
     * Method for getting all the available skiis
     * Tests the following endpoint:
     * /company/storekeeper/order/available/
     */
    public function getAvailableSkisTest()
    {
        $this->I->sendGet('/company/storekeeper/order/available');
        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->assertEquals(1, json_decode($this->I->grabResponse()));
        $this->I->seeResponseContainsJson('orders', ['order_no' => 10007, 'total_price' => 34000, 'status' => 'skis_available', 'customer_id' => 10000, 'shipment_no' => 10000]);
    }


    /*
     * Method for changing the status of an order from new to open
     * Tests the following endpoint:
     * /company/company/storekeeper/order/{:id}{?state=ready}}
     */
    public function testStatusReady()
    {
        $this->I->haveHttpHeader('Content-Type', 'application/json');
        $this->I->sendPut('/company/storekeeper/order/10006?state=ready');

        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $this->I->seeResponseContainsJson(array(['order_no' => 10006, 'total_price' => 2500, 'status' => 'ready', 'customer_id' => 10002, 'shipment_no' => 10001]));
        $this->I->seeInDatabase('orders', ['order_no' => 10006, 'total_price' => 2500, 'status' => 'ready', 'customer_id' => 10002, 'shipment_no' => 10001]);
    }

    /*
     * Method for creating a shipment
     * Tests the following endpoint:
     * /company/customer-rep/shipment/
     * TODO Sjekk om kan kjøre uten shipment id i seeindatabase()
     */
    public function testCreateShipmentTest()
    {
        $this->I->sendPost('/company/costumer-rep/shipment/{:id}', [
            'customer_name' => 'XXL',
            'pickup_date' => '21.05.2022',
            'state' => '0',
            'driver_id' => 2,
            'transporter' => 'Gro Anitas postservice',
            'address_id' => 10001]);

        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'shipment_no' => 'integer',
            'store_franchise_name' => 'string',
            'pickup_date' => 'date',
            'state' => 'integer',
            'transporter' => 'string',
            'driver_id' => 'integer']);

        $this->I->seeResponseContainsJson(array(['customer_name' => 'XXL', 'pickup_date' => '21.05.2022', 'state' => '0', 'driver_id' => 2, 'transporter' => 'Gro Anitas postservice', 'address_id' => 10001]));
        $this->I->seeInDatabase('shipments', ['customer_name' => 'XXL', 'pickup_date' => '21.05.2022', 'state' => '0', 'driver_id' => 2, 'transporter' => 'Gro Anitas postservice', 'address_id' => 10001]);
    }

    /*
     * Method for creating a ski
     * Tests the following endpoint:
     * /company/storekeeper/ski/
     */
    public function testCreateSki(\ApiTester $I)
    {
        $I->haveHttpHeader('content-type','application/json');
        $I->sendPost('/storekeeper/ski',[
            'Active'=>2,
            'Redline'=>5]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'production_number'=>'string',
            'production_date'=>'string',
            'ski_type'=>'string']);

        $I->seeResponseContainsJson(array(  ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline']));
        $I->seeInDatabase('products',  ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline']);}

    /*
     * Method for uploading a production plan
     * Tests the following endpoint:
     * /company/planner/production
     */
    public function testUploadPlanTest()
    {
        $this->I->haveHttpHeader('Content-Type', 'application/json');
        $this->I->sendPost('/company/planner/production', [
            'start_date' => '25-04-2021',
            'end_date' => '22-05-2021',
            'no_of_skis_per_day' => 1600,
            'production_planner_number' => 10004]);

        $this->I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $this->I->seeResponseIsJson();
        $this->I->seeResponseMatchesJsonType([
            'start_date' => 'date',
            'end_date' => 'date',
            'no_of_skis_per_day' => 'integer',
            'production_planner_number' => 'integer']);

        $this->I->seeResponseContainsJson(array(['start_date' => '25-04-2021', 'end_date' => '22-05-2021', 'no_of_skis_per_day' => 1600, 'production_planner_number' => 10004]));
        $this->I->seeInDatabase('production_plan', ['start_date' => '25-04-2021', 'end_date' => '22-05-2021', 'no_of_skis_per_day' => 1600, 'production_planner_number' => 10004]);
    }

}