<?php
session_start();


if (!isset($_SESSION['instructorId'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if(isset($_POST['sq']) && isset($_POST['sa']) ){
    require('config.php');
    $sql ="INSERT INTO short_question (test_id,question,answer,points) VALUES (?,?,?,?)";
    $stmt = $conn ->prepare($sql);
    $stmt->execute([$_GET['id'],$_POST['sq'],$_POST['sa'],$_POST['points']]);
        echo $_POST['sq'];
        echo $_POST['sa'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pridanie otazky do testu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
<h1 style="text-align: center">TU SI VYBER AKE OTAZKY CHCES ZADAT </h1>
<form method="post" action="questiontotest.php?id=<?php echo $_GET['id']?>">
    <div class="input-group">
        <label for="sq" class="form-control">Zadaj otazku</label> <!--        short question-->
        <input class="form-control" type="text" name="sq" id="sq">
        <label for="sa" class="form-control">Zadaj odpoved</label> <!--        short answer-->
        <input class="form-control" type="text" name="sa" id="sa">
        <label for="points" class="form-control">Pocet bodov</label> <!--        short answer-->
        <input class="form-control" type="number" name="points" id="points">
        <button type="submit" ></button>
    </div>
    <div class="input-group">
        <label for="mq" class="form-control">Zadaj otazku</label> <!--        multiple question-->
        <input class="form-control" type="text" name="mq" id="mq">
        <label for="mqb" class="form-control">Zadaj zle odpovede</label> <!--  multiple question bad-->
        <input class="form-control" type="text" name="mqb" id="mqb">
        <label for="mqt" class="form-control">Zadaj spravne odpovede</label> <!--multiple question true-->
        <input class="form-control" type="text" name="mqt" id="mqt">
    </div>


</form>

</body>
</html>
