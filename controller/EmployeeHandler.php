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

    public function updateResource(array $arr, int $oldID): ?array
    {
        return (new EmployeeModel())->updateResource($arr, $oldID);
    }
}