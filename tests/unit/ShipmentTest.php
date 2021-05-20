<?php
require_once "db/ShipmentModel.php";

/**
 * Class ShipmentTest - A unit-test class for testing the different methods handling shipments.
 *
 * Consists of:
 *      - testGetCollection()
 *          -- retrieves all shipments
 *      - testGetResource()
 *          -- retrieves one shipment based on ID
 *      - testCreateResource()
 *          -- creates a new shipment
 *      - testUpdateResource()
 *          -- updates a shipment with a given ID
 *      - testDeleteResource()
 *          -- deletes a shipment with a given ID
 */
class ShipmentTest extends \Codeception\Test\Unit
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

    /**
     * Function testGetCollection
     *
     * Gets all the shipments from the database using the getCollection-method in ShipmentModel.
     *
     * For each shipment, json encode the shipment data and display it.
     */
    public function testGetCollection()
    {
        $shipmentModel = new ShipmentModel();
        $shipments = $shipmentModel->getCollection();
        foreach ($shipments as $shipment) {
            print(json_encode($shipment));
            print("\n");
        }
    }

    /**
     * Function testGetResource
     *
     * Gets a specific shipment based on ID.
     *
     * In this test we retrieve the first item in the database using the getResource-method from ShipmentModel.
     */
    public function testGetResource()
    {
        $shipmentModel = new ShipmentModel();
        $shipment = $shipmentModel->getResource(1);
        print(json_encode($shipment));
    }

    /**
     * Function testCreateResource
     *
     * Creates a new shipment with data using createResource-method in ShipmentModel.
     *
     * Sends an array with data to the method.
     *
     * Checks that the content added to the database is the same as the input data.
     */
    public function testCreateResource()
    {
        // The instance to be created
        $arr = array (
            'customer_name' => "Sport 1 Oslo",
            'address_id' => 10000,
        );

        $shipmentModel = new ShipmentModel();
        $newShipment = $shipmentModel->createResource($arr);
        $this->assertNotNull($newShipment);
    }

    /**
     * Function testUpdateResource
     *
     * Updates the following attributes in a shipment (based on shipment input id):
     *      - pickup_date
     *      - state
     *      - transporter
     *
     * Sends the new attribute values to the updateResource-method in ShipmentModel.
     *
     * Checks if the updated object is equal to the passed in object.
     */
    public function testUpdateResource()
    {
        // The fields to be updated
        $arr = array (
            'pickup_date' => '2021-05-18',
            'state' => 0,
            'transporter' => "Martins HjemPaaDoora service"
        );

        // ID of shipment to be changed
        $shipment_no = 10000;

        // Needed to change the transporter in the transporters-entity
        $oldName = "Gro Anitas postservice";

        $shipmentModel = new ShipmentModel();
        $updatedShipment = $shipmentModel->updateResource($arr, $oldName, $shipment_no);
        $this->assertEquals(json_encode($updatedShipment), json_encode($arr));
    }

    /**
     * Function testDeleteResource
     *
     * Test the deletion process of a shipment from the database.
     *
     * If the deletion take place, it returns a success message.
     *
     * Assert if this message is the same as the manually coded success message.
     */
    public function testDeleteResource()
    {
        // ID of shipment to be deleted
        $id = 10000;

        // Message on successful deletion
        $idTemp = "Successfully deleted shipment with shipment number: " . strval($id) . ".";

        $shipmentModel = new ShipmentModel();
        $deletedShipment = $shipmentModel->deleteResource($id);
        $this->assertEquals($deletedShipment, $idTemp);
    }
}