<?php
require_once 'DB.php';

/**
 * Class OrderModel
 */
class CustomerModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    function getCollection(array $query = null): array
    {
        $res = array();
        $query = 'SELECT id, name, start_date, end_date FROM customers';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    function getResource(int $id): ?array
    {
        // TODO: Implement getResource() method.
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