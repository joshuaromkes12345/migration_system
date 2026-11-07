<?php

namespace db_sys;

use PDO;
$pdo = require_once __DIR__ . '/database/code/connect.php';

class migration
{  
    private string $table_name;
    private PDO $pdo;

    function __construct(PDO $pdo, string $table_name)
    {
        $this->pdo = $pdo;
        $this->table_name = $table_name;
    }

    // maakt table
    public function init_table()
    {
        $query = "CREATE TABLE IF NOT EXISTS \"{$this->table_name}\" (
            id INTEGER PRIMARY KEY
        )";

        $this->pdo->exec($query);
    }
    // voegt content toe
    public function table_content(string $column_name, string $column_type, bool $nullable = false)
    {
        $query = "
            ALTER TABLE {$this->table_name}
            ADD {$column_name} {$column_type}" . ($nullable ? " NULL" : " NOT NULL");

        $this->pdo->query($query);
    }

    // dropt table
    public function drop() {
        $query = "DROP TABLE IF EXISTS \"{$this->table_name}\";";

        $this->pdo->exec($query);
    }
}

