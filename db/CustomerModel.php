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

    function deleteResource(int $id): string
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM customers WHERE id = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        if ($this->getResource($id) == null) {
            return 0;
        }
        return 1;
    }
}