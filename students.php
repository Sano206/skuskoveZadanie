<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students</title>
</head>
<body>

<?php
require 'config.php';

$id = $_GET['id'];

$a = $conn->prepare ("SELECT * FROM test_complete WHERE test_id = :test_id");
$a->bindParam(":test_id", $id);
$a->execute();
$d = $a->fetchAll();

$students_id = array();
foreach ($d as $row)
{
    if (!in_array($row['student_id'], $students_id))
    {
        array_push($students_id, $row['student_id']);
    }
}
for($i=0; $i<count($students_id); $i++)
{
    $a = $conn->prepare ("SELECT * FROM students WHERE id = :id");
    $a->bindParam(":id", $students_id[$i]);
    $a->execute();
    $d = $a->fetch();

    echo '<a href="students_completed_tests.php?student_id='. $students_id[$i].'&amp;test_id=' . $id . '  ">'. $d['name'] . " " . $d['surname'] ."</a><br>";

}




?>

</body>
</html>