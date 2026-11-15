<?php
    require_once __DIR__ . '/app/main.php';
    $pdo = require __DIR__ . '/../code/connect.php';

    use db_sys\migration;


    return new class($pdo) {
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function up() {
            $migrate = new migration($this->pdo, "placeholder");
            $migrate->init_table();

        }

        public function down() {
            $migrate = new migration($this->pdo, "placeholder");
            $migrate->drop();
        }
    };