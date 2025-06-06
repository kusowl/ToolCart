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

    /*
     * @return Category|Array $categories
     * */
    public function getAllCategory(int $limit = QUERY_LIMIT, int $offset = 0): array
    {
        $sql = "SELECT `id`, `category_title`, `category_desc` FROM `categories` LIMIT {$limit} OFFSET {$offset}";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $category = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $category [] = new Category($row);
        }
        return $category;
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