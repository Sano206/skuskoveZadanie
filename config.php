<?php
$dbServername = "localhost";
$dbUsername = "xgossanyi";
$dbPassword = 'I#$H5uPW2kVIJY';
$database = "skuska";


$conn = new PDO("mysql:host=$dbServername;dbname=$database", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

