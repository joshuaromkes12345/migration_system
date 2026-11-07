# migration_system
Migration system in php voor SQLITE

in de database folder moet je een SQLITE database maken genaamd ```database``` (of je veranderd de naam van de database in connect.php)

# structuur van systeem

### migration.php

migration.php is een placeholder voor een echte migration. De structuur is bijna precies hetzelfde als dat van de Laravel migration systeem.

### main.php

main.php houdt alle functies van het systeem zoals drop, init_table, table_content.

### connect.php

connect.php maakt een connectie met de database


# wat het (nog) niet doet

* alles netjes met 1 command migreren
* zonder de migration.php aan te passen een rollback doen
