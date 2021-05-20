<?php
require_once "db/ProductModel.php";

class ProductTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Function testGetCollection
     *
     * Gets all the products from the database using the getCollection-method in ProductModel.
     *
     * For each product, json encode the product data and display it.
     */
    public function testGetCollection()
    {
        $productModel = new ProductModel();
        $products = $productModel->getCollection();
        foreach ($products as $product) {
            print(json_encode($product));
            print("\n");
        }
    }

    /**
     * Function testCreateResource
     *
     * Creates a new product with data using createResource-method in ProductModel.
     *
     * Sends an array with data to the method.
     *
     * Checks that the content added to the database is the same as the input data.
     */
    public function testCreateResource()
    {
        // The instance to be created
        $arr = array(
            'ski_type' => "Active Pro",
            'amount' => 5
        );

        $productModel = new ProductModel();
        // Creates all the products, returns array with all products
        $newProduct = $productModel->createResource($arr);
        // For each product created - Assert the ski types
        for ($i = 0; $i < $arr['amount']; $i++) {
            $this->assertEquals(json_encode($newProduct[$i]['ski_type']), json_encode($arr['ski_type']));
        }
    }
}