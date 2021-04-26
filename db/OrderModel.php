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

    function getCollection(string $customer = null): array
    {
        $res = array();
        if ($customer == null) {
            $query = 'SELECT order_no, total_price, status, customer_id, shipment_no FROM orders';
            $stmt = $this->db->prepare($query);
        } else {
            $query = 'SELECT order_no, total_price, status, customer_id, shipment_no FROM orders WHERE customer_id = :customer_id';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':customer_id', $customer);
        }
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

    function createResource(array $resource): int
    {
        $this->db->beginTransaction();
        $query = 'INSERT INTO orders (total_price, status, customer_id) VALUES (:total_price, :status, :customer_id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':total_price', $resource['total_price']);
        $stmt->bindValue(':status', $resource['status']);
        $stmt->bindValue(':customer_id', $resource['customer_id']);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $this->db->commit();

        return $id;
    }

    function updateResource(array $resource): ?int
    {
        $this->db->beginTransaction();
        $query = 'UPDATE orders SET status = :status WHERE order_no = :order_no';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status', $resource['status']);
        $stmt->bindValue(':order_no', $resource['order_no']);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $this->db->commit();

        return $id;
    }

    function deleteResource(int $id): string
    {
        $success = "";
        $this->db->beginTransaction();

        $query = 'DELETE FROM orders WHERE order_no = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        $success = "Successfully deleted order with order number: " . strval($id) . ".";

        if (strlen($success) == 0) {
            $success = "Failed to delete order with order number: " . strval($id) . ".";
        }
        return $success;
    }
}