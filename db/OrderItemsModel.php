<?php
require_once 'DB.php';

/**
 * Class OrderItemsModel
 *
 * Class for handling order items list functionality like: add ski to order
 */
class OrderItemsModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Method for adding a ski to an order
     * @param array $filter filter array containing filter data for adding ski to order
     */
    public function addSkiToOrder(array $filter) {
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