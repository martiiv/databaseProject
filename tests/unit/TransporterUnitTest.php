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

    /**
     * Function testDeleteResource
     *
     * Test the deletion process of a transporter from the database.
     *
     * If the deletion take place, it returns true.
     *
     * Assert if this returned value is true.
     */
    public function testDeleteResource()
    {
        $name = "Ole Joar's Pickup Service";
        $deletedTemp = true;

        $transporterHandler = new TransporterHandler();
        $deletedTransporter = $transporterHandler->deleteResource($name);
        $this->assertEquals($deletedTransporter, $deletedTemp);
    }
}