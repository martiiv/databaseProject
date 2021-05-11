<?php

class Authorisation
{
    public static function setAuthorisationToken(ApiTester $I)
    {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'c9caceea4162fdad403fbdf926ebc9ebf6b9f37688fbb051c15913cc3058c739');
        $I->getClient()->getCookieJar()->set($cookie);
    }
}
