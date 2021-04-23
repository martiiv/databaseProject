<?php


class EmployeeHandler
{
    public function getResource(int $id): ?array
    {
        return (new EmployeeModel())->getResource($id);
    }

    public function getCollection(): ?array
    {
        return (new EmployeeModel())->getCollection();
    }

    public function createResource(array $arr): ?array
    {
        return (new EmployeeModel())->createResource($arr);
    }

    public function updateResource(array $arr, string $oldName): ?array
    {
        return (new EmployeeModel())->updateResource($arr, $oldName);
    }

    public function deleteResource(int $id): ?string
    {
        return (new EmployeeModel())->deleteResource($id);
    }
}