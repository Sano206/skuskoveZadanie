<?php
session_start();


if (!isset($_SESSION['instructorId'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pridanie otazky do testu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1 style="text-align: center">TU SI VYBER AKE OTAZKY CHCES ZADAT </h1>
    <form method="post" action="testController.php">
        <div class="input-group">

            <input hidden class="form-control" type="number" name="testId" id="testId" value="<?php echo $_GET["id"]; ?>">

            <label for="question" class="form-control">Zadaj otazku</label> <!--        short question-->
            <input class="form-control" type="text" name="question" id="question">

            <label for="answer" class="form-control">Zadaj odpoved</label> <!--        short answer-->
            <input class="form-control" type="text" name="answer" id="answer">

            <label for="points" class="form-control">Pocet bodov</label> <!--        short answer-->
            <input class="form-control" type="number" name="points" id="points">

            <label for="type" class="form-control">Typ otazky</label>
            <select class="form-control" name="type" id="type">
                <option value="short">Doplňovacia odpoveď</option>
                <option value="multiple">Viacnásobná odpoveď</option>
                <option value="math">Matematický výraz</option>
                <option value="connection">Spájanie</option>
                <option value="image">Kreslenie</option>
            </select>

            <div class="option-div">
                <label for="option" class="form-control">Zadaj odpoved</label>
                <input class="form-control" type="text" name="option1" value="" id="option1">

                <input class="form-control" type="text" name="option2" value="" id="option2">

                <input class="form-control" type="text" name="option3" value="" id="option3">
            </div>

            <button type="submit" name="action" value="addQuestion">Add Question</button>
        </div>



    </form>
</div>

<script src="script.js"></script>
</body>
</html>
