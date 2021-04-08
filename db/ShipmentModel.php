<?php
require_once 'DB.php';

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
        $query = 'SELECT shipment_no, store_franchise_name, pickup_date, state, driver_id, transporter, address_id FROM shipments';

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
        $query = 'SELECT shipment_no, store_franchise_name, pickup_date, state, driver_id, transporter, address_id FROM shipments WHERE shipment_no = :id';

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

        $transporterArray = $this->addTransporter($resource);

        $this->db->beginTransaction();
        $query = 'INSERT INTO shipments (shipment_no, store_franchise_name, pickup_date, state, driver_id, transporter, address_id) VALUES (:shipment_no, :store_franchise_name, :pickup_date, :state, :driver_id, :transporter, :address_id)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':shipment_no', $resource['shipment_no']);
        $stmt->bindValue(':store_franchise_name', $resource['store_franchise_name']);
        $stmt->bindValue(':pickup_date', $resource['pickup_date']);
        $stmt->bindValue(':state', $resource['state']);
        $stmt->bindValue(':driver_id', $resource['driver_id']);
        $stmt->bindValue(':transporter',  $transporterArray['name']);
        $stmt->bindValue(':address_id', $resource['address_id']);
        $stmt->execute();

        $res['shipment_no'] = $resource['shipment_no'];
        $res['store_franchise_name'] = $resource['store_franchise_name'];
        $res['pickup_date'] = $resource['pickup_date'];
        $res['state'] = $resource['state'];
        $res['driver_id'] = $resource['driver_id'];
        $res['transporter'] =  $transporterArray['name'];
        $res['address_id'] = $resource['address_id'];
        $this->db->commit();

        return $res;
    }

    // TODO - move addTransporter to separate transporter file
    function addTransporter(array $resource): array
    {
        $this->db->beginTransaction();

        $res = array();

        $transporter = $resource['transporter'];

        $queryTransporter = 'INSERT INTO transporters (name) VALUES (:name)';

        $stmt = $this->db->prepare($queryTransporter);
        $stmt->bindValue(':name', $transporter);
        $stmt->execute();
        $this->db->commit();

        $res['name'] = $transporter;
        return $res;
    }

    // TODO - move editTransporter to separate transporter file
    function editTransporter(array $resource, string $oldName): array
    {
        $this->db->beginTransaction();

        $res = array();

        $transporter = $resource['transporter'];

        $queryTransporter = 'UPDATE transporters SET name = (:name) WHERE name = (:oldName)';

        $stmt = $this->db->prepare($queryTransporter);
        $stmt->bindValue(':name', $transporter);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();
        $this->db->commit();

        $res['name'] = $transporter;
        return $res;
    }

    function updateResource(array $resource, string $oldName, int $oldShipment_no): array
    {
        $transporterArray = $this->editTransporter($resource, $oldName);

        $res = array();

        $this->db->beginTransaction();

        $query = 'UPDATE shipments SET shipment_no = (:shipment_no), store_franchise_name = (:store_franchise_name), 
                     pickup_date = (:pickup_date), state = (:state), driver_id = (:driver_id), 
                     transporter = (:transporter), address_id = (:address_id) WHERE shipment_no = (:oldShipment_no)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':shipment_no', $resource['shipment_no']);
        $stmt->bindValue(':store_franchise_name', $resource['store_franchise_name']);
        $stmt->bindValue(':pickup_date', $resource['pickup_date']);
        $stmt->bindValue(':state', $resource['state']);
        $stmt->bindValue(':driver_id', $resource['driver_id']);
        $stmt->bindValue(':transporter',  $transporterArray['name']);
        $stmt->bindValue(':address_id', $resource['address_id']);
        $stmt->bindValue(':oldShipment_no', $oldShipment_no);
        $stmt->execute();

        $res['shipment_no'] = $resource['shipment_no'];
        $res['store_franchise_name'] = $resource['store_franchise_name'];
        $res['pickup_date'] = $resource['pickup_date'];
        $res['state'] = $resource['state'];
        $res['driver_id'] = $resource['driver_id'];
        $res['transporter'] =  $transporterArray['name'];
        $res['address_id'] = $resource['address_id'];
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