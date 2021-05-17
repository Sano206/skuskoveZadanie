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
    <link rel="stylesheet" href="CSS/custom.css">
    <link rel="stylesheet" href="mathquill-0.10.1/mathquill.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="mathquill-0.10.1/mathquill.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container shadow-lg" id="content">
    <h1>Add questions</h1>
    <form method="post" action="testController.php">
        <div class="form-row">
            <input hidden class="form-control" type="number" name="testId" id="testId"
                   value="<?php echo $_GET["id"]; ?>">
        </div>

        <div class="row">

            <!-- VYBER TYPU OTAZKY -->
            <div class="form-group col-4">
                <label for="type">Select type of question</label>
                <select class="form-control" name="type" id="type">
                    <!--<option value="question" disabled selected>Type</option>-->
                    <option value="short">short answer</option>
                    <option value="multiple">multiple aswers</option>
                    <option value="math">math</option>
                    <option value="connection">connect</option>
                    <option value="image">drawing</option>
                </select>
            </div>
            <div class="form-group col-6"></div>
            <div class="form-group col-2">
                <label for="points" ><strong>Points</strong></label>
                <input class="form-control" min="1" type="number" name="points" id="points">
            </div>
        </div>


        <!--DOPLNOVACIA KRATKA ODPOVED-->
            <div class="form-group">
                <label for="question" class="question-style"><strong>Question</strong></label>
                <input class="question-style form-control" type="text" name="question" id="question">

                <label for="answer" id="anser_id" class="question-style-answer">Correct answer</label>
                <input class="question-style-answer form-control" type="text" name="answer" id="answer">
            </div>



        <!-- 1 SPRAVNA, 3 NESPRAVNE-->
        <div class="row">
            <div class="option-div">
                <label for="option">3 Wrong answers</label>
                <input class="form-control" type="text" name="option1" value="" id="option1">
                <input class="form-control" type="text" name="option2" value="" id="option2">
                <input class="form-control" type="text" name="option3" value="" id="option3">
            </div>
        </div>

        <div class="option-div-conn">
            <!-- prvy connection -->
            <div class="row">
                <div class="form-group col-6">
                    <label for="conn1">Question 1</label>
                    <input class="form-control" type="text" name="conn1" value="" id="conn1">
                </div>
                <div class="form-group col-6">
                    <label for="conn1True"> Correct answer/connection </label>
                    <input class="form-control" type="text" name="conn1True" value="" id="conn1True">
                </div>
            </div>

            <!-- druhy connection -->
            <div class="row">
                <div class="form-group col-6">
                    <label for="conn2">Question 2</label>
                    <input class="form-control" type="text" name="conn2" value="" id="conn2">
                </div>
                <div class="form-group col-6">
                    <label for="conn2True"> Correct answer/connection</label>
                    <input class="form-control" type="text" name="conn2True" value="" id="conn2True">
                </div>
            </div>

            <!-- treti connection -->
            <div class="row">
                <div class="form-group col-6">
                    <label for="conn3">Question 3</label>
                    <input class="form-control" type="text" name="conn3" value="" id="conn3">
                </div>
                <div class="form-group col-6">
                    <label for="conn3True"> Correct answer/connection</label>
                    <input class="form-control" type="text" name="conn3True" value="" id="conn3True">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">

                </div>
                <div class="form-group col-6">
                    <label for="connFalse">1. Extra (wrong) answer</label>
                    <input class="form-control" type="text" name="connFalse" value="" id="connFalse">

                    <label for="ConnFalse2">2. Extra (wrong) answer</label>
                    <input class="form-control" type="text" name="connFalse2" value="" id="connFalse2">
                </div>
            </div>
        </div>






        <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
            <div class="input-group">
                <button style="margin-right: 10px" class="btn btn-success " type="submit" name="action" value="addQuestion">Add Question</button>
                <a style="margin-right: 10px" href="ShowTest.php?id=<?php echo $_GET["id"]?>"<button class='btn btn-primary ' > Nahliadni na test </button></a>
                <a style="margin-right: 10px" href="index.php"<button class='btn btn-primary ' > DOMOV </button></a>
            </div>
        </div>


    </form>

</div>


</body>
<script src="script.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="matika.js"></script>
</html>