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
        $I->seeResponseContainsJson(['order_no'=> '',
                                     'ski_type'=>'',
                                     'total_price'=>'',
                                     'status'=>'ready to be shipped']);
    }
    public function updateShipmentsTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/transporter/shipment/{:id}', [ 'shipment_no'=> '{:id}',
                                                     'status'=>'true']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase( ['shipment_no'=> '',
                            'store_franchise_name'=>'',
                            'pickup_date'=>'',
                            'state'=>'true',
                            'transporting_company'=>'',
                            'driver_id'=>''  ]);
    }
}
