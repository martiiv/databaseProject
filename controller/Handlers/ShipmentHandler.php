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
}