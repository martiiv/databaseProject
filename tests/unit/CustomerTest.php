<?php
require_once "controller/Handlers/CustomerHandler.php";
require_once "db/CustomerModel.php";

/**
 * Class CustomerTest - A unit-test class for testing the different methods handling customers.
 *
 * Consists of:
 *      - testGetCollection()
 *          -- retrieves all customers
 *      - testGetResource()
 *          -- retrieves one customer based on ID
 *      - testCreateResource()
 *          -- creates a new customer
 *      - testUpdateResource()
 *          -- updates a customer with a given ID
 *      - testDeleteResource()
 *          -- deletes a customer with a given ID
 */
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

    /**
     * Function testGetCollection
     *
     * Gets all the customer from the database using the getCollection-method in CustomerModel.
     *
     * For each customer, json encode the shipment data and display it.
     */
    public function testGetCollection()
    {
        $customerHandler = new CustomerHandler();
        $customers = $customerHandler->getCollection();
        foreach ($customers as $customer) {
            print(json_encode($customer));
            print("\n");
        }
    }

    /**
     * Function testGetResource
     *
     * Gets a specific customer based on ID.
     *
     * In this test we retrieve the first item in the database using the getResource-method from CustomerModel.
     */
    public function testGetResource()
    {
        $customerHandler = new CustomerHandler();
        $customers = $customerHandler->getResource(10000);
        $this->assertEquals(10000, $customers[0]['id']);
        print(json_encode($customers));
    }

    /**
     * Function testCreateResource
     *
     * Creates a new customer with data using createResource-method in CustomerModel.
     *
     * Sends an array with data to the method.
     *
     * Checks that the content added to the database is the same as the input data.
     */
    public function testCreateResource()
    {
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

    /**
     * Function testUpdateResource
     *
     * Updates the following attributes in a customer (based on customer input id):
     *      - name
     *      - end_date
     *
     * Sends the new attribute values to the updateResource-method in CustomerModel.
     *
     * Checks if the updated object is equal to the passed in object.
     */
    public function testUpdateResource()
    {
        $arr = array (
            'name' => "Sport1 Oslo",
            'end_date' => '2024-10-12'
        );

        $oldName = "Epic ski store";

        $customerHandler = new CustomerHandler();
        $updatedCustomer = $customerHandler->updateResource($arr, $oldName);
        print(json_encode($updatedCustomer));
        print(json_encode($arr));
        $this->assertEquals(json_encode($updatedCustomer), json_encode($arr));
    }

    /**
     * Function testDeleteResource
     *
     * Test the deletion process of a customer from the database.
     *
     * If the deletion take place, it returns true.
     *
     * Assert if this returned value is true.
     */
    public function testDeleteResource()
    {
        $id = 10003;
        $deleted = true;

        $customerHandler = new CustomerHandler();
        $deletedCustomer = $customerHandler->deleteResource($id);
        $this->assertEquals($deletedCustomer, $deleted);
    }
}