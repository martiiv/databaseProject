<?php
require_once "controller/Handlers/ShipmentHandler.php";
require_once "db/ShipmentModel.php";

class ShipmentTest extends \Codeception\Test\Unit
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
    public function testGetCollection()
    {
        $shipmentHandler = new ShipmentHandler();
        $shipments = $shipmentHandler->getCollection();
        foreach ($shipments as $shipment) {
            print(json_encode($shipment));
            print("\n");
        }
    }

    // tests
    public function testGetResource()
    {
        $shipmentHandler = new ShipmentHandler();
        $shipments = $shipmentHandler->getResource(1);
        print(json_encode($shipments));
    }
}