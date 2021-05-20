<?php
require_once 'db/OrderModel.php';

/**
 * Class OrderTest - A unit-test class for testing the different methods handling orders.
 *
 * Consists of:
 *      - testGetCollection()
 *          -- retrieves all orders
 *      - testGetResource()
 *          -- retrieves one order based on ID
 *      - testCreateResource()
 *          -- creates a new order
 *      - testUpdateResource()
 *          -- updates a order with a given ID
 *      - testDeleteResource()
 *          -- deletes a order with a given ID
 */
class OrderTest extends \Codeception\Test\Unit
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
     * Function testGetResource
     *
     * Gets a specific order based on ID.
     *
     * In this test we retrieve the first item in the database using the getResource-method from OrderModel.
     */
    public function testGetResource()
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getResource(1);
        foreach ($order as $o) {
            print(json_encode($o));
            print("\n");
        }
    }

    /**
     * Function testGetCollection
     *
     * Gets all the orders from the database using the getCollection-method in OrderModel.
     *
     * For each order, json encode the shipment data and display it.
     */
    public function testGetCollection()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->getCollection();
        foreach ($orders as $order) {
            print(json_encode($order));
            print("\n");
        }
    }

    /**
     * Function testCreateResource
     *
     * Creates a new order with data using createResource-method in OrderModel.
     *
     * Sends an array with data to the method.
     *
     * Checks that the content added to the database is the same as the input data.
     */
    public function testCreateResource()
    {
        $arr = array (
            'total_price' => 14500,
            'status' => "new",
            'customer_id' => 10000
        );

        $orderModel = new OrderModel();
        $newOrder = $orderModel->createResource($arr);
        $this->assertNotEquals(0, $newOrder);
    }

    /**
     * Function testUpdateResource
     *
     * Updates the following attributes in an order (based on order input id):
     *      - order_no
     *      - status
     *
     * Sends the new attribute values to the updateResource-method in OrderModel.
     *
     * Checks if the updated object is equal to the passed in object.
     */
    public function testUpdateResource()
    {
        $arr = array (
            'order_no' => 10009,
            'status' => "open",
        );

        $orderModel = new OrderModel();
        $updatedOrderStatement = $orderModel->updateResource($arr);
        $this->assertEquals($updatedOrderStatement, true);
    }

    /**
     * Function testDeleteResource
     *
     * Test the deletion process of an order from the database.
     *
     * If the deletion take place, it returns true.
     *
     * Assert if this returned value is true.
     */
    public function testDeleteResource()
    {
        $id = 10017;
        $deletedTemp = true;

        $orderModel = new OrderModel();
        $deletedOrder = $orderModel->deleteResource($id);
        $this->assertEquals($deletedOrder, $deletedTemp);
    }
}