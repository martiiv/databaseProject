<?php
require_once 'DB.php';

/**
 * Class OrderModel
 *
 * Contains the base functionality of the work done to retrieve, create, update and delete orders.
 */
class OrderModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get a collection of/all the orders
     * @param string|null $customer customer ID
     * @param string|null $state state of an order
     * @return array of orders
     */
    function getCollection(string $customer = null, string $state = null): array
    {
        $res = array();
        // Gets all the fields stored for an order - made to prevent SQL injection
        $query = 'SELECT order_no, created, total_price, status, customer_id, shipment_no FROM orders';

        // Used to finish the query depending on alternative input from the user
        // If the user either inputs the filter for customer-ID or state
        if ($customer != null || $state != null) {
            // Add " WHERE" to the query sentence
            $query .= ' WHERE';
            // Add either customer-ID or state and it's bound value
            if ($customer != null) $query .= ' customer_id = :customer_id';
            if ($state != null) $query .= ' status = :status';
        }

        // Prepare the query
        $stmt = $this->db->prepare($query);
        // Bind the respective value depending on user input
        if ($customer != null) $stmt->bindValue(':customer_id', $customer);
        if ($state != null) $stmt->bindValue(':status', $state);

        $stmt->execute();

        // For each order in the database, add the order with its data to an array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Get one specific order based on order_id
     * @param int $id order_id
     * @return array|null an array containing the order
     */
    function getResource(int $id): ?array
    {
        $res = array();
        $query = 'SELECT order_no, total_price, status, customer_id, shipment_no FROM orders WHERE order_no = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }

        return $res;
    }

    /**
     * Methods for creating a new order
     * @param array $resource an array containing the new order you want to create
     * @return int order_no
     */
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

    /**
     * Method for updating an order
     * @param array $resource array containing order_no and fields to be updated
     * @return bool true on successful update, false if not
     */
    function updateResource(array $resource): bool
    {
        $updated = false;
        $this->db->beginTransaction();

        // Check that order does exist
        $query = 'SELECT COUNT(*) FROM orders WHERE order_no = :order_no';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_no', $resource['order_no']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['COUNT(*)'] == 1) {
            // Update
            $query = 'UPDATE orders SET status = :status WHERE order_no = :order_no';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':status', $resource['status']);
            $stmt->bindValue(':order_no', $resource['order_no']);
            $stmt->execute();
            $updated = true;
        }

        $this->db->commit();
        return $updated;
    }

    /**
     * Method for deleting an order
     * @param int $id the order_no of the order to be deleted
     * @return bool true on successful delete, false if not
     */
    function deleteResource(int $id): bool
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM orders WHERE order_no = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $deleted = true;

        $this->db->commit();

        return $deleted;
    }
}