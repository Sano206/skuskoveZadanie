<?php
$dbServername = "localhost:3306";
$dbUsername = "xhrinko";
$dbPassword = 'WeWNd#$74B6vbE';
$database = "skuska";


$conn = new PDO("mysql:host=$dbServername;dbname=$database", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

