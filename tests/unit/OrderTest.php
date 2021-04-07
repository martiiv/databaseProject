<?php
require_once 'controller/OrderHandler.php';
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

    public function testGetCollection()
    {
        $orderHandler = new OrderHandler();
        $orders = $orderHandler->getCollection();
        foreach ($orders as $order) {
            print(json_encode($order));
            print("\n");
        }
    }
}