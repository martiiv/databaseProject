<?php
require_once "db/TransporterModel.php";

class TransporterUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    
    protected function _before()
    {

    }

    protected function _after()
    {

    }

    // tests
    public function testDeleteResource()
    {
        $name = "Ole Joar's Pickup Service";
        $deletedTemp = true;

        $transporterModel = new TransporterModel();
        $deletedTransporter = $transporterModel->deleteResource($name);
        $this->assertEquals($deletedTransporter, $deletedTemp);
    }
}