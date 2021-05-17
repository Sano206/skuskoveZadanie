<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['instructorId'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

$statement = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
$statement->execute(array(':test_id' => $_GET['id']));
$rows = $statement->fetchAll();
$question_number = 1;
$countOfPoints = 0;

$statement2 = $conn->prepare("SELECT * FROM tests WHERE id =:test_id");
$statement2->execute(array(':test_id' => $_GET['id']));
$testname = $statement2->fetch();
$testname2 = $statement2->fetchAll();
$question_number = 1;
$countOfPoints = 0;

//var_dump($testname);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nahlad testu</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Archivo:500|Open+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>

<div id="navbutton">
    <a class="btn btn-outline-success btn-lg" href="index.php"><i class="fas fa-arrow-left"></i>Back</a>
</div>

<div class="container w-50 shadow-lg" id="content">
<h1 style="text-align: center">Details of test: <?php echo $testname['name'] ?></h1>

<p style="margin-left: 50px" class="blockquote justify-content-center">
    <?php
    foreach ($rows as $row) {
        echo "<br>";
        echo "<strong>".$question_number."</strong>. Question";
        echo '<a href="delete.php?id='. $row["id"]. '" >' . "<button style='margin-left: 10px; width: 40px;' class='btn btn-outline-danger btn-md' ><i class='far fa-trash-alt'></i></button>"."</a>" ;

        echo "<br>";
        if ($row['type'] == "short") {

            echo "<strong>Question: </strong> " . $row['question']. " - Short question";
            echo "<br>";
            echo "<strong>Correct answer: </strong> " . $row['answer'];


        } else if ($row['type'] == "multiple") {
            echo "<strong>Question: </strong> " . $row['question']. " - Multiple answers question";
            echo "<br>";
            echo "<strong>Correct answer: </strong> " . $row['answer'];
            echo "<br>";
            $sql = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
            $sql->execute(array(':question_id' => $row['id']));
            $tmps = $sql->fetch();
            echo "<strong>Wrong answers: </strong> " . $tmps['option1'] . ", " . $tmps['option2'] . ", " . $tmps['option3'];


        } else if ($row['type'] == "connection") {
            $sql = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
            $sql->execute(array(':question_id' => $row['id']));
            $tmps = $sql->fetch();
            $sql2 = $conn->prepare("SELECT * FROM answers WHERE option_id = :option_id");
            $sql2->execute(array(':option_id' => $tmps['id']));
            $tmps2 = $sql2->fetch();
            echo "<strong>Question: </strong> Combination question";
            echo "<br>";
            echo "<strong>Correct ombination: </strong> " . $tmps['option1'] . " -> " . $tmps2['answer1'];
            echo "<br>";
            echo "<strong>Correct ombination: </strong>" . $tmps['option2'] . " -> " . $tmps2['answer2'];
            echo "<br>";
            echo "<strong>Correct ombination: </strong> " . $tmps['option3'] . " -> " . $tmps2['answer3'];
            echo "<br>";
            echo "<strong>Possible wrong answers: </strong>" . $tmps2['answer_false1'] . " a " . $tmps2['answer_false2'];


        } else if ($row['type'] == "image") {
            echo "<strong>Question: </strong>" . $row['question']. " - Drawing question";
            echo "<br>";
            echo "<strong>Correct answer: </strong> teacher check needed";


        }

        echo "<br>";
        echo "<strong>Max. points: </strong>".$row['points']."p";
        $countOfPoints +=$row['points'];

        echo "<br>";
        $question_number++;

    }
    echo "<br>";
    echo "<strong>Total points for test: </strong>" . $countOfPoints."p";
    echo "<br>";
    ?>
    <div style="padding-left: 25px; padding-top: 25px">
    <?php
    echo '<a style="margin-right: 10px" href="questiontotest.php?id='. $_GET['id'] . '" >' . "<button class='btn btn-success btn-md' ><i  class='far fa-plus-square'></i>Add question </button>"."</a>";
    echo '<a href="index.php" >' . "<button class='btn btn-secondary btn-md'><i style='width: 15px' class='fas fa-list-ul'></i> Back to tests</button>"."</a>" ;
    ?>
    </div>
</p>
</div>
</body>
</html>
