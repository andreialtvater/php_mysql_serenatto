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

    public function coffeeOptions(): array
    {
        $sql = "SELECT * FROM produtos WHERE type = 'Café' ORDER BY price";
        $statement = $this->db->query($sql);
        $coffeeProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'formObjects'], $coffeeProducts);
    }

    public function lunchOptions(): array
    {
        $sql = "SELECT * FROM produtos WHERE type = 'Almoço' ORDER BY price";
        $statement = $this->db->query($sql);
        $lunchProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'formObjects'], $lunchProducts);
    }
}
