<?php
$host = $username = $password = $dbname = '';
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
if (isset($url["host"]) && isset($url["user"]) && isset($url["pass"]) && isset($url["path"])) {
    $host = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);
}

return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=' . $host . ';dbname=' . $dbname,
    //'dsn' => 'mysql:host=localhost;dbname=inventory_db', // MySQL, MariaDB
    //'dsn' => 'sqlite:/path/to/database/file', // SQLite
    'dsn' => 'pgsql:host=' . $host . ';port=5432;dbname=' . $dbname, // PostgreSQL
   //'dsn' => 'cubrid:dbname=demodb;host=localhost;port=33000', // CUBRID
   //'dsn' => 'sqlsrv:Server=localhost;Database=mydatabase', // MS SQL Server, sqlsrv driver
   //'dsn' => 'dblib:host=localhost;dbname=mydatabase', // MS SQL Server, dblib driver
   //'dsn' => 'mssql:host=localhost;dbname=mydatabase', // MS SQL Server, mssql driver
   //'dsn' => 'oci:dbname=//localhost:1521/mydatabase', // Oracle
    
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];
