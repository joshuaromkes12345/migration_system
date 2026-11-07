<?php

require_once 'main.php';
$pdo = require __DIR__ . '/database/code/connect.php';

use db_sys\migration;

class migrate {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function up() {
        $migrate = new migration($this->pdo, "test");

        $migrate->init_table();

        $migrate->table_content("naam", "varchar(255)");

    }

    public function down() {
        $migrate = new migration($this->pdo, "test");

        $migrate->drop();
    }
}



// de echte migration

$migrate1 = new migrate($pdo);
//up of down
$migrate1->up();