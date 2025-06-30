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
    private string $paymentType;
    private string $date;
    private OrderDetails $orderDetails;
    private string $razorpayRecipt;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['user_id'] ?? null;
        $this->addressId = $data['address_id'] ?? null;
        $this->couponId = $data['coupon_id'] ?? null;
        $this->couponAmount = $data['coupon_amount'] ?? 0;
        $this->paymentType = $data['payment_type'] ?? '';
        $this->date = $data['date'] ?? '';
        $this->razorpayRecipt = $data['razorpay_recipt'] ?? '';
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

    public function setStaus($orderId, $status)
    {
        $sql = "UPDATE `orders` SET `payment_status`='{$status}' WHERE `id` = {$orderId}";
        $stmt = self::getDb()->exec($sql);
        return self::getDb()->errorInfo()[0];
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): mixed
    {
        return $this->userId;
    }

    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }

    public function getAddressId(): mixed
    {
        return $this->addressId;
    }

    public function setAddressId(mixed $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function getCouponId(): mixed
    {
        return $this->couponId;
    }

    public function setCouponId(mixed $couponId): void
    {
        $this->couponId = $couponId;
    }

    public function getCouponAmount(): int
    {
        return $this->couponAmount;
    }

    public function setCouponAmount(int $couponAmount): void
    {
        $this->couponAmount = $couponAmount;
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    public function setPaymentType(string $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getOrderDetails(): OrderDetails
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(OrderDetails $orderDetails): void
    {
        $this->orderDetails = $orderDetails;
    }



}