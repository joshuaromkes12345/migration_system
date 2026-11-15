<?php

class db_interaction {

    private PDO $pdo;
    private string $table = '';
    private array $cols = ['*'];
    private array $conditions = [];
    private array $connector = [];
    private array $order = [];
    private ?int $limit = null;


    public function __construct()
    {
        $this->pdo = require __DIR__ . '/../../code/connect.php';
    }

    public function table(string $name): self
    {
        $this->table = $name;

        return $this;
    }

    public function select(array $values): self
    {
        $this->cols = $values;

        return $this;
    }

    public function where(string $column, string $operator, mixed $value): self
    {
        $this->conditions[] = "$column $operator ?";
        $this->connector[] = $value;

        return $this;
    }

    public function order_by(string $column, string $dir = 'ASC'): self
    {
        $dir = strtoupper($dir);

        if (!in_array($dir, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Invalid order direction');
        }

        $this->order[] = "$column $dir";

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function get(): array
    {
        $columns = implode(', ', $this->cols);

        $query = "SELECT $columns FROM {$this->table}";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(' AND ', $this->conditions);
        }

        if (!empty($this->order)) {
            $query .= " ORDER BY " . implode(', ', $this->order);
        }

        if ($this->limit !== null) {
            $query .= " LIMIT {$this->limit}";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->connector);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_into(string $table, array $cols, array $vals)
    {
        $columns = implode(', ', $cols);

        $values = implode(', ', array_fill(0, count($vals), '?'));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vals);

        return $stmt;
    }

}


