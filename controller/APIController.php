<?php
require_once 'RESTConstants.php';
require_once 'controller/CustomerEndpoints/CustomerEndpoint.php';
require_once 'controller/CompanyEndpoints/StorekeeperEndpoint.php';
require_once 'controller/CompanyEndpoints/ProductionPlannerEndpoint.php';
require_once 'db/AuthorisationModel.php';
require_once 'errors.php';

/**
 * Class APIController this is the main controller for the API - it is just a dispatcher forwarding the requests to
 *       the DealersEndpoint, UsedCarsEndpoint, or ReportController depending on the what endpoint is addressed
 */
class APIController
{
    /**
     * Verifies that the request contains a valid authorisation token. The authorisation scheme is quite simple -
     * assuming that there is only one authorisation token for the complete API
     * @param string $token the authorisation token to be verified
     * @param string $endpointPath the request endpoint
     * @throws APIException with the code set to HTTP_FORBIDDEN if the token is not valid
     */
    public function authorise(string $token)
    {
        if (!(new AuthorisationModel())->isValid($token)) {
            throw new APIException(RESTConstants::HTTP_FORBIDDEN, "");
        }
    }


    public function handleRequest(array $uri, string $requestMethod,
                                  array $queries, array $payload): array
    {
        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_CUSTOMER:
                $endpoint = new CustomerEndpoint();
                break;
            case RESTConstants::ENDPOINT_STOREKEEPER:
                $endpoint = new StorekeeperEndpoint();
                break;
            case RESTConstants::ENDPOINT_PRODUCTION_PLANNER:
                $endpoint = new ProductionPlannerEndpoint();
                break;
        }
        return $endpoint->handleRequest(array_slice($uri, 1), $requestMethod, $queries, $payload);
    }
}