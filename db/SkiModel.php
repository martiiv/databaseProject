<?php
require_once 'DB.php';


class SkiModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSkiType(string $model): array {
        $res = array();
        $query = 'SELECT model, ski_type, temperature, grip_system, size, weight_class, description, historical, photo_url, retail_price, production_date FROM ski_type WHERE model = :model';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':model', $model);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }

        return $res;
    }

}