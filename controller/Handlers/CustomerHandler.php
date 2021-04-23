<?php


class CustomerHandler
{
    public function getCollection(): ?array
    {
        return (new CustomerModel())->getCollection();
    }

    public function getResource(int $id): ?array
    {
        return (new CustomerModel())->getResource($id);
    }

    public function createResource(array $arr): ?array
    {
        return (new CustomerModel())->createResource($arr);
    }
}