<?php
session_start();

require 'config.php';
$entry = $_POST['matchvalue'];
$entry2 = $_POST['matchid'];
echo $entry;
echo $entry2;
var_dump($_SESSION);
$upd = $conn->prepare("UPDATE test_complete SET point = :point WHERE test_id = :test_id and student_id = :student_id and question_id= :question_id");
$upd->bindParam(":point", $entry);
$upd->bindParam(":test_id", $_SESSION['test_id']);
$upd->bindParam(":student_id", $_SESSION['student_id'] );
$upd->bindParam(":question_id", $entry2);
try {
    $upd->execute();
} catch (Exception $e) {
    var_dump($e);
}

?>