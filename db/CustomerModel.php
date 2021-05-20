<?php
require_once 'DB.php';

/**
 * Class OrderModel
 *
 * Class for handling customer functionality like: retrieve, create, update and delete customers.
 */
class CustomerModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all customers
     * @param array|null
     * @return array returns an array containing the customers and their data
     */
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

    /**
     * Get one customer and its data based on the customer number.
     * @param int $id the ID of the customer (customer number)
     * @return array|null an array containing the customer and its data
     */
    function getResource(int $id): ?array
    {
        $res = array();
        $query = 'SELECT id, name, start_date, end_date FROM customers WHERE customers.id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Gets the address of a customer
     * @param int $id the ID of the customer (customer number)
     * @return array|null an array containing the customer and its data - this time also with address
     */
    function getAddress(int $id): ?array
    {
        $res = array();
        $query = 'SELECT customer_id, name, address_id FROM customers JOIN customer_address ON customer_address.customer_id = customers.id WHERE customers.id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Creates a new customer instance in the system
     * @param array $resource array containing data about the customer to be created
     * @return array returns the newly created customer
     */
    function createResource(array $resource): array
    {
        $this->db->beginTransaction();

        $res = array();
        $query = 'INSERT INTO customers (name, start_date, end_date) VALUES (:name, :start_date, :end_date)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':start_date', $resource['start_date']);
        $stmt->bindValue(':end_date', $resource['end_date']);
        $stmt->execute();

        $res['name'] = $resource['name'];
        $res['start_date'] = $resource['start_date'];
        $res['end_date'] = $resource['end_date'];
        $this->db->commit();

        return $res;
    }

    /**
     * Updates a customer in the system with data like name or end_date of "membership"
     * @param array $resource array containing data to be changed
     * @param string $oldName name of customer to be changed
     * @return array the updated instance of the customer and its data
     */
    function updateResource(array $resource, string $oldName): array
    {
        $this->db->beginTransaction();

        $res = array();
        $query = 'UPDATE customers SET name = (:name), end_date = (:end_date) WHERE name = (:oldName)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $resource['name']);
        $stmt->bindValue(':end_date', $resource['end_date']);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();

        $res['name'] = $resource['name'];
        $res['end_date'] = $resource['end_date'];
        $this->db->commit();

        return $res;
    }

    /**
     * Deletes a customer from the system
     * @param int $id the ID of the customer (customer number)
     * @return bool boolean telling whether the deletion was successful or not
     */
    function deleteResource(int $id): bool
    {
        $deleted = false;
        $this->db->beginTransaction();

        $query = 'DELETE FROM customers WHERE id = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        if ($this->getResource($id) == null) {
            $deleted = true;
        }
        return $deleted;
    }
}