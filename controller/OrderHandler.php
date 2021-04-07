<?php


class OrderHandler
{
    public function getResource(int $id): ?array
    {
        return (new OrderModel())->getResource($id);
    }

    public function getCollection(): ?array
    {
        return (new OrderModel())->getCollection();
    }
}