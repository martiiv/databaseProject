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

    public function createResource(array $arr): ?int
    {
        return (new OrderModel())->createResource($arr);
    }

    public function updateResource(array $arr): ?int
    {
        return (new OrderModel())->updateResource($arr);
    }

    public function deleteResource(int $id): ?string
    {
        return (new OrderModel())->deleteResource($id);
    }
}