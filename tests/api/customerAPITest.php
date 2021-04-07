<?php
/*
 * Fil som inneholder alle endpoint testene som angår company endpointet
 * Martin Iversen
 * 22.03.2021
 */
class customerAPITest{

    /*
     * Metode som henter ut en kundes ordre
     * Returnerer ordre
     * TODO HVA faen betyr since
     */
    public function listOrdersTest(ApiTester $I){
        $I->sendGet('/customer/order/2?since={:since}}');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no'=> '12478',
                                     'total_price'=>'12000',
                                     'status'=>'new',
                                     'customer_id'=>2,
                                     'shipment_no'=>'NULL']);
    }

    /*
     * Metode som lister en spesifikk ordre som er knyttet til en kunde
     * Returnerer en ordre
     */
    public function listSpecificOrderTest(ApiTester $I){
        $I->sendGet('/customer/order/1/15232');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no'=> 15232,
                                     'total_price'=>34000,
                                     'status'=>'new',
                                     'customer_id'=>1,
                                     'shipment_no'=>NULL]);
    }

    /*
     * Metode som lager en ordre
     * Returnerer den lagde ordren
     */
    public function addOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/customer/order/place/1', [   'order_no'=> 'selvlaga',
                                                        'total_price'=>25000,
                                                        'status'=>'new',
                                                        'customer_id'=>1,
                                                        'shipment_no'=>NULL]);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'order_no'=> 'selvlaga',
                                    'total_price'=>25000,
                                    'status'=>'new',
                                    'customer_id'=>1,
                                    'shipment_no'=>NULL]);
    }

    //TODO Status kode for delete og no greier med sletting
    public function cancelOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/customer/order/cancel/{:customer_id}/19324');
        $I->seeResponseCodeIs("sletta");
    }

    /*
     * Metode som splitter en ordre i to
     * Returnerer den nye ordren
     */
    public function splitOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/customer/order/3/15231/split', [ 'order_no'=> 'Selvgenerert']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'order_no' => 'selvgenerert',
                                    'total_price' => 0,
                                    'status' => 'new',
                                    'customer_id'=>3,
                                    'shipment_no'=>NULL]);
    }

    /*
     * Metode som henter production plannen
     * Returnerer production_plan
     * TODO BrUh
     */
    public function getProductionPlanTest(ApiTester $I){
        $I->sendGet('/customer/production');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([   'production_plan_period'=> '',
                                        'no_of_skis'=>'']);
    }
}
