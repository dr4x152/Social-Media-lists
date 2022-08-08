<?php
$servername = "";
$username = "i";
$password = "T";
$db_name = "";

try {
    $db = new PDO('mysql:host='.$servername.';dbname='.$db_name, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}