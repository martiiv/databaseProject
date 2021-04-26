<?php
require_once 'DB.php';
require_once 'db/TransporterModel.php';

/**
 * Class OrderModel
 */
class ShipmentModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

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

    function createResource(array $resource): array
    {
        $res = array();

        $transporterArray = (new TransporterModel())->addTransporter($resource);

        $this->db->beginTransaction();
        $query = 'INSERT INTO shipments (customer_name, pickup_date, state, driver_id, transporter, address_id) VALUES (:customer_name, :pickup_date, :state, :driver_id, :transporter, :address_id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':customer_name', $resource['customer_name']);
        $stmt->bindValue(':pickup_date', $resource['pickup_date']);
        $stmt->bindValue(':state', $resource['state']);
        $stmt->bindValue(':driver_id', $resource['driver_id']);
        $stmt->bindValue(':transporter',  $transporterArray['name']);
        $stmt->bindValue(':address_id', $resource['address_id']);
        $stmt->execute();

        $res['customer_name'] = $resource['customer_name'];
        $res['pickup_date'] = $resource['pickup_date'];
        $res['state'] = $resource['state'];
        $res['driver_id'] = $resource['driver_id'];
        $res['transporter'] =  $transporterArray['name'];
        $res['address_id'] = $resource['address_id'];
        $this->db->commit();

        return $res;
    }

    function updateResource(array $resource, string $oldName, int $oldShipment_no): array
    {
        if (strlen($oldName != 0)){
            (new TransporterModel())->editTransporter($resource, $oldName);
        }

        $res = array();

        $this->db->beginTransaction();

        $query = 'UPDATE shipments SET pickup_date = (:pickup_date), state = (:state) WHERE shipment_no = (:oldShipment_no)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':pickup_date', $resource['pickup_date']);
        $stmt->bindValue(':state', $resource['state']);
        $stmt->bindValue(':oldShipment_no', $oldShipment_no);
        $stmt->execute();

        $res['pickup_date'] = $resource['pickup_date'];
        $res['state'] = $resource['state'];
        $res['transporter'] = $resource['transporter'];
        $this->db->commit();

        return $res;
    }

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