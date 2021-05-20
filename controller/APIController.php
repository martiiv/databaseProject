<?php
require_once 'RESTConstants.php';
require_once 'controller/CustomerEndpoints/CustomerEndpoint.php';
require_once 'controller/CompanyEndpoints/StorekeeperEndpoint.php';
require_once 'controller/CompanyEndpoints/ProductionPlannerEndpoint.php';
require_once 'controller/CompanyEndpoints/CustomerRepEndpoint.php';
require_once 'controller/TransporterEndpoints/TransporterEndpoint.php';
require_once 'controller/PublicEndpoints/PublicEndpoint.php';
require_once 'db/AuthorisationModel.php';
require_once 'errors.php';

/**
 * Class APIController this is the main controller for the API - it is just a dispatcher forwarding the requests to the different endpoints.
 * It will also check if the user trying to access the endpoint has the appropriate authentication level.
 */
class APIController
{
    /**
     * Verifies that the request contains a valid authorisation token. The authorisation scheme is quite simple -
     * assuming that there is only one authorisation token for the complete API
     * @param string $token the authorisation token to be verified
     * @return string authentication level / endpoint access
     * @throws APIException with the code set to HTTP_FORBIDDEN if the token is not valid
     */
    public function authorise(string $token): string
    {
        if ($token == "") return RESTConstants::ENDPOINT_PUBLIC;

        $user = (new AuthorisationModel())->isValid($token);
        if ($user == "") {
            throw new APIException(RESTConstants::HTTP_FORBIDDEN, "");
        }
        return $user;
    }

    /**
     * Forwards the requests to the correct endpoints.
     * @param array $uri list of input parameters
     * @param string $requestMethod method requested like GET, POST, PUT....
     * @param array $queries included in the uri, i.e. ?state=state
     * @param array $payload of the request
     * @param string $user authentication level / endpoint access
     * @return array results
     * @throws APIException
     */
    public function handleRequest(array $uri, string $requestMethod,
                                  array $queries, array $payload, string $user): array
    {
        $endpointURL = strtolower($uri[0]);
        switch ($endpointURL) {
            case RESTConstants::ENDPOINT_CUSTOMER:
                $this->checkUser($user, $endpointURL);
                $endpoint = new CustomerEndpoint();
                break;
            case RESTConstants::ENDPOINT_STOREKEEPER:
                $this->checkUser($user, $endpointURL);
                $endpoint = new StorekeeperEndpoint();
                break;
            case RESTConstants::ENDPOINT_PRODUCTION_PLANNER:
                $this->checkUser($user, $endpointURL);
                $endpoint = new ProductionPlannerEndpoint();
                break;
            case RESTConstants::ENDPOINT_CUSTOMER_REP:
                $this->checkUser($user, $endpointURL);
                $endpoint = new CustomerRepEndpoint();
                break;
            case RESTConstants::ENDPOINT_TRANSPORTER:
                $this->checkUser($user, $endpointURL);
                $endpoint = new TransporterEndpoint();
                break;
            case RESTConstants::ENDPOINT_PUBLIC:
                $this->checkUser($user, $endpointURL);
                $endpoint = new PublicEndpoint();
                break;
            default: //Throw exception
        }
        return $endpoint->handleRequest(array_slice($uri, 1), $requestMethod, $queries, $payload);
    }

    /**
     * This method will check if the user has the right access to use the endpoint.
     * @param string $user authentication level / endpoint access
     * @param string $endpoint endpoints
     * @throws APIException
     */
    private function checkUser(string $user, string $endpoint)
    {
        if ($user != $endpoint) {
            if ($user != "root") {
                throw new APIException(RESTConstants::HTTP_FORBIDDEN, "");
            }
        }
    }
}