<?php
session_start();
$action = $_POST["action"];

if ($action == "createTest") {
    createTest();
} elseif ($action == "changeTestState") {
    echo changeTestState($_POST["id"]);
} elseif ($action == "addQuestion") {
    echo addQuestionController();
} elseif ($action == "sendTest") {
    sendTest();
}


function createTest()
{

    require('config.php');

    $stmt = $conn->prepare("INSERT INTO tests(name,length,code,instructor_id) values(:name,:length,:code,:instructor_id)");

//    $timestamp = time();
//    $dt = new DateTime("now", new DateTimeZone($ip["timezone"]));
//    $dt->setTimestamp($timestamp);
//    $timestamp = $dt->format("Y-m-d");


    $stmt->bindParam(":name", $_POST["testName"]);
    $stmt->bindParam(":code", $_POST["code"]);
    $stmt->bindParam(":length", $_POST["length"]);
    $stmt->bindParam(":instructor_id", $_SESSION["instructorId"]);
    try {
        $stmt->execute();
        $latest_id = $conn->lastInsertId();
        echo $latest_id;
    } catch (Exception $e) {
        var_dump($e);
    }

    header("location: questiontotest.php?id=".$latest_id);

}

function sendTest()
{
    require 'config.php';

    $test = $_SESSION["test"];
    $user_id = $_SESSION["userId"];
    $test_id = $test[0];

    $a = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
    $a->bindParam(":test_id", $test_id);
    $a->execute();
    $d = $a->fetchAll();

    $stmt = $conn->prepare("INSERT INTO test_complete(student_id, test_id, question_id, question, answer, type) values(:student_id, :test_id, :question_id, :question, :answer, :type)");

    $j = 0;
    $x = 0;
    $arrayPost = array();

    foreach ($_POST as $row) {
        array_push($arrayPost, $row);
    }

    for ($i = 0; $i < count($arrayPost); $i++) {
        $q = $d[$j]['question'];
        $answer = $arrayPost[$i];


        //
        if ($d[$j]['type'] == 'multiple') {
            $option = isset($_POST['taskOption']) ? $_POST['taskOption'] : false;
            if ($option) {
                echo htmlentities($_POST['taskOption'], ENT_QUOTES, "UTF-8");
                $answer = htmlentities($_POST['taskOption'], ENT_QUOTES, "UTF-8");
            } else {
                echo "task option is required";
                exit;
            }
        }

        if ($d[$j]['type'] == 'connection') {
            if ($x == 0) {
                $q = 'answer1';
            } elseif ($x == 1) {
                $q = 'answer2';
            } else {
                $q = 'answer3';
            }
        }
        echo $q . "   " . $arrayPost[$i] . "<br>";
        if ($arrayPost[$i] != 'sendTest') {
            $stmt->bindParam(":student_id", $user_id);
            $stmt->bindParam(":test_id", $test_id);
            $stmt->bindParam(":question_id", $d[$j][0]);
            $stmt->bindParam(":question", $q);
            $stmt->bindParam(":answer", $answer);
            $stmt->bindParam(":type", $d[$j][5]);
            try {
                $stmt->execute();
            } catch (Exception $e) {
                var_dump($e);
            }

            if ($d[$j]['type'] == 'connection') {
                $j--;
                $x++;
                if ($x >= 3) {
                    $j++;
                    $x = 0;
                }
            }
        }
        $j++;
    }
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
    return '';

}

function changeTestState($id)
{

    require('config.php');

    $stmt = $conn->prepare("SELECT active from tests where id = :id");


    $stmt->bindParam(":id", $id);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        var_dump($e);
    }

    $state = $stmt->fetchAll();
    $state = ($state[0]["active"] == 0) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE tests SET active = :active where id = :id");

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":active", $state);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        var_dump($e);
    }
    return json_encode($state);
}

function addQuestionController()
{
    require('config.php');
    if ($_POST["type"] == "short") {
        addQuestion();
    } elseif ($_POST["type"] == "multiple") {
        $questionId = addQuestion();
        $sql = "INSERT INTO options(question_id,option1,option2, option3) VALUES (:question_id,:option1,:option2, :option3)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":question_id", $questionId);
        $stmt->bindParam(":option1", $_POST["option1"]);
        $stmt->bindParam(":option2", $_POST["option2"]);
        $stmt->bindParam(":option3", $_POST["option3"]);
        try {
            return $stmt->execute();
        } catch (Exception $e) {
            return $e;
        }
    } elseif ($_POST["type"] == "connection") {
        $questionId = addQuestionConn();
        $sql = "INSERT INTO options(question_id,option1,option2, option3) VALUES (:question_id,:option1,:option2, :option3)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":question_id", $questionId);
        $stmt->bindParam(":option1", $_POST["conn1"]);
        $stmt->bindParam(":option2", $_POST["conn2"]);
        $stmt->bindParam(":option3", $_POST["conn3"]);

        $stmt->execute();


        $statement = $conn->prepare("SELECT id FROM options WHERE question_id = :question_id");
        $statement->execute(array(':question_id' => $questionId));
        $row = $statement->fetch();


        $sql = "INSERT INTO answers(question_id,option_id,answer1,answer2, answer3,answer_false1,answer_false2) VALUES (:question_id,:option_id,:answer1,:answer2, :answer3,:answer_false1,:answer_false2)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":question_id", $questionId);
        $stmt->bindParam(":option_id", $row["id"]);
        $stmt->bindParam(":answer1", $_POST["conn1True"]);
        $stmt->bindParam(":answer2", $_POST["conn2True"]);
        $stmt->bindParam(":answer3", $_POST["conn3True"]);
        $stmt->bindParam(":answer_false1", $_POST["connFalse"]);
        $stmt->bindParam(":answer_false2", $_POST["connFalse2"]);
        $stmt->execute();
//        try {
//            return $stmt->execute();
//        } catch (Exception $e) {
//            return $e;
//        }

    } elseif ($_POST["type"] == "image") {
        addQuestion();

    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);


//
//    $stmt = $conn->prepare("SELECT active from tests where id = :id");
//
//    $stmt->bindParam(":id", $id);
//    try {
//        $stmt->execute();
//    } catch (Exception $e) {
//        var_dump($e);
//    }
//
//    $state = $stmt->fetchAll();
//    $state = ($state[0]["active"] == 0) ? 1 : 0;
//
//    $stmt = $conn->prepare("UPDATE tests SET active = :active where id = :id");
//
//    $stmt->bindParam(":id", $id);
//    $stmt->bindParam(":active", $state);
//    try {
//        $stmt->execute();
//    } catch (Exception $e) {
//        var_dump($e);
//    }
//    return json_encode($state);
}


function addQuestion()
{
    require('config.php');

    $sql = "INSERT INTO questions (test_id,question,answer,points, type) VALUES (:test_id,:question,:answer,:points, :type)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":test_id", $_POST["testId"]);
    $stmt->bindParam(":question", $_POST["question"]);
    $stmt->bindParam(":answer", $_POST["answer"]);
    $stmt->bindParam(":points", $_POST["points"]);
    $stmt->bindParam(":type", $_POST["type"]);
    try {
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        return $e;
    }
}

function addQuestionConn()
{
    require('config.php');

    $tmp = "-";
    $sql = "INSERT INTO questions (test_id,question,answer,points, type) VALUES (:test_id,:question,:answer,:points, :type)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":test_id", $_POST["testId"]);
    $stmt->bindParam(":question", $tmp);
    $stmt->bindParam(":answer", $tmp);
    $stmt->bindParam(":points", $_POST["points"]);
    $stmt->bindParam(":type", $_POST["type"]);
    try {
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (Exception $e) {
        return $e;
    }


}