<?php
$host = 'srv1014.hstgr.io';
$dbname = 'u561197304_Nikki';
$username = 'u561197304_AldoAdmin';
$password = 'i.e53ZE,';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>