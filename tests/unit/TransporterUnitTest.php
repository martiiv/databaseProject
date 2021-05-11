<?php
require_once "controller/Handlers/TransporterHandler.php";
require_once "db/TransporterModel.php";

class TransporterUnitTest extends \Codeception\Test\Unit
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
    public function testDeleteResource()
    {
        $name = "Ole Joar's Pickup Service";
        $deletedTemp = true;

        $transporterHandler = new TransporterHandler();
        $deletedTransporter = $transporterHandler->deleteResource($name);
        $this->assertEquals($deletedTransporter, $deletedTemp);
    }
}