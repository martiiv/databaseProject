<?php

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
        $employee = $employeeHandler->getResource(15231);
        print(json_encode($employee));
    }
}