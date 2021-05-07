<?php
require_once 'Authorisation.php';

/**
 * Class TransporterEndpointCest for testing the transporter endpoint
 * Tests:
 *       getOrders      DONE  Get orders ready for shipment
 *       changeShipment DONE  Change the state of the shipment after pickup
 */
class TransporterEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    public function getOrders(ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('transporter/orders');
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'order_no' => 'string',
            'created' => 'string',
            'total_price' => 'string',
            'status' => 'string',
            'customer_id' => 'string',
        ]);

        $I->dontSeeResponseContainsJson(array(['status' => 'open', 'shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'available', 'shipment_no' => NULL]));
        $I->dontSeeResponseContainsJson(array(['status' => 'new', 'shipment_no' => NULL]));
        $I->seeResponseContainsJson(array(['status' => 'ready']));
    }

    public function changeShipment(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendPut('transporter/pickup/10001');

        $I->seeResponseIsJson();
        $I->seeInDatabase('shipments', ['shipment_no' => 10001, 'state' => 1]);
    }
}
