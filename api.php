<?php
require_once 'controller/APIController.php';
require_once 'controller/APIException.php';
require_once 'controller/BadRequestException.php';
require_once 'errors.php';
header('Content-Type: application/json');


// Parse request parameters
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
if (!isset($queries['request'])) {
    http_response_code(RESTConstants::HTTP_NOT_FOUND);
    echo json_encode(generateErrorResponseContent(RESTConstants::HTTP_NOT_FOUND, '/'));
    return;
}

// Gets the URI's - puts them into an array
$uri = explode('/', $queries['request']);
unset($queries['request']);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Gets the body of the request
$content = file_get_contents('php://input');
if (strlen($content) > 0) {
    $payload = json_decode($content, true);
} else {
    $payload = array();
}

// Checks if there is a cookie with name "auth_token"
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : '';

// Handle the request
$controller = new APIController();
try {
    $user = $controller->authorise($token, RESTConstants::API_URI . '/');
    $res = $controller->handleRequest($uri, $requestMethod, $queries, $payload, $user);
    http_response_code($res['status']);
    if (isset($res['result'])) {
        echo json_encode($res['result']);
    }

// Handle application exceptions
} catch (APIException $e) {
    http_response_code($e->getCode());
    echo json_encode(generateErrorResponseContent($e->getCode(), $e->getInstance(), $e->getDetailCode(), $e));
} catch (Throwable $e) {
    http_response_code(RESTConstants::HTTP_INTERNAL_SERVER_ERROR);
    echo json_encode(generateDBErrorResponseContent(RESTConstants::HTTP_INTERNAL_SERVER_ERROR, '/', -1));
}