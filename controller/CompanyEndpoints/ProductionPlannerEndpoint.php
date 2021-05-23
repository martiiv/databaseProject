<?php
require_once 'db/SkiModel.php';
require_once 'db/ProductionPlanModel.php';


/**
 * Class ProductionPlannerEndpoint is responsible to provide the production planner with functionality to create a production plan.
 */
class ProductionPlannerEndpoint
{
    /**
     * Handler for the production-planner endpoint
     * @param $uri array list of input parameters
     * @param $requestMethod string method requested like GET, POST, PUT....
     * @param $queries array included in the uri, i.e. ?state=state
     * @param $payload body of the request
     * @return array results
     * @throws APIException
     */
    public function handleRequest(array $uri, string $requestMethod, array $queries, body $payload): array
    {
        return match ($requestMethod) {
            RESTConstants::METHOD_POST => $this->handlePostRequest($uri, $payload),
            default => throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod),
        };
    }

    /**
     * This method will register a production plan for a selected period.
     * Example payload:
        [{
            "start": "2027-02-17",
            "end": "2020-03-17",
            "planner nr" : 10002
        },
        {
            "Active": 2,
            "Intrasonic": 1,
            "Endurance" : 5,
            "Race Pro" : 4
        }]
     * @param $uri array of input parameters
     * @param $payload body with info needed to register a production plan
     * @return array registered production plan
     * @throws APIException
     */
    private function handlePostRequest(array $uri, body $payload): array
    {
        if ($uri[0] == "plan" && count($uri) == 1) {
            $noSkies = 0;
            $skiModel = new SkiModel();


            // Check if there is info stored about start/end date
            if (sizeof($payload[0]) != 3 || !array_key_exists("start", $payload[0]) || !array_key_exists("end", $payload[0])) {
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "start or end date is not present");
            }
            if (!array_key_exists("planner nr", $payload[0])) {
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "planner nr is not present");
            }

            //Get start and end dates
            $startDate = $payload[0]["start"];
            $endDate = $payload[0]["end"];


            // Check if dates stored are valid
            if ($this->checkDate($startDate) == false) {
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "invalid begin date");
            }
            if ($this->checkDate($endDate) == false) {
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "invalid end date");
            }

            // TODO: Check that there is no existing plan in this timespan


            // Check that all the skies are valid (ski model exist)
            foreach ($payload[1] as $key => $value) {
                $validType = $skiModel->getSkiType($key);
                if (count($validType) > 0) {
                    $noSkies += (int)$value;
                } else {
                    unset($payload[1][$key]);
                    print ("Invalid ski type: " . $key);
                }
            }


            // Prepare production plan resource
            $resource = array();
            $resource['start_date'] = $startDate;
            $resource['end_date'] = $endDate;
            $resource['no_of_skis_per_day'] = $noSkies;
            $resource['production_planner_number'] = (int)$payload[0]['planner nr'];

            // Upload production plan
            $productionPlanModel = new ProductionPlanModel();
            $productionPlanModel->createResource($resource);

            // Fil production plan with skies
            foreach ($payload[1] as $key => $value) {
                $skiResource = array();
                $skiResource['amount'] = (int)$value;
                $skiResource['production_plan_start_date'] = $startDate;
                $skiResource['production_plan_end_date'] = $endDate;
                $skiResource['ski_type_model'] = $key;

                $productionPlanModel->addSkiesToList($skiResource);
            }

            // Prepare output
            $result = $resource;
            $result['plan'] = $payload[1];
            $res['result'] = $result;
            $res['status'] = RESTConstants::HTTP_CREATED;
            return $res;
        }
    }

    /**
     * This method will parse a date and check if it is valid
     * @param string $date date as yyyy-mm-dd
     * @return bool if date is valid or not
     */
    private function checkDate(string $date): bool
    {
        $tempDate = explode('-', $date);
        // checkdate(month, day, year) , input is yyyy-mm-dd
        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }
}