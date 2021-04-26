<?php


class SkiModelHandler
{
    public function getResource(int $id): ?array
    {
        return (new SkiModel())->getResource($id);
    }

    public function getCollection(): ?array
    {
        return (new SkiModel())->getCollection();
    }

    public function createResource(array $arr): ?int
    {
        return (new SkiModel())->createResource($arr);
    }

    /**
     * @throws APIException
     */
    public function updateResource(array $arr): ?int
    {
        if ($arr['ski_model'] == "") throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "No ski model provided");
        if ($arr['historical'] == 0) throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $message = "Please use the value 1 to set the historical value!");

        return (new SkiModel())->updateResource($arr);
    }

    public function deleteResource(string $ski_model): ?string
    {
        return (new SkiModel())->deleteResource($ski_model);
    }
}