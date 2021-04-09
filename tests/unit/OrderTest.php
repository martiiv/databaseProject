<?php
require_once 'controller/Handlers/OrderHandler.php';
require_once 'db/OrderModel.php';



class OrderTest extends \Codeception\Test\Unit
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
    public function testGetResource()
    {
        $orderHandler = new OrderHandler();
        $order = $orderHandler->getResource(1);
        foreach ($order as $o) {
            print(json_encode($o));
            print("\n");
        }

    }

    // tests
    public function testGetCollection()
    {
        $orderHandler = new OrderHandler();
        $orders = $orderHandler->getCollection();
        foreach ($orders as $order) {
            print(json_encode($order));
            print("\n");
        }
    }

    // tests
    public function testCreateResource()
    {
        // Delete this instance from the DB if you want to re-run the test
        // Optionally change the values
        $arr = array (
            'order_no' => 12479,
            'total_price' => 14500,
            'status' => "new",
            'customer_id' => 1
        );

        $orderHandler = new OrderHandler();
        $newOrder = $orderHandler->createResource($arr);
        print($newOrder);
        print($arr['order_no']);
        $this->assertEquals($newOrder, $arr['order_no']);
    }

    // tests
    public function testUpdateResource()
    {
        // Change the values in this instance if you want to re-run the test
        $arr = array (
            // TODO - fix broken after fixed for API
            'order_no' => 12479,
            'status' => "open",
        );

        $orderHandler = new OrderHandler();
        $updatedOrderStatement = $orderHandler->updateResource($arr);
        $this->assertEquals(null, $updatedOrderStatement);
    }

    // tests
    public function testDeleteResource()
    {
        $id = 12479;
        $idTemp = "Successfully deleted order with order number: " . strval($id) . ".";

        $orderHandler = new OrderHandler();
        $deletedOrder = $orderHandler->deleteResource($id);
        $this->assertEquals($deletedOrder, $idTemp);
    }
}