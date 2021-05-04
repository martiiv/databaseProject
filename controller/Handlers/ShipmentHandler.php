<?php

/**
 * Class ShipmentHandler Handler class for shipments
 */
class ShipmentHandler
{
    /**
     * @param int $id - ID of shipment to be retrieved
     * @return array|null - The data within the instance
     */
    public function getResource(int $id): ?array
    {
        return (new ShipmentModel())->getResource($id);
    }

    /**
     * @return array|null - All the shipments within the database
     */
    public function getCollection(): ?array
    {
        return (new ShipmentModel())->getCollection();
    }

    /**
     * @param array $arr - An array with the data to be added to the database
     * @return int - Returns the shipment nr.
     */
    public function createResource(array $arr): int
    {
        // TODO - add if's to validate the input
        return (new ShipmentModel())->createResource($arr);
    }

    /**
     * @param array $arr - An array consisting of attributes to be updated
     * @param string $oldName - Name of the transporter to be updated (optional)
     * @param int $shipment_no - ID of the shipment to be updated
     * @return array|null - Array containing the data of the newly updated shipment
     */
    public function updateResource(array $arr, string $oldName, int $shipment_no): ?array
    {
        // TODO - validate input
        return (new ShipmentModel())->updateResource($arr, $oldName, $shipment_no);
    }

    /**
     * @param int $id - ID of shipment to be deleted
     * @return string|null - Returns a success-message
     */
    public function deleteResource(int $id): ?string
    {
        return (new ShipmentModel())->deleteResource($id);
    }
}