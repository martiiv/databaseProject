<?php


class CustomerHandler
{
    public function getCollection(): ?array
    {
        return (new CustomerModel())->getCollection();
    }
}