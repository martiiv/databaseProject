<?php


class TransporterHandler
{
    public function deleteResource(string $name): ?bool
    {
        return (new TransporterModel())->deleteResource($name);
    }
}