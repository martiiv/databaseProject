<?php
require_once 'DB.php';

/**
 * Class OrderModel
 */
class OrderModel extends DB
{
    // TODO - add order_created_date column in orders

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

    function updateResource(array $resource): ?int
    {

        $this->db->beginTransaction();
        $query = 'UPDATE orders SET status=:status WHERE order_no=:order_no';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status', $resource['status']);
        $stmt->bindValue(':order_no', $resource['order_no']);
        $stmt->execute();
        $this->db->commit();

        $shipment_no = $this->getShipmentNo($resource['order_no']);
        if ($shipment_no == "") return null;
        return $shipment_no;
    }

    function deleteResource(int $id): string
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM orders WHERE order_no = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        $success = "Successfully deleted order with order number: " . strval($id) . ".";

        if (strlen($success) != 0) {
            return $success;
        } else {
            $success = "Failed to delete order with order number: " . strval($id) . ".";
            return $success;
        }
    }

    private function getShipmentNo(int $id)
    {
        $res = array();
        $query = 'SELECT shipment_no FROM orders WHERE order_no = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res['shipment_no'] = $row['shipment_no'];
        }

        return $res['shipment_no'];
    }
}