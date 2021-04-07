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
        $query = 'INSERT INTO employees (number, name, department) VALUES (:number, :name, :department)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $resource['number']);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':department', $resource['department']);
        $stmt->execute();

        $res['number'] = $resource['number']; //intval($this->db->lastInsertId());
        $res['name'] = $resource['name'];
        $res['department'] = $resource['department'];
        $this->db->commit();

        return $res;
    }


    function updateResource(array $resource, int $oldID): array
    {
        $this->db->beginTransaction();

        $oldIDRecieved = $oldID;

        $res = array();
        $query = 'UPDATE employees SET number = (:number), name = (:name), department = (:department) WHERE number = (:oldID)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $resource['number']);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':department', $resource['department']);
        $stmt->bindValue(':oldID', $oldIDRecieved);
        $stmt->execute();

        $res['number'] = $resource['number'];
        $res['name'] = $resource['name'];
        $res['department'] = $resource['department'];
        $this->db->commit();

        return $res;
    }

    function deleteResource(int $id)
    {
        // TODO: Implement deleteResource() method.
    }
}