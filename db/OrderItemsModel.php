<?php
require_once 'DB.php';


class OrderItemsModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addSkiToOrder($filter) {
        $this->db->beginTransaction();
        $query = 'INSERT INTO order_items (amount, order_no, ski_type) VALUES (:amount, :order_no, :ski_type)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':amount', $filter['amount']);
        $stmt->bindValue(':order_no', $filter['order_no']);
        $stmt->bindValue(':ski_type', $filter['ski_type']);
        $stmt->execute();
        $this->db->commit();
    }
}