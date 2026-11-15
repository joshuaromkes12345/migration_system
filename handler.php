<?php

$main_command = $argv[1];
$migrations = array_filter(glob(__DIR__ . "/database/migrations/*_migration.php"), 'is_file');
sort($migrations, SORT_NATURAL);

switch ($main_command) {
    case "migrate":
        foreach ($migrations as $migration) {
            $migrate = require $migration;

            $migrate->up();
        }
        break;

    case "new_migration":
        $num = count($migrations);

        $new_migration = fopen( __DIR__ . "/database/migrations/" .$num + 1 . "_migration.php", "w");

        $content = <<<'PHP'
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
                                    // $migrate = new migration($this->pdo, "placeholder");

                                }

                                public function down() {
                                    // $migrate = new migration($this->pdo, "placeholder");
                                    // $migrate->drop();
                                }
                            };
                        PHP;
        fwrite($new_migration, $content);
        fclose($new_migration);
        break;

    case "migrate:rollback": 
        foreach ($migrations as $migration) {
            $migrate = require $migration;

            $migrate->down();
        }
        break;
}