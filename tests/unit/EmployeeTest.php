<?php
require_once "controller/EmployeeHandler.php";
require_once "db/EmployeeModel.php";

class EmployeeTest extends \Codeception\Test\Unit
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
    public function testSomeFeature()
    {


    }

    // tests
    public function testGetResource()
    {
        $employeeHandler = new EmployeeHandler();
        $employee = $employeeHandler->getResource(1);
        print(json_encode($employee));
    }
}