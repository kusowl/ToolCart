<?php
use PDO;
class Product
{
    private static $dbCon;
    private int $error;
    private  $id;
    private string $title;
    private string $description;
    private int $price;
    private string $brand;
    private int $stock;
    private $category_id;
    private string $image;

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['product_title'] ?? '';
        $this->description = $data['product_desc'] ?? '';
        $this->price = $data['product_price'] ?? 0;
        $this->brand = $data['product_brand'] ?? '';
        $this->stock = $data['product_stock'] ?? 1;
        $this->category_id = $data['category_id'] ?? null;
        $this->image = $data['product_image'] ?? '';
        $this->error = 0;
    }

    public static function setDb(PDO $pdo)
    {
        self::$dbCon = $pdo;
    }

    public function findById(int $id)
    {
        $sql = "SELECT product.id, product.product_image, product.product_title, product.category_id , product.product_desc, product.product_price, product.product_brand FROM product  WHERE product.id = :id";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Product($row) : null;
    }

    public function getAllProduct(int $limit = QUERY_LIMIT, int $offset = 0)
    {
        $sql = "SELECT product.id, product.product_image, product.product_title, product.category_id , product.product_desc, product.product_price, product.product_brand FROM product LIMIT {$limit} OFFSET {$offset}";

        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $products = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $products [] = new Product($row);
        }
        return $products;
    }
}