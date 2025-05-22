<?php

class Cart
{
    private static PDO $dbCon;
    private $userId;
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public static function setDb(PDO $pdo)
    {
       self::$dbCon = $pdo;
    }

    public function addItem(int $productId, int $qty = 1): bool
    {
        // Check if the product is already in the cart
        $sql = "SELECT count(*) as total FROM `cart` WHERE product_id = :product_id";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        $res = false;
        if ($stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0) {
            // product exists then update quantity
            $sql = "UPDATE `cart` SET `qty`= `qty` + 1 WHERE `product_id` = :product_id";
            $stmt = self::$dbCon->prepare($sql);
            $res = $stmt->execute([':product_id' => $productId]);
        } else {
            $sql = "INSERT INTO `cart` (`product_id`, `user_id`, `qty`) VALUES (':product_id',':user_id', ':qty')";
            $stmt = self::$dbCon->prepare($sql);
            $res = $stmt->execute([':product_id' => $productId, ':user_id' => $this->getUserId(),':qty' => $qty]);
        }
        return $res;
    }

    public function getAllItem(int $limit = QUERY_LIMIT, int $offset = 0): array
    {
        $sql = "SELECT c.`id`, c.`product_id`, c.`qty`, p.product_title, p.product_price FROM `cart` c JOIN product p ON c.product_id = p.id WHERE `user_id` = :user_id LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute(array(':user_id' => $this->getUserId()));
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function getCartItemTotal(): array
    {
        $sql = "select sum(qty) AS total_qty from `cart`";
        $stmt = self::$dbCon->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
    }

}