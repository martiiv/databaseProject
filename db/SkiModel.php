<?php
require_once 'DB.php';


class SkiModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createSkiType(array $resource){
        $this->db->beginTransaction();
        $query =
            'INSERT INTO ski_type (model,ski_type, temperature,grip_system,size, weight_class,description,historical,photo_url,retail_price,production_date)
             VALUES (:model, :ski_type, :temperature, :grip_system, :size, :weight_class, :description, :historical, :photo_url, :retail_price, :production_date)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':model', $resource['model']);
        $stmt->bindValue(':ski_type', $resource['ski_type']);
        $stmt->bindValue(':temperature', $resource['temperature']);
        $stmt->bindValue(':grip_system', $resource['grip_system']);
        $stmt->bindValue(':size', $resource['size']);
        $stmt->bindValue(':weight_class', $resource['weight_class']);
        $stmt->bindValue(':description', $resource['description']);
        $stmt->bindValue(':historical', $resource['historical']);
        $stmt->bindValue(':photo_url', $resource['photo_url']);
        $stmt->bindValue(':retail_price', $resource['retail_price']);
        $stmt->execute();
        $this->db->commit();

        return $resource;
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

    public function updateResouce(array $resource): array{
        $this->db->beginTransaction();
        $query = 'UPDATE ski_type SET  historical = :historical WHERE ski_model = :ski_model';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':historical',$resource['historical']);
        $stmt->bindValue(':ski_model', $resource['ski_model']);
        $stmt->execute();
        $this->db->commit();

        return $resource['ski_model'];
    }

}