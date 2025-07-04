<?php
include_once 'Model.php';
class Cart extends Model
{
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



    public function addItem(int $productId, int $qty = 1): bool
    {
        // Check if the product is already in the cart
        $sql = "SELECT count(*) as total FROM `cart` WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([
            ':product_id' => $productId,
            ':user_id' => $this->getUserId()
        ]);
        $res = false;
        if ($stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0) {
            // product exists then update quantity
            $sql = "UPDATE `cart` SET `qty`= `qty` + 1 WHERE `product_id` = :product_id AND user_id = :user_id";
            $stmt = self::getDb()->prepare($sql);
            $res = $stmt->execute([
                ':product_id' => $productId,
                ':user_id' => $this->getUserId()
            ]);
        } else {
            $sql = "INSERT INTO `cart` (`product_id`, `user_id`, `qty`) VALUES (:product_id,:user_id, :qty)";
            $stmt = self::getDb()->prepare($sql);
            $res = $stmt->execute([':product_id' => $productId, ':user_id' => $this->getUserId(),':qty' => $qty]);
        }
        return $res;
    }

    public function removeItem(int $productId): bool
    {
       $sql = "DELETE FROM `cart` WHERE product_id = :product_id AND user_id = :user_id";
       $stmt = self::getDb()->prepare($sql);
       $res = $stmt->execute([':product_id' => $productId, ':user_id' => $this->getUserId()]);
       return $res;
    }

    public function getAllItem(int $limit = QUERY_LIMIT, int $offset = 0): array
    {
        $sql = "SELECT c.`id`, c.`product_id`, c.`qty`, c.`is_ordered`, p.product_title, p.product_price, p.product_image FROM `cart` c JOIN product p ON c.product_id = p.id WHERE `user_id` = :user_id LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute(array(':user_id' => $this->getUserId()));
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function getCartItemTotal(): array
    {
        $sql = "select sum(qty) AS total_qty from `cart` where user_id = ".$this->getUserId();
        $stmt = self::getDb()->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
    }

    public function setQuantity(int $productId, int $qty): bool
    {
        $sql = "UPDATE `cart` SET `qty`= :qty WHERE product_id = :product_id and user_id = :user_id";
        $stmt = self::getDb()->prepare($sql);
        $res = $stmt->execute([':qty' => $qty, ':product_id' => $productId, ':user_id' => $this->getUserId()]);
        return $res;
    }

    public function getCartValue()
    {
        $sql = 'SELECT SUM(c.qty * p.product_price) AS total FROM cart c JOIN product p ON p.id = c.product_id WHERE c.user_id = :user_id';
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([
            ':user_id' => $this->getUserId()
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

}