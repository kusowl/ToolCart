<?php

class User
{
    private static PDO $dbCon;
    private $userId;
    private string $name;
    private string $email;
    private string $password;
    private string $type;

    public function __construct(array $data = [])
    {
        $this->userId = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->type = $data['user_type'] ?? '';
    }

    public static function setDb(PDO $pdo)
    {
        self::$dbCon = $pdo;
    }

    public static function getUser(string $email): User
    {
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        try{
            $stmt = self::$dbCon->prepare($sql);
            $stmt->execute([':email' => $email]);
        }catch (PDOException $e){}

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User($user ?: []);
    }

    public function createUser($admin = false): bool
    {
        if ($admin) {
            $sql = "INSERT INTO `user`(`name`, `email`, `password`, `user_type`) VALUES (:name, :email, :password, :user_type)";
            $stmt = self::$dbCon->prepare($sql);
            $result = $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ':user_type' => 'admin'
            ]);
        } else {
            $sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES (:name, :email, :password)";
            try {
                $stmt = self::$dbCon->prepare($sql);
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
}
