<?php
try {
    $pdo = new PDO('mysql:host=mysqldb;dbname=colyseum', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (Exception $e) {
    die('Error :' . $e->getMessage());
}
