<?php

class publicTest extends \Codeception\Test\Unit
{
    /**
     * @var \ApiTester
     */
    protected $I;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function getSkiisTest(ApiTester $I){
        $I->sendGet('/public?model=Active');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['model'=> 'Active',
            'ski_type'=>'classic',
            'temperature'=>'cold',
            'grip_system'=>'wax',
            'size'=>142,
            'weight_class'=>'20-30',
            'description'=>'Bra ski',
            'historical'=>0,
            'photo_url'=>'bildet',
            'retail_price'=>'1200',
            'production_date'=>'2021-03-20']);
    }
}