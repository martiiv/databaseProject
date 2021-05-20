<?php
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
        $employeeModel = new EmployeeModel();
        $employees = $employeeModel->getResource(1);
        print(json_encode($employees));
    }

    // tests
    public function testGetCollection()
    {
        $employeeModel = new EmployeeModel();
        $employees = $employeeModel->getCollection();
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

        $employeeModel = new EmployeeModel();
        $newEmployee = $employeeModel->createResource($arr);
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

        $employeeModel = new EmployeeModel();
        $updatedEmployee = $employeeModel->updateResource($arr, $oldName);
        print(json_encode($updatedEmployee));
        print(json_encode($arr));
        $this->assertEquals(json_encode($updatedEmployee), json_encode($arr));
    }

    // tests
    public function testDeleteResource()
    {
        $id = 7;
        $deletedTemp = true;

        $employeeModel = new EmployeeModel();
        $deletedEmployee = $employeeModel->deleteResource($id);
        $this->assertEquals($deletedEmployee, $deletedTemp);
    }
}