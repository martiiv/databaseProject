<?php
require_once 'DB.php';

/**
 * Class OrderModel
 */
class OrderModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    function getCollection(array $query = null): array
    {
        $res = array();
        $query = 'SELECT order_no, total_price, status, customer_id, shipment_no FROM orders';

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
        $query = 'SELECT order_no, total_price, status, customer_id, shipment_no FROM orders WHERE order_no = :id';

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