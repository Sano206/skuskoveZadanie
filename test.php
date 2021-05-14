<?php
session_start();

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
    $statement = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
    $statement->execute(array(':test_id' => $test_id));
    $rows = $statement->fetchAll();
    $countOfPoints = 0;


    ?>

    <h1 style="text-align: center">TESTERINO</h1>

    <?php echo "<h3 style='text-align: center'>" . $_SESSION["username"] . " vitaj na teste prajeme ti vela stasti:) </h3>" ?>

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
                      echo "<select>";
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
                echo '</div>';
                echo '</div>';

               echo '<input hidden class="form-control" type="text" name="answer1" id="answer1">';
               echo '<input hidden class="form-control" type="text" name="answer2" id="answer2">';
               echo '<input hidden class="form-control" type="text" name="answer3" id="answer3">';

            } elseif ($row["type"] == "math") {

            } elseif ($row["type"] == "image") {

               echo "<div class='form-control'>";
               echo "<p>" . $row["question"] . "</p>";

               echo "<button type='button' class='' id='imgur' value='$i' onClick='reply(this.value)'>send</button>";
               echo "<canvas id='draw$i' width='500' height='500' style='border: 1px solid black' onClick='reply_click(this.id)'></canvas>";

               echo "<input type='hidden' value='' id='link$i'>";

               echo "<p style='float: right'>" . $row["points"] . "b</p>";
               echo "</div>";


            }
            $i++;
        }

        ?>

        <div class="form-control">
          <p >Maximalny pocet bodov je <?php echo $countOfPoints ?></p>
            <button type="submit" class="btn-primary" name="action" value="sendTest">Odosli</button>
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

<script src="connections/demo-list.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="draw.js"></script>
</body>
</html>
