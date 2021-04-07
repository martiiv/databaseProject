<?php
require_once 'DB.php';

/**
 * Class OrderModel
 */
class CustomerModel extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();
    }

    function getCollection(array $query = null): array
    {
        // TODO: Implement getCollection() method.
    }

    function getResource(int $id): ?array
    {
        // TODO: Implement getResource() method.
    }

    function createResource(array $resource): array
    {
        // TODO: Implement createResource() method.
    }

    function updateResource(array $resource): array
    {
        // TODO: Implement updateResource() method.
    }

    function deleteResource(int $id)
    {
        // TODO: Implement deleteResource() method.
    }
}