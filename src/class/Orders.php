<?php

use Razorpay\Api\Order;

include_once "Model.php";
include_once "OrderDetails.php";
include_once "Cart.php";
class Orders extends Model
{
    private $id;
    private  $userId;
    private  $addressId;
    private  $couponId;
    private int $couponAmount;
    private string $paymentType;
    private string $date;
    private string $razorpayRecipt;
    /** @var OrderDetails[] */
    private array $orderDetails;

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
        $this->orderDetails = $data['order_details'] ?? [];
    }

    public function addOrder(array $data)
    {
        try {
            // As there are multiple queries involved which depended on each other,
            // i am using transaction for Atomicity
            self::getDb()->beginTransaction();
            $columns = [];
            $params = [];
            $products = [];

            foreach ($data as $field => $value) {
                if ($field == 'products') {
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
            $cart = new Cart($data['user_id']);

            // Save the product information
            foreach ($products as $product) {
                $orderData['order_id'] = $this->id;
                $orderData['product_id'] = $product['product_id'];
                $orderData['qty'] = $product['qty'];
                $orderData['price'] = $product['product_price'];
                $this->orderDetails->addOrderDetails($orderData);
                // Removed products from cart
                $cart->removeItem($product['product_id']);
            }
            self::getDb()->commit();
        }catch (Exception $e){
            self::getDb()->rollBack();
            error_log($e->getMessage());
        }
        finally{
            return self::getDb()->errorInfo()[0];
        }
    }

    public function setStaus($orderId, $status)
    {
        $sql = "UPDATE `orders` SET `payment_status`='{$status}' WHERE `id` = {$orderId}";
        $stmt = self::getDb()->exec($sql);
        return self::getDb()->errorInfo()[0];
    }

    /**
     * @throws Exception
     */
    public static function getByOrderId($orderId): Orders
    {
        $sql = "SELECT * FROM `orders` WHERE `id` = {$orderId}";
        $orderData = self::getDb()->query($sql)->fetch(PDO::FETCH_ASSOC);
        if($orderData == false){
            throw new Exception("Order not found");
        }
        $order = new Orders($orderData);
        $sql = "SELECT * FROM `OrderDetails` WHERE `order_id` = '{$orderId}'";
        $orderDetailsData = self::getDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if($orderDetailsData == false){
            throw new Exception("Order details not found");
        }
        foreach ($orderDetailsData as $orderDetails) {
            $order->orderDetails[] = new OrderDetails($orderDetails);
        }
        return $order;
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