<?php
require_once 'Authorisation.php';


/**
 * Class CustomerEndpointCest made for testing Customer endpoint
 * Tests:
 *      getMyOrders()       DONE For listing a customers orders with since
 *      getSpecificOrder()  DONE For getting an order with state information
 *      placeOrder()        DONE Place an order
 *      cancelOrder()       DONE Delete an order
 *      splitOrder()        TODO Request a split order NOT IMPLEMENTED
 *      getPlanSummary()    DONE Get production summary
 * @date    07.05.2021
 * @version 0.6
 */
class CustomerEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    public function getMyOrders(\ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('customer/order/10002');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'string',
            'created' => 'string',
            'total_price' => 'string',
            'status' => 'string',
            'customer_id' => 'string',
        ]);

        $I->dontSeeResponseContainsJson(array(['customer_id' => '10001']));
        $I->seeResponseContainsJson(array(['customer_id' => '10002']));
    }

    public function getSpecificOrder(\ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('customer/order/10002/10006');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'string',
            'total_price' => 'string',
            'status' => 'string',
            'customer_id' => 'string',
            'shipment_no' => 'string'
        ]);

        $I->seeResponseContainsJson(array(['order_no' => '10006', 'total_price' => '2500', 'status' => 'new', 'customer_id' => '10002', 'shipment_no' => '10001']));
    }

    public function placeOrder(\ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);

        $I->sendPost('customer/order/place/10001', [
            'Active' => 2,
            'Intrasonic' => 4
        ]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'Order_no' => 'integer',
            'Total Price' => 'integer',
            'Items Ordered' => [
                'Active' => 'integer',
                'Intrasonic' => 'integer'
            ]]);

        $I->seeResponseContainsJson([
            'Total Price' => 8400,
            'Items Ordered' => [
                'Active' => 2,
                'Intrasonic' => 4
            ]]);

        $I->seeInDatabase('orders', ['total_price' => 8400, 'status' => 'new', 'customer_id' => 10001, 'shipment_no' => NULL]);
        $I->seeInDatabase('order_items',
            ['ski_type' => 'Active', 'amount' => 2],
            ['ski_type' => 'Intrasonic', 'amount' => 4]);
    }

    public function cancelOrder(\ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendDelete('customer/order/cancel/10002/10006');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->seeInDatabase('orders', ['order_no' => 10006, 'status' => 'canceled', 'customer_id' => 10002]);
    }

    public function splitOrder(\ApiTester $I)
    {

    }

    public function getPlanSummary(\ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('customer/production');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'Active Pro' => 'integer',
            'Race Pro' => 'integer',
            'Redline' => 'integer',
        ]);
        $I->seeResponseContainsJson(["Active Pro" => 2505, "Race Pro" => 7900, "Redline" => 2600]);
    }
}
