<?php
require_once 'Authorisation.php';

class CompanyEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    /*
     * Method for creating a ski
     * Tests the following endpoint:
     * /company/storekeeper/ski/
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
            'product_number'=>'string',
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
            ['production_date'=>date("Y/m/d"),'ski_type'=>'Redline']);}

}
