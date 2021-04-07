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
}