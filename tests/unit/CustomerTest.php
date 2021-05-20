<?php
require_once "db/CustomerModel.php";

class CustomerTest extends \Codeception\Test\Unit
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
    public function testGetCollection()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->getCollection();
        foreach ($customers as $customer) {
            print(json_encode($customer));
            print("\n");
        }
    }

    // tests
    public function testGetResource()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->getResource(10000);
        $this->assertEquals(10000, $customers[0]['id']);
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

        $customerModel = new CustomerModel();
        $newCustomer = $customerModel->createResource($arr);
        print(json_encode($newCustomer));
        print(json_encode($arr));
        $this->assertEquals(json_encode($newCustomer), json_encode($arr));
    }

    // tests
    public function testUpdateResource()
    {
        // Change the values in this instance if you want to re-run the test
        $arr = array (
            'name' => "Sport1 Oslo",
            'end_date' => '2024-10-12'
        );

        // The name needs to be updated after you have updated it if you want to rerun it
        $oldName = "Epic ski store";

        $customerModel = new CustomerModel();
        $customers = $customerModel->updateResource($arr, $oldName);
        print(json_encode($customers));
        print(json_encode($arr));
        $this->assertEquals(json_encode($customers), json_encode($arr));
    }

    // tests
    public function testDeleteResource()
    {
        $id = 10003;
        $deleted = true;

        $customerModel = new CustomerModel();
        $customers = $customerModel->deleteResource($id);
        $this->assertEquals($customers, $deleted);
    }
}