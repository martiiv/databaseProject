<?php
/*
 * Fil som inneholder tester for transporter endpointet
 * Martin Iversen
 * 22.03.2021
 */
class transporterEndpointTest{
    public function getOrderShipmentTest(ApiTester $I){
        $I->sendGet('/transporter/shipment');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no' => 15231,
                                     'total_price' => 345000,
                                     'status' => 'ready',
                                     'customer_id'=>3,
                                     'shipment_no'=>1]);
    }

    /*
     * Updates a shipment and sets state to 1 instead of 0
     */
    public function updateShipmentsTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/transporter/shipment/1');
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'shipment_no' => 1,
                                    'store_franchise_name' => 'XXL',
                                    'pickup_date' => '2021-04-25',
                                    'state' => 1,
                                    'transporting_company' => 'Einars levering',
                                    'driver_id' => 2]);
    }
}
