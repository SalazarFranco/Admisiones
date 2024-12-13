<?php
$host = '18.205.82.38';     
$db   = 'db_dental_des';     
$user = 'cgs_des';            
$pass = 'cgs_des';         
$port = '5432';               

$dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

try {
    $pdo = new PDO($dsn);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit;
}
?>
