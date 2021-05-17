<?php
session_start();
date_default_timezone_set('Europe/Bratislava');

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="canvas.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <link rel="stylesheet" href="connections/css/jsplumbtoolkit-defaults.css">
    <link rel="stylesheet" href="connections/css/main.css">
    <link rel="stylesheet" href="connections/css/jsplumbtoolkit-demo.css">
    <link rel="stylesheet" href="connections/demo.css">
</head>
<body>


<div class="container">
    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="index.php?logout='1'" style="color: red;">logout</a></p>
    <?php endif ?>

    <?php

    require_once "config.php";
    $test = $_SESSION["test"];
    $test_id = $test[0];
    $sql_time = $conn->prepare("SELECT * FROM tests_taken WHERE test_id = :test_id and student_id = :student_id");
    $sql_time->execute(array(':test_id' => $test_id, ':student_id' => $_SESSION["userId"]));
    $times = $sql_time->fetch();

    if (!isset($times['end_timestamp'])) {
        echo "<br>";
        $tmp_time = (int)$test[2];
        $time = strtotime($times['start_timestamp']) + $tmp_time * 60;
        $end_time = date("H:i:s Y-m-d ", $time);
        $stmt = $conn->prepare("UPDATE tests_taken SET end_timestamp=:end_timestamp WHERE test_id = :test_id and student_id = :student_id");
        $stmt->bindParam(":end_timestamp", $end_time);
        $stmt->bindParam(":test_id", $test_id);
        $stmt->bindParam(":student_id", $_SESSION["userId"]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            var_dump($e);
        }
        $sql_time = $conn->prepare("SELECT * FROM tests_taken WHERE test_id = :test_id and student_id = :student_id");
        $sql_time->execute(array(':test_id' => $test_id, ':student_id' => $_SESSION["userId"]));
        $times = $sql_time->fetch();
    }
    if (isset($times['end_timestamp'])) {
        $sql_time = $conn->prepare("SELECT * FROM tests_taken WHERE test_id = :test_id and student_id = :student_id");
        $sql_time->execute(array(':test_id' => $test_id, ':student_id' => $_SESSION["userId"]));
        $times = $sql_time->fetch();
    }
    $statement = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
    $statement->execute(array(':test_id' => $test_id));
    $rows = $statement->fetchAll();
    $countOfPoints = 0;


    ?>

    <h1 style="text-align: center">TESTERINO</h1>
    <h2 style="text-align: center" id="demo"></h2>

    <?php echo "<h3 style='text-align: center'>" . $_SESSION["username"] . " Welcome to your test! </h3>" ?>

    <form class="container" action="testController.php" method="post">
        <?php
        $x = "q";
        $i = 0;
        foreach ($rows as $row) {

            if ($row["type"] == "short") {
                echo "<div class='form-control'>";
                echo "<p>" . $row["question"] . "</p>";

                echo "<input type='text' name='$x$i' id='$x$i'> ";
                echo "<p style='float: right'>" . $row["points"] . "b" . "</p>";
                $countOfPoints = $countOfPoints + $row["points"];
                echo "</div>";
            } elseif ($row["type"] == "multiple") {
                $statement = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
                $statement->execute(array(':question_id' => $row["id"]));
                $columns = $statement->fetch();
                echo "<div class='form-control'>";
                echo "<p>" . $row["question"] . "</p>";
                echo "<select name = 'taskOption'>";
                echo "<option value=" . $row['answer'] . ">" . $row['answer'] . "</option>";
                echo "<option value=" . $columns['option1'] . ">" . $columns['option1'] . "</option>";
                echo "<option value=" . $columns['option2'] . ">" . $columns['option2'] . "</option>";
                echo "<option value=" . $columns['option3'] . ">" . $columns['option3'] . "</option>";
                echo "</select>";
                echo "<p style='float: right'>" . $row["points"] . "b" . "</p>";
                $countOfPoints = $countOfPoints + $row["points"];
                echo "</div>";
            } elseif ($row["type"] == "connection") {
                $statement = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
                $statement->execute(array(':question_id' => $row["id"]));
                $options = $statement->fetch();
                $statement = $conn->prepare("SELECT * FROM answers WHERE question_id = :question_id");
                $statement->execute(array(':question_id' => $row["id"]));
                $answers = $statement->fetch();
                $falseAnswerCheck = 1;
                echo '<div class="jtk-demo-main" data-demo-id="draggableConnectors">';
                echo ' <div class="jtk-demo-canvas canvas-wide drag-drop-demo jtk-surface jtk-surface-nopan" id="canvas">';
                if (isset($answers["answer_false1"])) {
                    echo '<div class="window" id="dragDropWindow7"> ' . $answers["answer_false1"] . '</div>';
                }
                if (isset($answers["answer_false2"])) {
                    echo '<div class="window" id="dragDropWindow8"> ' . $answers["answer_false2"] . '</div>';
                }
                for ($i = 1; $i < 4; $i++) {
                    echo '
                        <div class="window" id="dragDropWindow' . $i . '"> ' . $options["option$i"] . '</div>
                        <div class="window" id="dragDropWindow' . ($i + 3) . '"> ' . $answers["answer$i"] . '</div>
                        ';
                }

                echo '<div hidden id="list"></div>';
                echo "<p style='float: right'>" . $row["points"] . "b" . "</p>";
                echo '</div>';
                echo '</div>';


                echo '<input hidden class="form-control" type="text" name="answer1" id="answer1">';
                echo '<input hidden class="form-control" type="text" name="answer2" id="answer2">';
                echo '<input hidden class="form-control" type="text" name="answer3" id="answer3">';

                $countOfPoints = $countOfPoints + $row["points"];

            } elseif ($row["type"] == "math") {

            } elseif ($row["type"] == "image") {

                echo "<div class='form-control'>";
                echo "<p>" . $row["question"] . "</p>";

                echo "<button type='button' class='' id='imgur' value='$i' onClick='reply(this.value)'>send</button>";
                echo "<canvas id='draw$i' width='500' height='500' style='border: 1px solid black' onClick='reply_click(this.id)'></canvas>";

                echo "<input type='hidden' value='' id='link$i' name='link$i'>";

                echo "<p style='float: right'>" . $row["points"] . "b</p>";
                echo "</div>";
                $countOfPoints = $countOfPoints + $row["points"];
            }
            $i++;
        }
        ?>

        <div class="form-control">
            <p>Max. points <?php echo $countOfPoints ?></p>
            <button type="submit" class="btn-primary" name="action" value="sendTest" id="sender">Send</button>
        </div>

    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

<!-- JS -->
<script src="connections/dist/js/jsplumb.js"></script>
<!-- /JS -->

<!--  demo code -->
<script src="connections/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

<!-- JS -->
<script src="connections/dist/js/jsplumb.js"></script>
<!-- /JS -->

<!--  demo code -->
<script src="connections/demo.js"></script>

<script src="connections/demo-list.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="draw.js"></script>
<script src="connections/demo-list.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="draw.js"></script>


<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo($times['end_timestamp'])?>");

    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        if (distance < 180312) {
            document.getElementById("demo").style.color = "red";
        }
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {

            //  window.location.href = "index.php";
            clearInterval(x);

            document.getElementById("demo").innerHTML = "EXPIRED";
            window.alert("Your time has expired by clicking OK you will be redirect to login page");
            document.getElementById("sender").click(); // Click on the checkbox



        }
    }, 1000);
</script>
</body>
</html>