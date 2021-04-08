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

    function updateResource(array $resource): array
    {
        // TODO: Implement updateResource() method.
    }

    function deleteResource(int $id)
    {
        // TODO: Implement deleteResource() method.
    }
}