<?php
include_once 'Model.php';

class User extends Model
{
    private $userId;
    private string $name;
    private string $email;
    private string $password;
    private string $type;
    private string $image;

    public function __construct(array $data = [])
    {
        $this->userId = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->type = $data['user_type'] ?? '';
        $this->image = $data['image'] ?? '';
    }


    public static function getUser(string $email): User
    {
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([':email' => $email]);
        } catch (PDOException $e) {
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($user ?: []);
    }

    public static function getById(int $id)
    {
        $sql = "SELECT * FROM `user` WHERE `id` = :id";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($user ?: []);
    }

    public function createUser($admin = false): bool
    {
        if ($admin) {
            $sql = "INSERT INTO `user`(`name`, `email`, `password`, `user_type`) VALUES (:name, :email, :password, :user_type)";
            $stmt = self::getDb()->prepare($sql);
            $result = $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ':user_type' => 'admin'
            ]);
        } else {
            $sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES (:name, :email, :password)";
            try {
                $stmt = self::getDb()->prepare($sql);
                $result = $stmt->execute([
                    ':name' => $this->name,
                    ':email' => $this->email,
                    ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ]);
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * @return array{
     *     success: bool,
     *     user: User,
     *     error : string
     *     }
     */
    public function login($email, $password): array
    {
        // Check if the email exists in db
        $user = self::getUser($email);
        if ($user->getUserId() == null) {
            return [
                'success' => false,
                'error' => 'User Not Found'
            ];
        }

        if (password_verify($password, $user->getPassword())) {
            return [
                'success' => true,
                'user' => $user
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Password does not matched'
            ];
        }
    }

    public function update($data = []): bool
    {

        $params = [];
        $placeholders = [];
        foreach ($data as $key => $value) {
            if ($key == 'image' and $value == '') continue;
            if ($key == 'password') $value =   password_hash($value, PASSWORD_DEFAULT);
            $placeholders[] = "`{$key}`" . ' = :' . $key;
            $params[":{$key}"] = $value;
        }
        $placeholders = implode(', ', $placeholders);
        $sql = "UPDATE `user` SET {$placeholders} WHERE id = :id";
        $result = false;
        try {
            $stmt = self::getDb()->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

}
