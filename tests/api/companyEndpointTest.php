<?php
/*
 * Fil som inneholder alle endpoint testene som angår company endpointet
 * Martin Iversen
 * 22.03.2021
 */
class ccompanyEndpointTest{

    public function _before(ApiTester $I){
        //Vetikkehvaviskalputteinnher
    }

    /*
     * Metode for testing av get orders
     * Skal returnere ordre
     */
    public function getOrderTest(ApiTester $I){
        $I->sendGet('/company/customer-rep/order');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no'=> '{:id}',
            'ski_type'=>'klassisk',
            'total_price'=>'345000',
            'status'=>'new']);
    }

    /*
     * Metode som endrer statusen til en ordre fra ny til open
     * Returnerer ordre med ny status
     */
    public function changeStateTestOpen(ApiTester $I){
        $I->sendPut('/company/costumer-rep/order/{:id}{?state={:state}}', [ 'order_no'=> '{:id}',
                                                      'status'=>'open']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['order_no' => '{:id}',
            'ski_type' => 'klassisk',
            'total_price' => '345000',
            'status' => 'open']);
    }

    /*
     * Metode som lager en shipment
     * Returnerer shipment
     */
    public function createShipmentTest(ApiTester $I){
        $I->sendPut('/company/costumer-rep/shipment/');
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['shipment_no' => '',
            'store_franchise_name' => '',
            'pickup_date' => '',
            'state' => '',
            'transporting_company' => '',
            'driver_id' => '']);

    }

    /*
     * Metode som lager en ny type ski
     * Returnerer en ski
     */
    public function createSkiTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/storekeeper/ski/{:id}', [  'model'=> 'X547Jegvetikke',
                                                    'ski_type'=>'klassisk',
                                                    'temperature'=>'(-15)-(-20)',
                                                    'grip_system'=>'JEgaNerIkKe',
                                                    'size'=>'225',
                                                    'weight_class'=>'85kg',
                                                    'description'=>'bra ski',
                                                    'historical'=>'JegVetIkke',
                                                    'photo_url'=>'u/tull/bildet',
                                                    'retail_price'=>'225',
                                                    'production_date'=>'21.07.2035']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['model' => 'X547Jegvetikke',
            'ski_type' => 'klassisk',
            'temperature' => '(-15)-(-20)',
            'grip_system' => 'JEgaNerIkKe',
            'size' => '225',
            'weight_class' => '85kg',
            'description' => 'bra ski',
            'historical' => 'JegVetIkke',
            'photo_url' => 'u/tull/bildet',
            'retail_price' => '225',
            'production_date' => '21.07.2035']);
    }

    /*
     * Metode som henter alle ordre med 'skiis available'
     * Returnerer ordre
     */
    public function getAvailableSkisTest(ApiTester $I){
        $I->sendGet('/company/storekeeper/order/available');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([   'order_no'=> '',
                                        'ski_type'=>'',
                                        'total_price'=>'',
                                        'status'=>'skiis available']);
    }

    /*
     * Endrer status på en ordre fra skiis available til ready
     * Returnerer ordre
     */
    public function changeStateTestReady(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/storekeeper/order/{:id}{?state={:state}}', [    'order_no'=> '{:id}',
                                                        'status'=>'open']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['order_no' => '{:id}',
            'ski_type' => 'klassisk',
            'total_price' => '345000',
            'status' => 'Ready to be shipped']);
    }

    /*
     * Legger production plan inn i databasen
     * Returnerer production plan
     */
    public function uploadPlanTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/planner/production', [   'production_plan_period'=> '(25-04-2021)-(22-05-2021)',
                                                        'no_of_skis'=>'2255']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)['production_plan_period' => '(25-04-2021)-(22-05-2021)',
            'no_of_skis' => '2255']);
    }
}

