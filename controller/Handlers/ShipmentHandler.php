<?php


class ShipmentHandler
{
    public function getCollection(): ?array
    {
        return (new ShipmentModel())->getCollection();
    }
}