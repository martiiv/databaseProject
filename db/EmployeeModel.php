<?php
require_once 'DB.php';

/**
 * Class OrderModel
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
        // TODO: Implement createResource() method.
    }

    function updateResource(array $resource): array
    {
        // TODO: Implement updateResource() method.
    }

    function deleteResource(int $id)
    {
        // TODO: Implement deleteResource() method.
    }
}