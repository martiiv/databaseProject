<?php


class ShipmentHandler
{
    public function getResource(int $id): ?array
    {
        return (new ShipmentModel())->getResource($id);
    }

    public function getCollection(): ?array
    {
        return (new ShipmentModel())->getCollection();
    }

    public function createResource(array $arr): ?array
    {
        return (new ShipmentModel())->createResource($arr);
    }

    public function updateResource(array $arr, string $oldName, int $shipment_no): ?array
    {
        return (new ShipmentModel())->updateResource($arr, $oldName, $shipment_no);
    }

    public function deleteResource(int $id): ?string
    {
        return (new ShipmentModel())->deleteResource($id);
    }
}