<?php
require_once 'DB.php';
require_once 'db/TransporterModel.php';

/**
 * Class ShipmentModel
 *
 * Class for handling shipment functionality like: retrieve, create, update and delete shipments
 */
class ShipmentModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieves all shipments from the database
     * @param array|null $query
     * @return array array containing all the shipments and their data
     */
    function getCollection(array $query = null): array
    {
        $res = array();
        $query = 'SELECT shipment_no, customer_name, pickup_date, state, driver_id, transporter, address_id FROM shipments';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Retrieves a specific shipment based on ID (shipment_no)
     * @param int $id the ID of the shipment of interest
     * @return array|null array containing shipment of interest and its data
     */
    function getResource(int $id): ?array
    {
        $res = array();
        $query = 'SELECT shipment_no, customer_name, pickup_date, state, driver_id, transporter, address_id FROM shipments WHERE shipment_no = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Creates new shipment
     * @param array $resource array containing information about shipment to be created
     * @return int the ID/shipment number of the newly created shipment
     */
    function createResource(array $resource): int
    {
        $this->db->beginTransaction();
        $query = 'INSERT INTO shipments (customer_name, address_id) VALUES (:customer_name, :address_id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':customer_name', $resource['customer_name']);
        $stmt->bindValue(':address_id', $resource['address_id']);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $this->db->commit();
        return $id;
    }

    /**
     * Updates a shipments state or pick up date (or both)
     * @param array $resource array containing data about what should be updated in the shipment
     * @param string $oldName the name of the transporter responsible for the shipment
     * @param int $shipment_no ID of shipment to be updated
     * @return array|null array containing the newly updated shipment and its data
     */
    function updateResource(array $resource, string $oldName, int $shipment_no): ?array
    {
        // Checks whether there has been an transporter assigned to the shipment or not
        if (strlen($oldName != 0)){
            (new TransporterModel())->editTransporter($resource, $oldName);
        }

        $res = array();

        $this->db->beginTransaction();

        // Checks if pickup_date and state is valid/present or if they are not supposed to be changed
        $pickupDateExist = isset($resource['pickup_date']);
        $stateExist = isset($resource['state']);

        // Checks whether only one or both of the changeable data should be changed
        if (!$pickupDateExist && $stateExist) {
            $query = 'UPDATE shipments SET state = (:state) WHERE shipment_no = (:shipment_no)';
        }
        elseif ($pickupDateExist && $stateExist) {
            $query = 'UPDATE shipments SET pickup_date = (:pickup_date), state = (:state) WHERE shipment_no = (:shipment_no)';
        }
        else if ($pickupDateExist && !$stateExist) {
            $query = 'UPDATE shipments SET pickup_date = (:pickup_date) WHERE shipment_no = (:shipment_no)';
        } else return null;

        $stmt = $this->db->prepare($query);

        // Stores data in array to be returned
        if (!$pickupDateExist && $stateExist) {
            $stmt->bindValue(':state', $resource['state']);
            $res['state'] = $resource['state'];
        }
        elseif ($pickupDateExist && $stateExist) {
            $stmt->bindValue(':pickup_date', $resource['pickup_date']);
            $stmt->bindValue(':state', $resource['state']);
            $res['pickup_date'] = $resource['pickup_date'];
            $res['state'] = $resource['state'];
        }
        else if ($pickupDateExist && !$stateExist) {
            $stmt->bindValue(':pickup_date', $resource['pickup_date']);
            $res['pickup_date'] = $resource['pickup_date'];
        }

        $stmt->bindValue(':shipment_no', $shipment_no);
        $stmt->execute();

        if (isset($resource['transporter'])) {
            $res['transporter'] = $resource['transporter'];
        }
        $this->db->commit();

        return $res;
    }

    /**
     * Delete shipment based on ID/shipment_no
     * @param int $id the ID of the shipment to be deleted
     * @return string
     */
    function deleteResource(int $id): string
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM shipments WHERE shipment_no = (:id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $this->db->commit();

        $success = "Successfully deleted shipment with shipment number: " . strval($id) . ".";

        if (strlen($success) != 0) {
            return $success;
        } else {
            $success = "Failed to delete shipment with shipment number: " . strval($id) . ".";
            return $success;
        }
    }
}