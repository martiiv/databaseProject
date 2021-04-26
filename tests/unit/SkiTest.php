<?php

/**
 * Class SkiTest created for running unit tests on the ski_type entity
 * Has the following functions:
 *                              testCreateResource
 *                              testUpdateResource
 *                              testDeleteResource
 * @author Martin Iversen
 * @date 26.04.2021
 * @version 0.8
 */
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

    /**
     * Function testCreateResource
     * Creates a ski_type in the database
     */
    public function testCreateResource()
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

    /**
     * Function testUpdateResource
     * Updates the historical value of a ski_type
     * The historical value can only be set to one(1) indicating that the ski_type is out of production
     * @throws APIException if the historical value is 0
     */
    public function testUpdateResource(){
        $arr = array(
            'ski_model' => 'Active',
            'historical' => 1
        );

        $skiModelHandler = new SkiModelHandler();
        $updateSkiModelStatement = $skiModelHandler->updateResource($arr);
        $this->assertNotEquals(null,$updateSkiModelStatement);
    }

    /**
     * Function testDeleteResource
     * Deletes the Active Pro ski_type from the database
     */
    public function testDeleteResource(){
        $ski_model = 'Active Pro';
        $ski_modelTemp = 'Succesfully deleted ski type with ski model name '.strval($ski_model).'.';

        $skiModelHandler = new SkiModelHandler();
        $deletedSkiType = $skiModelHandler->deleteResource($ski_model);
        $this->assertEquals($deletedSkiType, $ski_modelTemp);
    }


}