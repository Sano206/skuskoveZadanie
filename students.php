<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Archivo:500|Open+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <title>Students</title>
</head>
<body>

<div id="navbutton">
    <a class="btn btn-outline-success btn-lg" href="index.php"><i class="fas fa-arrow-left"></i>Back</a>
</div>

<div class="container w-50 shadow-lg" id="content">
<h1>Students who completed this test</h1>
<div class="row">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Student name</th>
            </tr>
            </thead>

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

    echo '<tr>';
    echo '<td><a href="students_completed_tests.php?student_id='. $students_id[$i].'&amp;test_id=' . $id . '  ">'. $d['name'] . " " . $d['surname'] ."</a><br></td>";
    echo '</tr>';
}
?>

        </table>
    </div>
</div>


</div>
</body>
</html>