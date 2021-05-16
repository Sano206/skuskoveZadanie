<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Completed tests</title>
</head>
<body>

<?php
require 'config.php';

$a = $conn->prepare ("SELECT * FROM tests WHERE id = :test_id");
$a->bindParam(":test_id", $_GET['test_id']);
$a->execute();
$d = $a->fetch();

echo "<h1>" . $d['name'] . "</h1>";


$a = $conn->prepare ("SELECT * FROM test_complete WHERE test_id = :test_id and student_id = :student_id");
$a->bindParam(":test_id", $_GET['test_id']);
$a->bindParam(":student_id", $_GET['student_id']);
$a->execute();
$d = $a->fetchAll();

$b = $conn->prepare ("SELECT * FROM questions WHERE test_id = :test_id and id = :question_id");

$e = $conn->prepare ("SELECT * FROM answers WHERE question_id = :question_id");


?>

<table style="text-align: center">
    <thead>
    <tr>
        <th>question</th>
        <th>answer</th>
        <th>type</th>
        <th>Max points</th>
        <th>points earned</th>
    </tr>
    </thead>
    <tbody>

<?php
$i=0;
$points = 0;

foreach ($d as $row)
{
    $b->bindParam(":test_id", $_GET['test_id']);
    $b->bindParam(":question_id", $row['question_id']);
    $b->execute();
    $c = $b->fetch();

    echo "<tr>";

    echo "<td>" . $row['question'] . "</td>";
    echo "<td>" . $row['answer'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $c['points'] . "</td>";

    if($row['type'] != 'connection')
    {
        if($c['answer'] == $row['answer'])
        {
            $points = $points + $c['points'];
            echo "<td>" . $c['points'] . "</td>";
        }else{
            echo "<td>0</td>";
        }
    }else{
        $e->bindParam(":question_id", $row['question_id']);
        $e->execute();
        $r = $e->fetch();

        if($row['question'] == 'answer1')
        {
            if($r['answer1'] == $row['answer'])
            {
                $points = $points + $c['points'];
                echo "<td>" . $c['points'] . "</td>";
            }else{
                echo "<td>0</td>";
            }
        }elseif ($row['question'] == 'answer2')
        {
            if($r['answer2'] == $row['answer'])
            {
                $points = $points + $c['points'];
                echo "<td>" . $c['points'] . "</td>";
            }else{
                echo "<td>0</td>";
            }
        }else{
            if($r['answer3'] == $row['answer'])
            {
                $points = $points + $c['points'];
                echo "<td>" . $c['points'] . "</td>";
            }else{
                echo "<td>0</td>";
            }
        }
    }

    echo "</tr>";
    $i++;
}
$s = $conn->prepare ("SELECT * FROM students WHERE id = :student_id");
$s->bindParam(":student_id", $_GET['student_id']);
$s->execute();
$studentName = $s->fetch();

echo $studentName['name'] . " " . $studentName['surname'] . " got: " . $points . "points.";

?>
    </tbody>
</table>
</body>
</html>