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
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>


<div class="container">
    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>


    <form method="post" action="testController.php">
        <div class="input-group">
            <label for="testName" class="form-control">Test Name</label>
            <input class="form-control" type="text" name="testName">
        </div>
        <div class="input-group">
            <label for="code" class="form-control">Test Code</label>
            <input class="form-control" type="text" name="code">
        </div>
        <div class="input-group">
            <label for="length" class="form-control">Length in minutes</label>
            <input class="form-control" type="number" value="45" min="0" name="length">
        </div>

        <div class="button-group">
            <div class="input-group">
                <button type="submit" class="btn btn-secondary" name="action" value="createTest">Create Test</button>
            </div>
        </div>

    </form>


</div>

</body>
</html>