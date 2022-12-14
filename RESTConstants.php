<?php

/**
 * Class RESTConstants class for application constants.
 */
class RESTConstants
{
    const API_URI = 'http://localhost/api/v0.8';
    const SECRET = " ybhu9nn234";

    // HTTP method names
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    // HTTP status codes
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;

    // Defined application endpoints
    const ENDPOINT_CUSTOMER = "customer";
    const ENDPOINT_STOREKEEPER = "storekeeper";
    const ENDPOINT_PRODUCTION_PLANNER = "planner";
    const ENDPOINT_CUSTOMER_REP = "customer-rep";
    const ENDPOINT_TRANSPORTER = "transporter";
    const ENDPOINT_PUBLIC = "public";

    // Defined database errors
    const DB_ERR_ATTRIBUTE_MISSING = 1;
    const DB_ERR_FK_INTEGRITY = 2;

    // Defined foreign key violations
    const DB_FK_DEALER_COUNTY = 1001;
    const DB_FK_CAR_DEALER = 1002;
}
