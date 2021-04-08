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

    public function updateResource(array $arr, int $old_Order_no): ?int
    {
        return (new OrderModel())->updateResource($arr, $old_Order_no);
    }
}