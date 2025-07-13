<?php
include_once 'Model.php';

class Product extends Model
{
    private int $error;
    private $id;
    private string $title;
    private string $description;
    private int $price;
    private string $brand;
    private int $stock;
    private $categoryId;
    private string $image;

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getId()
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
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['product_title'] ?? '';
        $this->description = $data['product_desc'] ?? '';
        $this->price = $data['product_price'] ?? 0;
        $this->brand = $data['product_brand'] ?? '';
        $this->stock = $data['product_stock'] ?? 1;
        $this->categoryId = $data['category_id'] ?? null;
        $this->image = $data['product_image'] ?? '';
        $this->error = 0;
    }

    public static function findById(int $id)
    {
        $sql = "SELECT product.id, product.product_image, product.product_title, product.category_id , product.product_desc, product.product_price, product.product_brand FROM product  WHERE product.id = :id";
        $stmt = self::getDb()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Product($row) : null;
    }

    public function getAllProduct(int $limit = QUERY_LIMIT, int $offset = 0)
    {
        $sql = "SELECT product.id, product.product_image, product.product_title, product.category_id , product.product_desc, product.product_price, product.product_brand FROM product LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products [] = new Product($row);
        }
        return $products;
    }

   public function getProductByCategory(string $key, int $limit = QUERY_LIMIT, int $offset = 0)
    {
        $sql = "SELECT product.id, product.product_image, product.product_title, product.category_id , product.product_desc, product.product_price, product.product_brand FROM product WHERE product.category_id = :key LIMIT {$limit} OFFSET {$offset}";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([
                ':key' => $key
            ]);
            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products [] = new Product($row);
            }
            return $products;
        } catch (Exception) {
        }
    }

    public function search(string $key, int $limit = QUERY_LIMIT, int $offset = 0)
    {
        $sql = 'SELECT p.id FROM product AS p  WHERE MATCH( product_title, product_desc, product_brand ) AGAINST ( :key IN NATURAL LANGUAGE MODE )';
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([':key' => $key]);
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $this->findById($row['id']);
        }
        return $products;
    }

    public function addProduct($title, $desc, $price, $brand, $image, $categoryId): bool
    {
        $sql = "SELECT `product_title` from `product` where product_title = :product_title";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([':product_title' => $title]);
        } catch
        (Exception) {
        }
        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO `product`(`category_id`, `product_title`, `product_desc`, `product_price`, `product_brand`, `product_image`) VALUES (:category_id, :title, :desc, :price, :brand, :image)";
            $result = false;
            try {
                $stmt = self::getDb()->prepare($sql);
                $result = $stmt->execute([
                    ':category_id' => $categoryId,
                    ':title' => $title,
                    ':desc' => $desc,
                    ':price' => $price,
                    ':brand' => $brand,
                    ':image' => $image
                ]);
            } catch (Exception) {
            }
            return $result;
        } else {
            return false;
        }
    }

    public function update($data = []): bool
    {
        $params = [];
        $placeholders = [];
        foreach ($data as $key => $value) {
            if ($key == 'product_image' and $value == '') continue;
            $placeholders[] = "`{$key}`" . ' = :' . $key;
            $params[":{$key}"] = $value;
        }
        $placeholders = implode(', ', $placeholders);
        $sql = "UPDATE `product` SET {$placeholders} WHERE id = :id";
        $result = false;
        try {
            $stmt = self::getDb()->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete()
    {

        $sql = "DELETE FROM `product` WHERE `id` = :id";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([
                ':id' => $this->id
            ]);
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getProductCount($limit = -1, $offset = 0)
    {
        $sql = 'SELECT COUNT(id) AS count FROM `product`';
        if($limit != -1){
            $sql .= ' LIMIT ' . $limit.' OFFSET ' . $offset;
        }
        $result = self::getDb()->query($sql);
        return $result->fetchColumn();
    }
}
