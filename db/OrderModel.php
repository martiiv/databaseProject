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

    // TODO - Make order_no autogenerate
    function createResource(array $resource): int
    {
        $this->db->beginTransaction();
        $query = 'INSERT INTO orders (order_no, total_price, status, customer_id) VALUES (:order_no, :total_price, :status, :customer_id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_no', $resource['order_no']);
        $stmt->bindValue(':total_price', $resource['total_price']);
        $stmt->bindValue(':status', $resource['status']);
        $stmt->bindValue(':customer_id', $resource['customer_id']);
        $stmt->execute();
        $this->db->commit();

        return $resource['order_no'];
        //return $this->db->lastInsertId();
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