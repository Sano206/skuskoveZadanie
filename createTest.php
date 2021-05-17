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
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

<div id="navbutton">
    <a class="btn btn-outline-success btn-lg" href="index.php"><i class="fas fa-arrow-left"></i>Back</a>
</div>

<div class="container w-50" id="content">
    <!-- logged in user information -->
    <h1>New Test</h1>

    <form method="post" action="testController.php">
        <div class="form-group row">
            <label for="testName" class="col-sm-3 col-form-label">Title</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="testName" placeholder="name of your test">
            </div>
        </div>
        <div class="form-group row">
            <label for="code" class="col-sm-3 col-form-label">Code</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="code" placeholder="login code for your test">
            </div>
        </div>
        <div class="form-group row">
            <label for="length" class="col-sm-3 col-form-label">Lenght</label>
            <div class="col-sm-9">
                <input class="form-control" type="number" min="0" name="length" placeholder="lenght in minutes">
            </div>
        </div>
        <div style="padding-left: 25px; padding-top: 25px">
            <button type="submit" class="btn btn-success" name="action" value="createTest">Create Test</button>
            <!--<a href="index.php?logout='1'" type="button" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i>logout</a>-->
        </div>
    </form>



</div>

</body>
</html>