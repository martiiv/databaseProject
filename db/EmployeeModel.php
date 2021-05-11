<?php
require_once 'DB.php';

/**
 * Class EmployeeModel
 *
 * Class for handling employee functionality like: retrieve, create, update and delete employees
 */
class EmployeeModel extends DB
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all employees
     * @param array|null $query
     * @return array with all the different employees and their data
     */
    function getCollection(array $query = null): array
    {
        $res = array();
        $query = 'SELECT number, name, department FROM employees';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Get an employee based on the employee_no
     * @param int $id employee_no
     * @return array|null array containing the employee of search and the data for that employee
     */
    function getResource(int $id): ?array
    {
        $res = array();
        $query = 'SELECT number, name, department FROM employees WHERE number = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Create a new employee with a name and working for a department
     * @param array $resource with the data about the employee to be created
     * @return array with the employee that was created and data for that employee
     */
    function createResource(array $resource): array
    {
        $this->db->beginTransaction();

        $res = array();
        $query = 'INSERT INTO employees (name, department) VALUES (:name, :department)';

        // TODO - check for valid department
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':department', $resource['department']);
        $stmt->execute();

        $res['name'] = $resource['name'];
        $res['department'] = $resource['department'];
        $this->db->commit();

        return $res;
    }

    /**
     * Update name and/or department for an employee
     * @param array $resource the fields to be updated and with the values of what they should be updated to
     * @param string $oldName the name/potentially old name of the employee to be edited
     * @return array the new data about the employee
     */
    function updateResource(array $resource, string $oldName): array
    {
        $this->db->beginTransaction();

        $res = array();
        $query = 'UPDATE employees SET name = (:name), department = (:department) WHERE name = (:oldName)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':department', $resource['department']);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();

        $res['name'] = $resource['name'];
        $res['department'] = $resource['department'];
        $this->db->commit();

        return $res;
    }

    /**
     * Delete an employee from the system
     * @param int $id the employee_no of employee to be deleted
     * @return bool
     */
    function deleteResource(int $id): bool
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM employees WHERE number = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $deleted = true;

        $this->db->commit();

        return $deleted;
    }
}