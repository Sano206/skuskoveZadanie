<?php
session_start();
require_once "config.php";
$test = $_SESSION["test"];
$test_id = $test[0];
$statement = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
$statement->execute(array(':test_id' => $test_id));
$rows = $statement->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
<h1 style="text-align: center">TESTERINO</h1>

<?php echo "<h3 style='text-align: center'>" . $_SESSION["username"] . " vitaj na teste prajeme ti vela stasti:) </h3>" ?>

<form class="container" method="post">
    <?php
    $x = "q";
    $i = 0;
    foreach ($rows as $row) {

        if ($row["type"] == "short") {
            echo "<div class='form-control'>";
            echo "<p>" . $row["question"] . "</p>";

            echo "<input type='text' name='$x$i' id='$x$i'> ";
            echo "<p style='float: right'>" . $row["points"] . "b" . "</p>";
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
            echo "</div>";


        } elseif ($row["type"] == "connection") {

        } elseif ($row["type"] == "math") {

        } elseif ($row["type"] == "image") {
            echo "<div class='form-control'>";
            echo "<p>" . $row["question"] . "</p>";

            echo '<button class="" id="imgur">send</button>';
            echo '<canvas id="draw" width="500" height="500" style="border: 1px solid black"></canvas>';

            echo '<input type="hidden" value="" id="link">';

            echo "<p style='float: right'>" . $row["points"] . "b</p>";
            echo "</div>";
        }
        $i++;
    }

    ?>

    <div class="form-control" style="margin-top: 50px">
        <input type="submit" class="btn-primary" value="Chuju posielaj">
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="draw.js"></script>

</body>
</html>