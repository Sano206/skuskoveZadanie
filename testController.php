<?php
session_start();

$action = $_POST["action"];

if($action == "createTest"){
    createTest();
}elseif($action == "changeTestState"){
    echo changeTestState($_POST["id"]);
}



function createTest(){

        require ('config.php');

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
        }catch (Exception $e){
            var_dump($e);
        }

    header("location: index.php");

}
function changeTestState($id){

        require ('config.php');

        $stmt = $conn->prepare("SELECT active from tests where id = :id");

        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
        }catch (Exception $e){
            var_dump($e);
        }

        $state = $stmt ->fetchAll();
        $state = ($state[0]["active"] == 0)? 1: 0;

    $stmt = $conn->prepare("UPDATE tests SET active = :active where id = :id");

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":active", $state);
    try {
        $stmt->execute();
    }catch (Exception $e){
        var_dump($e);
    }
    return json_encode($state);
}
