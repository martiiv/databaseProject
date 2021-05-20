<?php
require_once "db/SkiModel.php";

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
     * @var UnitTester
     */
    protected UnitTester $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Function testCreateResource
     * Sends in data to simulate ski creation
     * Uses the createResource from the SkiModel(Handler) to test functionality
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

        $skiModel = new SkiModel();
        $newSki = $skiModel->createResource($array);
        $this -> assertNotEquals(0,$newSki);
    }

    /**
     * Function testUpdateResource
     * Updates the historical value of a ski_type
     * Uses updateResource from SkiModel(handler) to update a ski_types historical value
     * The historical value can only be set to one(1) indicating that the ski_type is out of production
     * @throws APIException if the historical value is 0
     */
    public function testUpdateResource(){
        $arr = array(
            'model' => 'Active',
            'historical' => 1
        );

        $skiModel = new SkiModel();
        $updateSkiModelStatement = $skiModel->updateResource($arr);

        $this->tester->seeInDatabase('ski_type',['model'=>'Active', 'historical'=>1]);
        $this->assertNotEquals(null,$updateSkiModelStatement);
    }
}