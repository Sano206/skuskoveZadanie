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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nahlad testu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body class="container">
<h1 style="text-align: center">DENIS JE KOKOT CO SIEL DO KRCMY MIESTO POMOCI KAMOSOM</h1>
<p class="blockquote text-center">
    <?php
    foreach ($rows as $row) {
        echo '<a href="delete.php?id='. $row["id"]. '" >' . "<button class='btn btn-outline-danger'> Vymazat </button>"."</a>" ;
        echo "<br>";
        echo "Otazka cislo " . $question_number;
        echo "<br>";
        if ($row['type'] == "short") {

            echo "Otazka je =" . $row['question'];
            echo "<br>";
            echo "Spravna odpoved =" . $row['answer'];


        } else if ($row['type'] == "multiple") {
            echo "Otazka je = " . $row['question'];
            echo "<br>";
            echo "Spravna odpoved = " . $row['answer'];
            echo "<br>";
            $sql = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
            $sql->execute(array(':question_id' => $row['id']));
            $tmps = $sql->fetch();
            echo "Nespravna/e odpoved/e = " . $tmps['option1'] . ", " . $tmps['option2'] . ", " . $tmps['option3'];


        } else if ($row['type'] == "connection") {
            $sql = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
            $sql->execute(array(':question_id' => $row['id']));
            $tmps = $sql->fetch();
            $sql2 = $conn->prepare("SELECT * FROM answers WHERE option_id = :option_id");
            $sql2->execute(array(':option_id' => $tmps['id']));
            $tmps2 = $sql2->fetch();
            echo "Kombinacia " . $tmps['option1'] . " -> " . $tmps2['answer1'];
            echo "<br>";
            echo "Kombinacia " . $tmps['option2'] . " -> " . $tmps2['answer2'];
            echo "<br>";
            echo "Kombinacia " . $tmps['option3'] . " -> " . $tmps2['answer3'];
            echo "<br>";
            echo "Moznost na zmylenie " . $tmps2['answer_false1'] . " a " . $tmps2['answer_false2'];


        } else if ($row['type'] == "image") {
            echo "Otazka je = " . $row['question'] . " -> student ma kreslit";


        }
        echo "<br>";
        echo $row['points']."b";
        $countOfPoints +=$row['points'];
        echo "<br>";
        echo "<br>";
        $question_number++;
    }
    echo "Dokopy bodov za test = " . $countOfPoints;
    echo "<br>";
    echo '<a href="index.php" >' . "<button class='btn btn-primary btn-lg'> Ulozit </button>"."</a>" ;

    ?>
</p>
</body>
</html>
