<?php
require_once 'DB.php';

/**
 * Class EmployeeModel
 */
class EmployeeModel extends DB
{

    public function __construct()
    {
        parent::__construct();
    }

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

    function deleteResource(int $id): string
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM employees WHERE number = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        $success = "Successfully deleted employee with employee number: " . strval($id) . ".";

        if (strlen($success) != 0) {
            return $success;
        } else {
            $success = "Failed to delete employee with employee number: " . strval($id) . ".";
            return $success;
        }
    }
}