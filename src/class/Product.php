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

    public function findById(int $id)
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
}
