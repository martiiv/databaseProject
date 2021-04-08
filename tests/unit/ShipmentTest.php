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
    public function testCreateResource()
    {
        // Delete this instance from the DB if you want to re-run the test
        // Optionally change the values
        $arr = array (
            'shipment_no' => 3,
            'store_franchise_name' => "Sport 1 Oslo",
            'pickup_date' => '2021-05-12',
            'state' => 0,
            'driver_id' => 3,
            'transporter' => "Magnus' transporting AS",
            'address_id' => 3,
        );

        $shipmentHandler = new ShipmentHandler();
        $newShipment = $shipmentHandler->createResource($arr);
        print(json_encode($newShipment));
        print(json_encode($arr));
        $this->assertEquals(json_encode($newShipment), json_encode($arr));
    }
}