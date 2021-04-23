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

    // tests
    public function testCreateResource()
    {
        // Delete this instance from the DB if you want to re-run the test
        // Optionally change the values
        $arr = array (
            'name' => "Epic ski store",
            'start_date' => '2020-10-12',
            'end_date' => '2022-10-12'
        );

        $customerHandler = new CustomerHandler();
        $newCustomer = $customerHandler->createResource($arr);
        print(json_encode($newCustomer));
        print(json_encode($arr));
        $this->assertEquals(json_encode($newCustomer), json_encode($arr));
    }

}