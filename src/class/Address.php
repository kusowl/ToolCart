<?php
include_once 'Model.php';

class Address extends Model
{
    private $id;
    private $userId;


    private string $name;
    private string $email;
    private int $countryCode;
    private int $phNo;
    private string $line1;
    private string $line2;
    private string $city;
    private string $country;
    private int $pin;
    private string $instructions;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['user_id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->country = $data['country'] ?? '';
        $this->countryCode = (int) ($data['country_code'] ?? 0);
        $this->phNo = (int) ($data['ph_no'] ?? 0);
        $this->pin = (int) ($data['pin'] ?? 0);
        $this->line1 = $data['line_1'] ?? '';
        $this->line2 = $data['line_2'] ?? '';
        $this->instructions = $data['instructions'] ?? '';
    }

    public function getAddress($userId, $limit = INT_CURR_SYMBOL): Address|array
    {
        $sql = "SELECT `id`, `user_id`, `name`, `email`, `country_code`, `ph_no`, `line_1`, `line_2`, `city`, `country`, `pin`, `instructions` FROM `address` WHERE `user_id` = :user_id LIMIT {$limit}";

        try {
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId
            ]);
            $address = [];
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $address[] = new Address($res);
            }
            return $address;
        } catch (Exception) {
        } finally {
            return [
                'error' => true
            ];
        }
    }

    public function addAddress()
    {
        $sql = "INSERT INTO `address` (`user_id`, `name`, `email`, `country_code`, `ph_no`, `line_1`, `line_2`, `city`, `country`, `pin`, `instructions`) VALUES (:user_id, :name, :email, :country_code, :ph_no, :line_1, :line_2, :city, :country, :pin, :instructions)";
        try {
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->getUserId(),
                ':name' => $this->getName(),
                ':email' => $this->getEmail(),
                ':country_code' => $this->getCountryCode(),
                ':ph_no' => $this->getPhNo(),
                ':line_1' => $this->getLine1(),
                ':line_2' => $this->getLine2(),
                ':city' => $this->getCity(),
                ':country' => $this->getCountry(),
                ':pin' => $this->getPin(),
                ':instructions' => $this->getInstructions()
            ]);
            $this->id = $this->getDb()->lastInsertId();
        }catch (Exception){}
    }

    public function getUserId(): mixed
    {
        return $this->userId;
    }

    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCountryCode(): int
    {
        return $this->countryCode;
    }

    public function setCountryCode(int $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getPhNo(): int
    {
        return $this->phNo;
    }

    public function setPhNo(int $phNo): void
    {
        $this->phNo = $phNo;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): void
    {
        $this->line1 = $line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): void
    {
        $this->line2 = $line2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getPin(): int
    {
        return $this->pin;
    }

    public function setPin(int $pin): void
    {
        $this->pin = $pin;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): void
    {
        $this->instructions = $instructions;
    }

}