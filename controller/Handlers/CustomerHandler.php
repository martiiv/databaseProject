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
}