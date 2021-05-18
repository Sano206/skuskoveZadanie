<?php
    require 'config.php';

    $allData = "";
    $sql = $conn->prepare("SELECT * FROM students WHERE id = :student_id");

    $str = $conn->prepare("SELECT * FROM test_complete WHERE test_id = :test_id");
    $str->bindParam(":test_id", $_GET['id']);
    $str->execute();
    $points = $str->fetchAll();

$bodiky = $conn->prepare("SELECT * FROM test_complete WHERE test_id = :test_id and student_id = :student_id");
$bodiky->bindParam(":test_id", $_GET['id']);


    $students = array();

    foreach ($points as $row){
        if (!in_array($row['student_id'], $students))
        {
            array_push($students, $row['student_id']);
        }
    }

    for($i=0; $i<count($students); $i++)
    {
        $allPoints = 0;
        $sql->bindParam(":student_id", $students[$i]);
        $sql->execute();
        $students_info = $sql->fetch();

        $bodiky->bindParam(":student_id", $students[$i]);
        $bodiky->execute();
        $bodiky2 = $bodiky->fetchAll();

        foreach ($bodiky2 as $rows)
        {
            $allPoints = $allPoints + $rows['point'];
        }

        $allData .= $students[$i] . ',' . $students_info['name'] . ',' . $students_info['surname'] . ',' . $allPoints . "\n";
    }


    $response = "data:text/csv;charset=utf-8,ID,NAME,SURNAME, POINTS\n";
    $response .= $allData;

    echo '<a href= "'.$response.'" download="countryTable.csv">Download</a>';