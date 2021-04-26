<?php
require_once 'DB.php';

/**
 * Class SkiModel contains all functionality for handling the ski_type entity
 * Contains the following functions:
 *                                  createSkiType
 *                                  updateSkiType
 *                                  getSkiType
 *                                  deleteSkiType
 * @author Martin Iversen
 * @date 26.04.2021
 * @version 0.8
 */
class SkiModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Function createSkiType
     * Creates a ski_type in the database
     * @param array $resource the array containing the fields for the entity
     * @return array The created entity of type Ski_type
     */
    public function createSkiType(array $resource){
        $this->db->beginTransaction();
        $query =
            'INSERT INTO ski_type (model,ski_type, temperature,grip_system,size, weight_class,description,historical,photo_url,retail_price)
             VALUES (:model, :ski_type, :temperature, :grip_system, :size, :weight_class, :description, :historical, :photo_url, :retail_price)';

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

    /**
     * Function getSkiType
     * Returns a specific ski_type from the database given a ski_model name
     * @param string $model the ski_model name of the ski_type you want
     * @return array        the array of information about the returned ski_type
     */
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

    /**
     * updateSkitype
     * Updates the historical value of a given ski type
     * @param array $resource the array containing the ski_model to be changed and the historical value 1
     * @return string returns the ski model you changed
     */
    public function updateSkitype(array $resource): string{
        $this->db->beginTransaction();
        $query = 'UPDATE ski_type SET  historical = :historical WHERE model = :model';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':historical',$resource['historical']);
        $stmt->bindValue(':model', $resource['model']);
        $stmt->execute();
        $this->db->commit();

        return $resource['model'];
    }

    /**
     * deleteSkitype
     * Deletes a ski_type given a ski_model
     * @param string $model The model name of the ski you want to delete
     * @return string A fitting message either success or failure
     * //TODO Remove this function
     */
    public function deleteSkitype(string $model): string{
        $success = "";
        $this->db->beginTransaction();

        $query = 'DELETE FROM ski_type WHERE model = (:model)';

        $stmt = $this->db->prepare( $query);
        $stmt->bindValue(':model',$model);
        $stmt->execute();

        $this->db->commit();

        $success = 'Succesfully deleted ski type with ski model:'. strval($model).'.';

        if(strlen($success)==0) {
            $success = 'Failed to delete ski type with ski model:'.strval($model).'.';
        }
        return $success;
    }

}