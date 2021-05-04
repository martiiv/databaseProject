<?php

class Authorisation
{
    public static function setAuthorisationToken(ApiTester $I)
    {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'EENV2yeVpGZCT8eCKxWh19fz9SZ4bA1Wh19GGkoQd4T8bHYtALHoQB6f82qqMxoh');
        $I->getClient()->getCookieJar()->set($cookie);
    }

}
