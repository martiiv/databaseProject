<?php
require_once "controller/Handlers/EmployeeHandler.php";
require_once "db/EmployeeModel.php";

/**
 * Class EmployeeTest - A unit-test class for testing the different methods handling employees.
 *
 * Consists of:
 *      - testGetCollection()
 *          -- retrieves all employees
 *      - testGetResource()
 *          -- retrieves one employee based on ID
 *      - testCreateResource()
 *          -- creates a new employee
 *      - testUpdateResource()
 *          -- updates a employee with a given ID
 *      - testDeleteResource()
 *          -- deletes a employee with a given ID
 */
class EmployeeTest extends \Codeception\Test\Unit
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
     * Gets a specific employee based on ID.
     *
     * In this test we retrieve the first item in the database using the getResource-method from EmployeeModel.
     */
    public function testGetResource()
    {
        $employeeHandler = new EmployeeHandler();
        $employees = $employeeHandler->getResource(1);
        print(json_encode($employees));
    }

    /**
     * Function testGetCollection
     *
     * Gets all the employees from the database using the getCollection-method in EmployeeModel.
     *
     * For each employee, json encode the employee data and display it.
     */
    public function testGetCollection()
    {
        $employeeHandler = new EmployeeHandler();
        $employees = $employeeHandler->getCollection();
        foreach ($employees as $employee) {
            print(json_encode($employee));
            print("\n");
        }
    }

    /**
     * Function testCreateResource
     *
     * Creates a new employee with data using createResource-method in EmployeeModel.
     *
     * Sends an array with data to the method.
     *
     * Checks that the content added to the database is the same as the input data.
     */
    public function testCreateResource()
    {
        $arr = array (
            'name' => "Morten",
            'department' => "Storekeeper"
        );

        $employeeHandler = new EmployeeHandler();
        $newEmployee = $employeeHandler->createResource($arr);
        print(json_encode($newEmployee));
        print(json_encode($arr));
        $this->assertEquals(json_encode($newEmployee), json_encode($arr));
    }

    /**
     * Function testUpdateResource
     *
     * Updates the following attributes of an employee (based on employee input id):
     *      - name
     *      - department
     *
     * Sends the new attribute values to the updateResource-method in EmployeeModel.
     *
     * Checks if the updated object is equal to the passed in object.
     */
    public function testUpdateResource()
    {
        $arr = array (
            'name' => "Rive Rolf",
            'department' => "Storekeeper"
        );

        $oldName = "Morten";

        $employeeHandler = new EmployeeHandler();
        $updatedEmployee = $employeeHandler->updateResource($arr, $oldName);
        print(json_encode($updatedEmployee));
        print(json_encode($arr));
        $this->assertEquals(json_encode($updatedEmployee), json_encode($arr));
    }

    /**
     * Function testDeleteResource
     *
     * Test the deletion process of an employee from the database based on employee number.
     *
     * If the deletion take place, it returns true.
     *
     * Assert if this returned value is true.
     */
    public function testDeleteResource()
    {
        $id = 7;
        $deletedTemp = true;

        $employeeHandler = new EmployeeHandler();
        $deletedEmployee = $employeeHandler->deleteResource($id);
        $this->assertEquals($deletedEmployee, $deletedTemp);
    }
}