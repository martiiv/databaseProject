<?php
require_once "controller/Handlers/CustomerHandler.php";
require_once "db/CustomerModel.php";

class CustomerTest extends \Codeception\Test\Unit
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
        $customerHandler = new CustomerHandler();
        $customers = $customerHandler->getCollection();
        foreach ($customers as $customer) {
            print(json_encode($customer));
            print("\n");
        }
    }

    // tests
    public function testGetResource()
    {
        $customerHandler = new CustomerHandler();
        $customers = $customerHandler->getResource(10000);
        print(json_encode($customers));
    }

}