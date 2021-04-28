<?php


class ProductHandler
{
    /**
     * @return array|null - All the products within the database
     */
    public function getCollection(): ?array
    {
        return (new ProductModel())->getCollection();
    }

    /**
     * @param array $arr - An array with the data to be added to the database
     * @return array|null - Returns the entire product with its data
     */
    public function createResource(array $arr): ?array
    {
        // TODO - add if's to validate the input
        return (new ProductModel())->createResource($arr);
    }

}