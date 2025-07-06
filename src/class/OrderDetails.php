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


}