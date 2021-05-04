<?php
require_once 'db/SkiModel.php';
require_once 'db/ProductionPlanModel.php';


class ProductionPlannerEndpoint
{
    public function handleRequest($uri, $requestMethod, $queries, $payload): array
    {
        switch ($requestMethod) {
            case RESTConstants::METHOD_POST:
                return $this->handlePostRequest($uri, $payload);
            default:
                throw new APIException(RESTConstants::HTTP_NOT_IMPLEMENTED, $requestMethod);
        }
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
     * @param $uri list of input parameters
     * @param $payload All the info needed to register a prodcution plan
     * @return array registered production plan
     * @throws APIException
     */
    private function handlePostRequest($uri, $payload): array
    {
        if ($uri[0] == "plan" && count($uri) == 1) {
            $noSkies = 0;
            $skiModel = new SkiModel();


            // Check if there is info stored about start/end date
            if (sizeof($payload[0]) != 3 || !array_key_exists("start", $payload[0]) || !array_key_exists("end", $payload[0])) {
                print ("bad request, start or end date is not present");
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, null);
            }
            if (!array_key_exists("planner nr", $payload[0])) {
                print ("bad request, planner nr is not present");
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, null);
            }

            //Get start and end dates
            $startDate = $payload[0]["start"];
            $endDate = $payload[0]["end"];


            // Check if dates stored are valid
            if ($this->checkDate($startDate) == false) {
                print ("bad request, invalid begin date");
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, null);
            }
            if ($this->checkDate($endDate) == false) {
                print ("bad request, invalid end date");
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, null);
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