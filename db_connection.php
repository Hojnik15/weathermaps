<?php

$host = 'localhost';
$db   = 'zanlukah_cities';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;password=$pass";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
         echo 'ERROR!';
        print_r( $e );
}

?>