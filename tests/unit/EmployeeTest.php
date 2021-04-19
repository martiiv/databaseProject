<?php
require_once "controller/Handlers/EmployeeHandler.php";
require_once "db/EmployeeModel.php";

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

    // tests
    public function testGetResource()
    {
        $employeeHandler = new EmployeeHandler();
        $employees = $employeeHandler->getResource(1);
        print(json_encode($employees));
    }

    // tests
    public function testGetCollection()
    {
        $employeeHandler = new EmployeeHandler();
        $employees = $employeeHandler->getCollection();
        foreach ($employees as $employee) {
            print(json_encode($employee));
            print("\n");
        }
    }

    // tests
    public function testCreateResource()
    {
        // Delete this instance from the DB if you want to re-run the test
        // Optionally change the values
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

    // tests
    public function testUpdateResource()
    {
        // Change the values in this instance if you want to re-run the test
        $arr = array (
            'name' => "Rive Rolf",
            'department' => "Storekeeper"
        );

        // The name needs to be updated after you have updated it if you want to rerun it
        $oldName = "Morten";

        $employeeHandler = new EmployeeHandler();
        $updatedEmployee = $employeeHandler->updateResource($arr, $oldName);
        print(json_encode($updatedEmployee));
        print(json_encode($arr));
        $this->assertEquals(json_encode($updatedEmployee), json_encode($arr));
    }

    // tests
    public function testDeleteResource()
    {
        $id = 7;
        $idTemp = "Successfully deleted employee with employee number: " . strval($id) . ".";

        $employeeHandler = new EmployeeHandler();
        $deletedEmployee = $employeeHandler->deleteResource($id);
        $this->assertEquals($deletedEmployee, $idTemp);
    }
}