<?php
require_once 'DB.php';

/**
 * Class AuthorisationModel
 *
 * Authorizing that the token is valid.
 */
class AuthorisationModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * A simple authorisation mechanism - just checking that the token matches the one in the database
     * @param string $token the token you want to check if is valid
     * @return string indicating whether the token was successfully verified
     */
    public function isValid(string $token): string {
        $query = 'SELECT user FROM auth_token WHERE token = :token';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':token', $token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);

        if ($row[0] == 0) {
            return "";
        } else {
            return $row[0];
        }
    }
}