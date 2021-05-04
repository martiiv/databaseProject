<?php
require_once 'Authorisation.php';

/**
 * Class CompanyEndpointCest made for api tests in Company endpoint
 * Tests:
 *       Customer rep:
 *                  testGetOrderNew()           DONE Get order on state
 *                  testChangeStateOpen         DONE Change to open
 *                  testChangeStateAvailable    DONE Change to available
 *                  testCreateShipment          TODO Create shipment
 *      Storekeeper:
 *                  testCreateSki               DONE Create product
 *                  testChangeStateReady        DONE Change to ready
 *                  testGetOrderAvailable       TODO Get order on state
 *      Production Planner:
 *                  testUploadPlan              TODO Upload production plan
 * @date 04.05.2021
 * @version 0.6
 */
class CompanyEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * Function for testing get order functionality
     * Tests the following endpoint:
     *      http://localhost/dbproject-33/customer-rep/order?state=new
     * Lets a customer-rep get orders based on state
     * @param ApiTester $I
     */
    public function testGetOrderNew(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('http://localhost/dbproject-33/customer-rep/order?state=new');
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'string',
            'created'=>'string',
            'total_price' => 'string',
            'status' => 'string',
            'customer_id' => 'string',
        ]);

        $I->dontSeeResponseContainsJson(array(['status' => 'open','shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'available','shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'ready','shipment_no' => NULL]));
        $I->seeResponseContainsJson(array(['status' => 'new','shipment_no' => NULL]));
    }

    /**
     * Function for testing get order functionality
     * Tests the following endpoint:
     *      http://localhost/dbproject-33/customer-rep/order?state=ready
     * Lets a customer-rep get orders based on state
     * @param ApiTester $I
     */
    public function testGetOrderReady(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('http://localhost/dbproject-33/customer-rep/order?state=ready');
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'string',
            'created'=>'string',
            'total_price' => 'string',
            'status' => 'string',
            'customer_id' => 'string',
        ]);

        $I->dontSeeResponseContainsJson(array(['status' => 'new','shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'open','shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'available','shipment_no' => NULL]));
        $I->seeResponseContainsJson(array(['status' => 'ready','shipment_no' => NULL]));
    }

    /**
     * Function for testing change order functionality
     * Tests the following endpoint:
     *      http://localhost/dbproject-33/customer-rep/order/state/order_no'
     *
     * Lets a customer-rep change orders based on state
     * @param ApiTester $I
     */
    public function testChangeStateOpen(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendPut('customer-rep/order/open/10006');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('Status of order 10006 changed to open!'));
        $I->seeInDatabase('orders', ['order_no' => 10006, 'total_price' => 2500, 'status' => 'open', 'customer_id' => 10002, 'shipment_no' => 10001]);
    }

    /**
     * Function for testing change order functionality
     * Tests the following endpoint:
     *      http://localhost/dbproject-33/customer-rep/order/state/order_no'
     *
     * Lets a customer-rep change orders based on state
     * @param ApiTester $I
     */
    public function testChangeStateAvailable(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendPut('customer-rep/order/available/10008');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('Status of order 10008 changed to available!'));
        $I->seeInDatabase('orders', ['order_no' => 10008, 'total_price' => 2000, 'status' => 'available', 'customer_id' => 10002, 'shipment_no' => NULL]);
    }

    /**
     * Method for creating products
     * Tests the following endpoint:
     * http://localhost/dbproject-33/storekeeper/ski/
     * With the body:
     * {
     *      'Active':2,
     *      'Redline':3
     * }
     * Lets a storekeeper produce skis
     */
    public function testCreateSki(\ApiTester $I)
    {

        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);

        $I->sendPost('storekeeper/ski',[
            'Active'=>2,
            'Redline'=>3
        ]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'product_no'=>'string',
            'production_date'=>'string',
            'ski_type'=>'string']);

        $I->seeResponseContainsJson(array(
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Active',
                'production_date'=>date("Y/m/d"),'ski_type'=>'Active',
                'production_date'=>date("Y/m/d"),'ski_type'=>'Redline',
                'production_date'=>date("Y/m/d"),'ski_type'=>'Redline',
                'production_date'=>date("Y/m/d"),'ski_type'=>'Redline']));
        $I->seeInDatabase('product',  ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Active'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline'],
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline']);
    }

    /**
     * Function for testing change order functionality
     * Tests the following endpoint:
     *      http://localhost/dbproject-33/customer-rep/order/state/order_no'
     *
     * Lets a storekeeper change orders based on state
     * @param ApiTester $I
     */
    public function testChangeStateReady(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendPut('storekeeper/order/ready/10006');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('Status of order 10006 changed to ready!'));
        $I->seeInDatabase('orders', ['order_no' => 10006, 'total_price' => 2500, 'status' => 'ready', 'customer_id' => 10002, 'shipment_no' => 10001]);
    }
}
