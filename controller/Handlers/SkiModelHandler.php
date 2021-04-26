<?php


class SkiModelHandler
{
    public function getResource(int $id): ?array
    {
        return (new SkiModel())->getSkiType($id);
    }

    public function getCollection(): ?array
    {
        return (new SkiModel())->getCollection();
    }

    public function createResource(array $arr): array
    {
        return (new SkiModel())->createSkiType($arr);
    }

    /**
     * @throws APIException if either the ski model is empty or the historical is 0
     */
    public function updateResource(array $arr): string
    {
        if ($arr['model'] == "") throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "No ski model provided");
        if ($arr['historical'] == 0) throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "Please use the value 1 to set the historical value!");

        return (new SkiModel())->updateSkitype($arr);
    }

    public function deleteResource(string $model): ?string
    {
        return (new SkiModel())->deleteSkitype($model);
    }
}