<?php
$dbServername = "localhost";
$dbUsername = "xspakk";
$dbPassword = '123';
$database = "skuska3";


$conn = new PDO("mysql:host=$dbServername;dbname=$database", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);