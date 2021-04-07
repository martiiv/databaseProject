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
     */
    public function listOrdersTest(ApiTester $I){
        $I->sendGet('/customer/order/{:customer_id?since={:since}}');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no'=> '{:id}',
                                     'ski_type'=>'',
                                     'total_price'=>'',
                                     'status'=>'']);
    }

    /*
     * Metode som lister en spesifikk ordre som er knyttet til en kunde
     * Returnerer en ordre
     */
    public function listSpecificOrderTest(ApiTester $I){
        $I->sendGet('/customer/order/{:customer_id}}/{:order_id}');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no'=> '{:order_id}',
                                     'ski_type'=>'',
                                     'total_price'=>'',
                                     'status'=>'']);
    }

    /*
     * Metode som lager en ordre
     * Returnerer den lagde ordren
     */
    public function addOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/customer/order/place/{:customer_id}', [ 'order_no'=> '',
                                                'ski_type'=>'klassisk',
                                                'total_price'=>'345000',
                                                'status'=>'new']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['order_no' => 'AUTOMATISK',
            'ski_type' => 'klassisk',
            'total_price' => '345000',
            'status' => 'new']);
    }

    public function cancelOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/customer/order/cancel/{:customer_id}/{:order_id}', [ 'order_no'=> '',
            'ski_type'=>'klassisk',
            'total_price'=>'345000',
            'status'=>'new']);
        $I->seeResponseCodeIs("sletta");
        $I->seeInDatabase((string)['order_no' => '{:order_id}',
            'ski_type' => 'klassisk',
            'total_price' => '345000',
            'status' => 'new']);
    }

    /*
     * Metode som splitter en ordre i to
     * Returnerer den nye ordren
     */
    public function splitOrderTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/customer/order/{:customer_id}/{:order:id}/split', [ 'order_no'=> '{:id}']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['order_no' => 'NY ID AUTO',
            'ski_type' => '',
            'total_price' => '',
            'status' => '']);
    }

    /*
     * Metode som henter production plannen
     * Returnerer production_plan
     */
    public function getProductionPlanTest(ApiTester $I){
        $I->sendGet('/customer/production');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([   'production_plan_period'=> '',
                                        'no_of_skis'=>'']);
    }
}
