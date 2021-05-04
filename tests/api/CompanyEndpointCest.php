<?php
require_once 'Authorisation.php';

class CompanyEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * Method for creating a ski
     * Tests the following endpoint:
     * /company/storekeeper/ski/
     * With the body 'ski_type':'amount':
     * {
     *   'Active':2
     *   'Redline':2
     * }
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
            'product_no'=>'integer',
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

    public function testGetOrderReady(\ApiTester $I){
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');

        Authorisation::setAuthorisationToken($I);
        $I->sendGet('customer-rep/order?state=ready');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'order_no' => 'integer',
            'created'=> 'string',
            'total_price' => 'integer',
            'status' => 'string',
            'customer_id' => 'integer',
            'shipment_no' => 'integer']);

        $I->dontSeeResponseContainsJson(array(['status' => 'new', 'shipment_no' => null]));
        $I->dontSeeResponseContainsJson(array(['status' => 'open', 'shipment_no' => null]));
        $I->dontSeeResponseContainsJson(array(['status' => 'available', 'shipment_no' => null]));
        $I->seeResponseContainsJson(array(['status' => 'ready', 'shipment_no' => null]));
    }
}
