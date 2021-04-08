<?php


class TransporterHandler
{
    public function deleteResource(string $name): ?string
    {
        return (new TransporterModel())->deleteResource($name);
    }
}