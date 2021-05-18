<?php
require_once "config.php";

$sql = "DELETE FROM tests WHERE id=?";
$stm = $conn -> prepare($sql);
$id = $_GET["id"];
$stm -> bindValue(1, $id);
$stm ->execute();
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>