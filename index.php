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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>


<div class="container">
    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="index.php?logout='1'" style="color: red;">logout</a></p>
    <?php endif ?>

    <?php if (isset($_SESSION['instructorId'])) : ?>

        <div>
            <table>
                <tr>
                    <th>
                        Test Name
                    </th>
                    <th>
                        Active
                    </th>
                </tr>
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
                    echo '<td>' . '<a href="questiontotest.php?id='. $test["id"]. '" >' . $test["name"] ."</a>" . "   ". $test["code"] . '</td>';
                    echo '<td ><button type="submit" class="toggler" id="' . $test["id"] . '">' . ($test["active"] ? "Yes" : "NO") . '</button></td>';
                    echo '</tr>';
                }

                ?>


            </table>
        </div>


    <?php endif ?>

    <a href="createTest.php">New Test</a>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
<script src="script.js"></script>

</body>
</html>
