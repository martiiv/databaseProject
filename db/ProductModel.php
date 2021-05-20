<?php
require_once 'DB.php';
require_once 'db/ProductModel.php';

/**
 * Class ProductModel
 *
 * Class for handling product functionality like: retrieve and create new products
 */
class ProductModel extends DB
{
    /**
     * Gets all the products in the database
     * @param array|null $query
     * @return array array containing all products
     */
    function getCollection(array $query = null): array
    {
        $res = array();
        $query = 'SELECT product_no, production_date, ski_type FROM product';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Retrieves a specific product based on product ID
     * @param int $id ID of the product of interest
     * @return array|null array containing the product and product information
     */
    function getResource(int $id): ?array
    {
        $res = array();
        $query = 'SELECT product_no, production_date, ski_type FROM product WHERE product_no = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Create new product
     * @param array $resource array containing information about product to be created
     * @return array array containing the newly created product and its data.
     */
    function createResource(array $resource): array
    {
        // Todays date in YYYY-MM-DD format
        $todaysDate = date("Y/m/d");
        // Number of skis to "produce"
        $amount = intval($resource['amount']);
        // Used to store information about each product
        $res = array();
        // Used to store all the products created and returns them
        $arrSkis = array();

        $this->db->beginTransaction();

        // For the amount of products the customer wants, produce this amount of skis/products
        for ($i = 0; $i < $amount; $i++) {
            $query = 'INSERT INTO product (production_date, ski_type) VALUES (:production_date, :ski_type)';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':production_date', $todaysDate);
            $stmt->bindValue(':ski_type', $resource['ski_type']);
            $stmt->execute();

            // Store the data about one specific product
            $res['product_no'] = $this->db->lastInsertId();
            $res['production_date'] = $todaysDate;
            $res['ski_type'] = $resource['ski_type'];

            // Store the product produced inside the list
            $arrSkis[$i] = $res;
        }

        $this->db->commit();

        // Return all the products produced in this "round"
        return $arrSkis;
    }
}