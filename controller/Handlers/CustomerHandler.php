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

    public function updateResource(array $arr, string $oldName): ?array
    {
        return (new CustomerModel())->updateResource($arr, $oldName);
    }

    public function deleteResource(int $id): ?bool
    {
        return (new CustomerModel())->deleteResource($id);
    }
}