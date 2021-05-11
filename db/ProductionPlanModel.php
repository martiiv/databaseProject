<?php
require_once 'DB.php';

/**
 * Class OrderModel
 */
class ProductionPlanModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    function createResource(array $resource): int
    {
        $this->db->beginTransaction();
        $query = 'INSERT INTO production_plan (start_date, end_date, no_of_skis_per_day, production_planner_number) VALUES (:start_date, :end_date, :no_of_skis_per_day, :production_planner_number)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':start_date', $resource['start_date']);
        $stmt->bindValue(':end_date', $resource['end_date']);
        $stmt->bindValue(':no_of_skis_per_day', $resource['no_of_skis_per_day']);
        $stmt->bindValue(':production_planner_number', $resource['production_planner_number']);
        $stmt->execute();
        $id = $this->db->lastInsertId();
        $this->db->commit();

        return $id;
    }

    function addSkiesToList(array $resource)
    {
        $this->db->beginTransaction();
        $query = 'INSERT INTO production_list (amount, production_plan_start_date, production_plan_end_date, ski_type_model) VALUES (:amount, :production_plan_start_date, :production_plan_end_date, :ski_type_model)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':amount', $resource['amount']);
        $stmt->bindValue(':production_plan_start_date', $resource['production_plan_start_date']);
        $stmt->bindValue(':production_plan_end_date', $resource['production_plan_end_date']);
        $stmt->bindValue(':ski_type_model', $resource['ski_type_model']);
        $stmt->execute();
        $this->db->commit();
    }

    /**
     * Function getSummary, will select all entries from the production list
     * Getting the entire list of skis up for production
     * @return array
     */
    function getDates(): array
    {
        $res = array();
        $this->db->beginTransaction();
        $query = 'SELECT start_date FROM production_plan ORDER BY start_date DESC LIMIT 4';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $this->db->commit();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    function getSki_models(string $date){
        $res = array();
        $this->db->beginTransaction();
        $query = 'SELECT amount, ski_type_model FROM production_list WHERE production_plan_start_date = :date';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        $this->db->commit();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }
}
