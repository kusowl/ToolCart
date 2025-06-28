<?php
include_once "Model.php";
include_once "OrderDetails.php";
class Orders extends Model
{
    private $id;
    private  $userId;
    private  $addressId;
    private  $couponId;
    private int $couponAmount;
    private string $date;
    private $orderDetails;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['user_id'] ?? null;
        $this->addressId = $data['address_id'] ?? null;
        $this->couponId = $data['coupon_id'] ?? null;
        $this->couponAmount = $data['coupon_amount'] ?? 0;
        $this->date = $data['date'] ?? '';
        $this->orderDetails = new OrderDetails();
    }

    public function addOrder(array $data)
    {
        $columns = [];
        $params = [];
        $products = [];

        foreach ($data as $field => $value) {
            if($field == 'products'){
                $products = $data['products'] ?? [];
            } elseif ($value !== '' && $value !== null) {
                $columns[] = $field;
                $params[":$field"] = $value;
            }
        }

        $placeholders = implode(', ', array_keys($params));
        $columnsStr = implode(', ', $columns);
        $sql = "INSERT INTO orders ({$columnsStr}) VALUES ({$placeholders})";

        $stmt = self::getDb()->prepare($sql);
        $stmt->execute($params);
        $this->id = self::getDb()->lastInsertId();

        // Save the product information
        foreach ($products as $product) {
            $orderData['order_id'] = $this->id;
            $orderData['product_id'] = $product['product_id'];
            $orderData['qty'] = $product['qty'];
            $orderData['price'] = $product['product_price'];
            $this->orderDetails->addOrderDetails($orderData);
        }
        
        return self::getDb()->errorInfo()[0];
    }

}