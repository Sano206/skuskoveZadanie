<?php
$dbServername = "localhost:3306";
$dbUsername = "xgajdosa1";
$dbPassword = 'An#$sjkA5oAP4x';
$database = "skuska";


$conn = new PDO("mysql:host=$dbServername;dbname=$database", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

