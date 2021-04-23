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
        if ($arr['order_no'] != "") throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "No order number provided");
        if ($arr['status'] != "") throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "No status provided");
        return (new OrderModel())->updateResource($arr);

    }

    public function deleteResource(int $id): ?string
    {
        return (new OrderModel())->deleteResource($id);
    }
}