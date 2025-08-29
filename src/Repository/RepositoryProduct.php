<?php

class RepositoryProduct
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
    }

    private function formObjects(array $data): Product
    {
        return new Product(
            $data['id'],
            $data['type'],
            $data['name'],
            $data['description'],
            $data['image'],
            $data['price']
        );
    }

    private function findByType(string $type): array
    {
        $sql = "SELECT * FROM produtos WHERE type = :type ORDER BY price";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':type', $type);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'formObjects'], $rows);
    }

    public function coffeeOptions(): array
    {
        return $this->findByType('Café');
    }

    public function lunchOptions(): array
    {
        return $this->findByType('Almoço');
    }

    private function selectAllProducts(): array
    {
        $sql = "SELECT * FROM produtos ORDER BY price";
        $statement = $this->db->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'formObjects'], $rows);
    }

    public function getAllProducts(): array
    {
        return $this->selectAllProducts();
    }
}