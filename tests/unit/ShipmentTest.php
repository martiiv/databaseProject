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
        $shipment = $shipmentHandler->getResource(1);
        print(json_encode($shipment));
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

    // tests
    public function testUpdateResource()
    {
        // Change the values in this instance if you want to re-run the test
        $arr = array (
            'shipment_no' => 4,
            'store_franchise_name' => "Mega Sport Oslo",
            'pickup_date' => '2021-05-18',
            'state' => 0,
            'driver_id' => 4,
            'transporter' => "Ole Joar's Pickup Service",
            'address_id' => 4,
        );

        // The old shipment number needs to be updated after you have updated it if you want to rerun it
        $oldShipment_no = 3;
        $oldName = "Magnus' transporting AS";

        $shipmentHandler = new ShipmentHandler();
        $updatedShipment = $shipmentHandler->updateResource($arr, $oldName, $oldShipment_no);
        print(json_encode($updatedShipment));
        print(json_encode($arr));
        $this->assertEquals(json_encode($updatedShipment), json_encode($arr));
    }

    // tests
    public function testDeleteResource()
    {
        // To rerun the delete tests, you need to delete the duplicated transporter from "transporters", because this
        // is not deleted upon deletion of a shipment.
        $id = 4;
        $idTemp = "Successfully deleted shipment with shipment number: " . strval($id) . ".";

        $shipmentHandler = new ShipmentHandler();
        $deletedShipment = $shipmentHandler->deleteResource($id);
        $this->assertEquals($deletedShipment, $idTemp);
    }
}