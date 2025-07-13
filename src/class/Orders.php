<?php
include_once "Model.php";
include_once "OrderDetails.php";
include_once "Cart.php";
class Orders extends Model
{
    private $id;
    private  $userId;
    private  $addressId;
    private  $couponId;
    private float $amount;
    private int $couponAmount;
    private string $paymentType;
    private string $paymentStatus;
    private string $razorpayRecipt;
    private string $deliveryStatus;
    private string $date;
    private string $status;
    /**
     * @var OrderDetails[]
     */
    private array $orderDetails;
    private Cart $cart;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['user_id'] ?? null;
        $this->addressId = $data['address_id'] ?? null;
        $this->couponId = $data['coupon_id'] ?? null;
        $this->amount = $data['amount'] ?? 0;
        $this->couponAmount = $data['coupon_amount'] ?? 0;
        $this->paymentType = $data['payment_type'] ?? '';
        $this->paymentStatus = $data['payment_status'] ?? '';
        $this->razorpayRecipt = $data['razorpay_recipt'] ?? '';
        $this->deliveryStatus = $data['delivery_status'] ?? '';
        $this->date = $data['date'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->orderDetails = $data['orderDetails'] ?? [new OrderDetails()];
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
            if(empty($products)) {
                throw new Exception("Products array is empty");
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
                $this->orderDetails[0]->addOrderDetails($orderData);
                // Removed products from cart
                $cart->removeItem($product['product_id']);
            }
            self::getDb()->commit();
            return [
                'success' => true,
                'order_id' => $this->id,
            ];
        }catch (Exception $e){
            self::getDb()->rollBack();
            error_log($e->getMessage());
        }
        finally{
            return[
                'success' => false,
                'error' => self::getDb()->errorInfo()[0]
            ];
        }
    }

    public function setPaymentStaus($orderId, $status)
    {
        $sql = "UPDATE `orders` SET `payment_status`='{$status}' WHERE `id` = {$orderId}";
        $stmt = self::getDb()->exec($sql);
        return self::getDb()->errorInfo()[0];
    }
    public function setDeliveryStaus($orderId, $status){
        $sql = "UPDATE `orders` SET `delivery_status`='{$status}' WHERE `id` = {$orderId}";
        $stmt = self::getDb()->exec($sql);
        return self::getDb()->errorInfo()[0];
    }

    public function setStatus($orderId, $status)
    {
        $sql = "UPDATE `orders` SET `status`='{$status}' WHERE `id` = {$orderId}";
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
    /**
     * @param int $limit
     * @param int $offset
     * @return Orders[]
     */
    public static function getAllOrders($userId = '', int $limit = QUERY_LIMIT, int $offset = 0, $orderBy="id", $sort="DESC"): array
    {
        if($userId != ''){
            $sql  = "SELECT * FROM orders WHERE `user_id` = '{$userId}' ORDER BY {$orderBy} {$sort} LIMIT {$limit} OFFSET {$offset} }";
        }else{
            $sql  = "SELECT * FROM orders ORDER BY {$orderBy} {$sort} LIMIT {$limit} OFFSET {$offset} ";
        }
        $stmt = self::getDb()->query($sql, PDO::FETCH_ASSOC);
        $ordersRecord = $stmt->fetchAll();
        $orders = [];
        foreach ($ordersRecord as &$order) {
            $sql  = "SELECT * FROM OrderDetails WHERE order_id = :order_id ";
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([
                ':order_id' => $order['id']
            ]);
            $orderDetails = $stmt->fetchAll();
            $order['orderDetails'] = array_map(function ($item) {return new OrderDetails($item);}, $orderDetails);
           $orders[] = new Orders($order);
        }
        return $orders;
    }

    public static function getOrderCount(int $limit = -1, int $offset = 0): int
    {
        $sql = 'SELECT COUNT(id) as number FROM `orders`';
        if($limit != -1){
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $result = self::getDb()->query($sql);
        return $result->fetchColumn();
    }

    public static function getRevenue(int $limit = -1, int $offset = 0): int
    {
        $sql = 'SELECT SUM(amount) AS revenue FROM `orders`';
        if($limit != -1){
            $sql .= ' LIMIT '.$limit.' OFFSET '.$offset;
        }
        $result = self::getDb()->query($sql);
        return $result->fetchColumn();
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

    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(OrderDetails $orderDetails): void
    {
        $this->orderDetails = $orderDetails;
    }

    public function getPaymentStatus(): string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(string $paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function getRazorpayRecipt(): string
    {
        return $this->razorpayRecipt;
    }

    public function setRazorpayRecipt(string $razorpayRecipt): void
    {
        $this->razorpayRecipt = $razorpayRecipt;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDeliveryStatus(): string
    {
        return $this->deliveryStatus;
    }

    /**
     * @param string $deliveryStatus
     */
    public function setDeliveryStatus(string $deliveryStatus): void
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    public function getStatus()
    {
        return $this->status;
    }

}