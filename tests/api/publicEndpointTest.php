<?php
/*
 * fil for public endpoint testing
 * Martin Iversen
 * 22.03.2021
 */
class publicEndpointTest{
    public function getSkiisTest(ApiTester $I){
        $I->sendGet('/public');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['model'=> 'X547Jegvetikke',
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
    }
}
