<?php

class SkiTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateRecource()
    {
        $array = array(
            'model'=> 'UnitTestSki',
            'ski_type'=>'classic',
            'temperature'=>'warm',
            'grip_system'=>'wax',
            'size'=>240,
            'weight_class'=>'120-130',
            'description'=>'Ski created for a unit test',
            'historical'=>0,
            'photo_url'=>'u/tull/unit_test_ski',
            'retail_price'=>16000);

        $skiModelHandler = new SkiModelHandler();
        $newSki = $skiModelHandler -> createResource($array);
        $this -> assertNotEquals(0,$newSki);
    }

    public function testUpdateResource(){
        $arr = array(
            'ski_model' => 'Active',
            'historical' => 1
        );

        $skiModelHandler = new SkiModelHandler();
        $updateSkiModelStatement = $skiModelHandler->updateResource($arr);
        $this->assertNotEquals(null,$updateSkiModelStatement);
    }


}