<?php
use PDO;
class Product
{
    private $con;
    private $error;

    public function __construct($con)
    {
        $this->con = $con;
        $this->error = 0;
    }

    public function getAllProduct($limit = QUERY_LIMIT, $offset = 0)
    {
        $sql = "SELECT product.product_image, product.product_title, categories.category_title, product.product_desc, product.product_price, product.product_price, product.product_brand FROM product JOIN categories ON product.category_id = categories.id LIMIT ".$limit." OFFSET ".$offset;

        $stmt = $this->con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}