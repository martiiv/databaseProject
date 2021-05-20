<?php
require_once 'db/OrderModel.php';



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

    // tests
    public function testGetResource()
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getResource(1);
        foreach ($order as $o) {
            print(json_encode($o));
            print("\n");
        }
    }

    // tests
    public function testGetCollection()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->getCollection();
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
            'total_price' => 14500,
            'status' => "new",
            'customer_id' => 10000
        );

        $orderModel = new OrderModel();
        $newOrder = $orderModel->createResource($arr);
        $this->assertNotEquals(0, $newOrder);
    }

    // tests
    public function testUpdateResource()
    {
        // Change the values in this instance if you want to re-run the test
        $arr = array (
            // TODO - fix broken after fixed for API
            'order_no' => 10009,
            'status' => "open",
        );

        $orderModel = new OrderModel();
        $updatedOrderStatement = $orderModel->updateResource($arr);
        $this->assertEquals($updatedOrderStatement, true);
    }

    // tests
    public function testDeleteResource()
    {
        // Due to AUTO_INCREMENT you have to change this value every time until testdb.sql is set up properly
        $id = 10017;
        $deletedTemp = true;

        $orderModel = new OrderModel();
        $deletedOrder = $orderModel->deleteResource($id);
        $this->assertEquals($deletedOrder, $deletedTemp);
    }
}