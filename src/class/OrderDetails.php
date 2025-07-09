<?php


class OrderDetails extends Model
{
    private $id;
    private $orderId;
    private $productId;
    private int $qty;
    private int $price;

    public function __construct($data = [])
    {
        $this->id = $data['id'];
        $this->orderId = $data['order_id'];
        $this->productId = $data['product_id'];
        $this->qty = $data['qty'] ?? 0;
        $this->price = $data['price'] ?? 0;
    }

    public function addOrderDetails(array $data)
    {
        $columns = [];
        $params = [];

        foreach ($data as $field => $value) {
            if ($value !== '' && $value !== null) {
                $columns[] = $field;
                $params[":$field"] = $value;
            }
        }

        $placeholders = implode(', ', array_keys($params));
        $columnsStr = implode(', ', $columns);
        $sql = "INSERT INTO OrderDetails ({$columnsStr}) VALUES ({$placeholders})";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute($params);
        return $stmt->errorInfo()[0];
    }

    public function getTotalAmount(): float|int
    {
       return $this->qty * $this->price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    public function getOrderId(): mixed
    {
        return $this->orderId;
    }

    public function setOrderId(mixed $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getProductId(): mixed
    {
        return $this->productId;
    }

    public function setProductId(mixed $productId): void
    {
        $this->productId = $productId;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

}