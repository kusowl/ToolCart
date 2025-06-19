<?php
include_once 'Model.php';

class Category extends Model
{
    private $id;
    private string $title;
    private string $description;


    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['category_title'] ?? '';
        $this->description = $data['category_desc'] ?? '';
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Category|Array $categories
     */
    public function getAllCategory(int $limit = QUERY_LIMIT, int $offset = 0): Category|array
    {
        $sql = "SELECT `id`, `category_title`, `category_desc` FROM `categories` LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute();
        $category = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category [] = new Category($row);
        }
        return $category;
    }

    /**
     * @param $categoryId
     * @param int $limit
     * @param int $offset
     * @return Category|Array $categories
     */
    public function getCategoryById($categoryId, int $limit = QUERY_LIMIT, int $offset = 0): Category|array
    {
        $sql = "SELECT `category_title`, `category_desc` FROM `categories` WHERE `id` = :id LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::getDb()->prepare($sql);
        $stmt->execute([
            ':id' => $categoryId
        ]);
        $category = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category [] = new Category($row);
        }
        return $category;
    }


    /**
     * @param string $categoryName
     * @param string $categoryDescription
     * @return bool
     */
    public function addCategory(string $categoryName, string $categoryDescription): bool
    {
        $sql = "SELECT `category_title` from `categories` where category_title = :category_name";
        try {
            $stmt = self::getDb()->prepare($sql);
            $stmt->execute([
                'category_name' => $categoryName
            ]);
        } catch (Exception) {
        };
        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO `categories` (`category_title`, `category_desc`) VALUES (:category_name, :category_desc)";
            $result = false;
            try {
                $stmt = self::getDb()->prepare($sql);
                $result = $stmt->execute([
                    ':category_name' => $categoryName,
                    ':category_desc' => $categoryDescription
                ]);
            } catch (Exception) {
            }
            return $result;
        }else{
            return false;
        }
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}