<?php
/*
 * Fil som inneholder alle endpoint testene som angår company endpointet
 * Martin Iversen
 * 07.04.2021
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
        $I->sendGet('/company/customer-rep/order/15231');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([   'order_no'=> 15231,
                                        'total_price'=>2500,
                                        'status'=>'new',
                                        'customer_id'=>3,
                                        'shipment_no'=>1]);
    }

    /*
     * Metode som endrer statusen til en ordre fra ny til open
     * Returnerer ordre med ny status
     */
    public function changeStatusTestOpen(ApiTester $I){
        $I->sendPut('/company/costumer-rep/order/15231?status=open');
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)
        [   'order_no' => 15231,
            'total_price' => 345000,
            'status' => 'open',
            'customer_id'=>3,
            'shipment_no'=>1]);
    }

    /*
     * Metode som endrer statusen til en ordre fra ny til open
     * Returnerer ordre med ny status
     */
    public function changeStatusTestAvailable(ApiTester $I){
        $I->sendPut('/company/costumer-rep/order/15231?status=skis_available');
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)
        [   'order_no' => 15231,
            'total_price' => 345000,
            'status' => 'skis_available',
            'customer_id'=>3,
            'shipment_no'=>1]);
    }

    /*
     * Metode som lager en shipment
     * Returnerer shipment
     */
    public function createShipmentTest(ApiTester $I){
        $I->sendPut('/company/costumer-rep/shipment/',[ 'shipment_no' =>3,
                                                            'store_franchise_name' => 'XXL',
                                                            'pickup_date' => '2021-05-31',
                                                            'state' => 0,
                                                            'transporter' => 'Einars levering',
                                                            'driver_id' => 2]);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'shipment_no' =>3,
                                    'store_franchise_name' => 'XXL',
                                    'pickup_date' => '2021-05-31',
                                    'state' => 0,
                                    'transporter' => 'Einars levering',
                                    'driver_id' => 2]);
    }

    /*
     * Metode som lager en ny type ski
     * Returnerer en ski
     */
    public function createSkiTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/storekeeper/ski', [  'model'=> 'Active',
                                                        'ski_type'=>'classic',
                                                        'temperature'=>'warm',
                                                        'grip_system'=>'wax',
                                                        'size'=>225,
                                                        'weight_class'=>'20-30',
                                                        'description'=>'bra ski',
                                                        'historical'=>0,
                                                        'photo_url'=>'u/tull/bildet',
                                                        'retail_price'=>3600,
                                                        'production_date'=>'21.07.2035']);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'model'=> 'Active',
                                    'ski_type'=>'classic',
                                    'temperature'=>'warm',
                                    'grip_system'=>'wax',
                                    'size'=>225,
                                    'weight_class'=>'20-30',
                                    'description'=>'bra ski',
                                    'historical'=>0,
                                    'photo_url'=>'u/tull/bildet',
                                    'retail_price'=>3600,
                                    'production_date'=>'21.07.2035']);
    }

    /*
     * Metode som henter alle ordre med 'skiis available'
     * Returnerer ordre
     */
    public function getAvailableSkisTest(ApiTester $I){
        $I->sendGet('/company/storekeeper/order/available');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['order_no' => 15231,
                                     'total_price' => 345000,
                                     'status' => 'skis_available',
                                     'customer_id'=>3,
                                     'shipment_no'=>1]);
    }

    /*
     * Endrer status på en ordre fra skiis available til ready
     * Returnerer ordre
     */
    public function changeStateTestReady(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/company/storekeeper/order/15231?state=ready');
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'order_no' => 15231,
                                    'total_price' => 345000,
                                    'status' => 'ready',
                                    'customer_id'=>3,
                                    'shipment_no'=>1]);
    }

    /*
     * Legger production plan inn i databasen
     * Returnerer production plan
     */
    public function uploadPlanTest(ApiTester $I){
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/company/planner/production', [   'start_date'=> '25-04-2021',
                                                            'end_date'=>'22-05-2021',
                                                            'no_of_skis_per_day'=>1600,
                                                            'production_planner_number'=>3]);
        $I->seeResponseCodeIs(201);
        $I->seeInDatabase((string)[ 'start_date'=> '25-04-2021',
                                    'end_date'=>'22-05-2021',
                                    'no_of_skis_per_day'=>1600,
                                    'production_planner_number'=>3]);
    }
}

