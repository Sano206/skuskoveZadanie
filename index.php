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
if (isset($_SESSION['userId'])) {
    header("location: test.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Archivo:500|Open+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>


<div class="container w-50 shadow-lg" style="min-width: 580px;" id="content" >
    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <h1>Welcome <strong><?php echo $_SESSION['username']; ?></strong></h1>
    <?php endif ?>

    <?php if (isset($_SESSION['instructorId'])) : ?>
    <div class="row">

        <div>
            <h3 >List of existing tests:</h3>
            <div class="table-responsive" style="margin-right: 50px; margin-left: 50px;">
                <table class="table table-hover" >
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Active</th>
                        <th>Details</th>
                        <!--<th>Edit</th>-->
                        <th>Completed</th>
                    </tr>
                    </thead>
                    <?php
                    require('config.php');
                    $stmt = $conn->prepare("SELECT * from tests where instructor_id = :instructor_id");
                    $stmt->bindParam(":instructor_id", $_SESSION["instructorId"]);
                    try {
                        $stmt->execute();
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                    $tests = $stmt->fetchAll();
                    foreach ($tests as $test) {
                        echo '<tr>';
                        echo '<td>' .  $test["name"] . '</td>';
                        echo '<td>' . $test["code"] . '</td>';
                        echo '<td><button style="border-radius: 75px" type="submit" class="toggler btn btn-small btn-secondary" id="' . $test["id"] . '">' . ($test["active"] ? "Yes" : "No") . '</button></td>';
                        echo '<td>' . '<a href="ShowTest.php?id='. $test["id"]. '" >' .  "<button class='btn btn-secondary'><i style='width: 15px' class='fas fa-file-alt'></i></button>"."</a>".'</td>';
                        //echo '<td>' . '<a href="questiontotest.php?id='. $test["id"]. '" >'. "<button class='btn btn-secondary'><i style='width: 15px' class='fas fa-edit'></i></button>"."</a>".'</td>';
                        echo '<td>' . '<a href="students.php?id='. $test["id"]. '" >'. "<button class='btn btn-secondary'><i style='width: 15px' class='fas fa-flag-checkered'></i></button>"."</a>".'</td>';

                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php endif ?>
    </div>
<div style="padding-left: 25px; padding-top: 25px">
    <a id="addtest" type="button" class="btn btn-secondary btn-md" href="createTest.php"><i class="far fa-plus-square"></i> Add new test</a>
    <a href="index.php?logout='1'" type="button" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
<script src="script.js"></script>

</body>
</html>
