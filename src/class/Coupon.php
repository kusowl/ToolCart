<?php
include_once 'Model.php';

class Coupon extends Model
{
    private mixed $id;
    private string $code;
    private string $type;
    private int $value;
    private string $description;
    private ?DateTime $expiryDate;
    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->code = $data['code'] ?? '';
        $this->type = $data['type'] ?? 'amount';
        $this->value = $data['value'] ?? 0;
        $this->description = $data['desc'] ?? '';
        $this->expiryDate = $data['expiry_date'] == '' ? null : date_create($data['expiry_date']);
    }

    /**
     * @param string $code
     * @param string $type
     * @param int $value
     * @param string $desc
     * @return boolean
     */
    public function addCoupon(string $code, string $type, int $value, string $desc, string $expiryDate)
    {
        $sql = 'INSERT INTO `coupon`(`code`, `type`, `value`, `desc`, `expiry_date`) VALUES (:code, :type, :value, :desc, :expiry_date)';

        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([
                ':code' => $code,
                ':type' => $type,
                ':value' => $value,
                ':desc' => $desc,
                ':expiry_date' => $expiryDate
            ]);
            return true;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @param string $code
     * @return Coupon|false
     */
    public static function getByCode(string $code): Coupon|false
    {
        $sql = 'SELECT `id`, `code`, `type`, `value`,`expiry_date` , `desc` FROM `coupon` WHERE code = :code LIMIT 1';
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([
            ':code' => $code
        ]);
        if($stmt->rowCount() > 0){
            return new Coupon($stmt->fetch(PDO::FETCH_ASSOC));
        }else{
            return false;
        }

    }

    /**
     * @param $id
     * @return Coupon
     */
    public function getById($id): Coupon
    {
        $sql = 'SELECT `id`, `code`, `type`, `value`, `expiry_date`, `desc` FROM `coupon` WHERE id = :id LIMIT 1';
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return new Coupon($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array|Coupon
     */
    public function getAllCoupons(int $limit = QUERY_LIMIT, int $offset = 0): array|Coupon
    {
        $sql = "SELECT `id`, `code`, `type`, `value`, `expiry_date` , `desc` FROM `coupon` LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::getDb()->query($sql);
        $coupons = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coupons[] = new Coupon($row);
        }
        return $coupons;
    }

    public function update($data = [])
    {
        $params = [];
        $placeholders = [];
        foreach ($data as $key => $value) {
            $placeholders[] = "`{$key}`" . ' = :' . $key;
            $params[":{$key}"] = $value;
        }
        $placeholders = implode(', ', $placeholders);
        $sql = "UPDATE `coupon` SET {$placeholders} WHERE id = :id";
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

        $sql = "DELETE FROM `coupon` WHERE `id` = :id";
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
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Coupon
    {
        $this->description = $description;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): Coupon
    {
        $this->value = $value;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Coupon
    {
        $this->type = $type;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Coupon
    {
        $this->code = $code;
        return $this;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): Coupon
    {
        $this->id = $id;
        return $this;
    }

    public function getExpiryDate(): ?DateTime
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?DateTime $expiryDate): void
    {
        $this->expiryDate = $expiryDate;
    }

}