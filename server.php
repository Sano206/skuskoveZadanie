<?php
require('config.php');
require_once './2FA/PHPGangsta/GoogleAuthenticator.php';

session_start();

// initializing variables
$username = "";
$email = "";
$errors = array();
$websiteTitle = 'Zadanie3';

$ga = new PHPGangsta_GoogleAuthenticator();

$db = mysqli_connect($dbServername, $dbUsername, $dbPassword, $database);

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM instructors WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_BCRYPT);//encrypt the password before saving in the database


        $secret = $_POST['secret'];

        if ($result) {
            echo 'Verified';
        } else {
            echo 'Not verified';
        }

        $query = "INSERT INTO instructors (username, email, password, secret) 
  			  VALUES('$username', '$email', '$password', '$secret')";
        mysqli_query($db, $query);


        $query = "SELECT * FROM instructors WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($results);
        $userId = $user['id'];
        $secret = $user['secret'];
        saveLoginInfo($userId, 'registration', $username, $db);
    }
}

if ($_POST['login'] == 'instructor') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $code = $_POST['code'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (empty($code)) {
        array_push($errors, "Code is required");
    }


    if (count($errors) == 0) {

        $query = "SELECT * FROM instructors WHERE username='$username'";
        $results = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($results);

        if (mysqli_num_rows($results) == 1 && password_verify($password, $user['password'])) {
            $secret = $user['secret'];
            $result = $ga->verifyCode($secret, $code);

            if ($result == 1) {
                $userId = $user['id'];
                $_SESSION["instructorId"] = $userId;
                saveLoginInfo($userId, 'registration', $username, $db);
            } else {
                array_push($errors, "Wrong code");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

if ($_POST['login'] == 'student') {
    require('config.php');
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $surname = mysqli_real_escape_string($db, $_POST['surname']);
    $code = mysqli_real_escape_string($db, $_POST['code']);

    if (empty($name)) {
        array_push($errors, "Username is required");
    }
    if (empty($surname)) {
        array_push($errors, "Password is required");
    }
    if (empty($code)) {
        array_push($errors, "Code is required");
    }

    if (count($errors) == 0) {

        $stmt = $conn->prepare("SELECT * FROM tests WHERE code=:code and active=1"); //Check code validity
        $stmt->bindParam(":code", $code);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            var_dump($e);
        }
        $test = $stmt->fetchAll();
        if (empty($test[0])) {
            array_push($errors, "Invalid code");
        } else {


            $studentCheck = $conn->prepare("SELECT * FROM students WHERE name=:name and surname = :surname"); //check student existence

            $studentCheck->bindParam(":name", $name);
            $studentCheck->bindParam(":surname", $surname);
            try {
                $studentCheck->execute();
            } catch (Exception $e) {
                var_dump($e);
            }
            $student = $studentCheck->fetchAll();
            if (empty($student[0])) {
                $stmt = $conn->prepare("INSERT INTO students(name, surname) values(:name, :surname)"); //create new user if non-existent
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":surname", $surname);
                try {
                    $stmt->execute();
                } catch (Exception $e) {
                    var_dump($e);
                }
                try {
                    $studentCheck->execute();
                } catch (Exception $e) {
                    var_dump($e);
                }
                $student = $studentCheck->fetchAll();
            }

            $stmt = $conn->prepare("SELECT * FROM tests_taken WHERE student_id=:student_id and test_id = :test_id"); //check if test already taken
            $stmt->bindParam(":test_id", $test[0]["id"]);
            $stmt->bindParam(":student_id", $student[0]["id"]);
            try {
                $stmt->execute();
            } catch (Exception $e) {
                var_dump($e);
            }
            $alreadyTaken = $stmt->fetchAll();
            if (!empty($alreadyTaken[0])) {
                $_SESSION["username"] = $student[0]["name"];
                $_SESSION["userId"] = $student[0]["id"];
                $_SESSION["test"] = $test[0];
                header("location: test.php");
            } else {
                $timestamp = date("G:i:s Y-m-d");
                $stmt = $conn->prepare("INSERT INTO tests_taken(test_id, student_id, start_timestamp) values(:test_id, :student_id, :start_timestamp)");
                $stmt->bindParam(":test_id", $test[0]["id"]);
                $stmt->bindParam(":student_id", $student[0]["id"]);
                $stmt->bindParam(":start_timestamp", $timestamp);
                try {
                    $stmt->execute();
                } catch (Exception $e) {
                    var_dump($e);
                }
                $_SESSION["username"] = $student[0]["name"];
                $_SESSION["userId"] = $student[0]["id"];
                $_SESSION["test"] = $test[0];
                header("location: test.php");
            }

        }


    }
}


function saveLoginInfo($userId, $type, $username, $db)
{
//    $timestamp = date('Y-m-d G:i:s', time()+3600*2);
//    $query = "INSERT INTO logins (user_id, reg_type, timestamp)
//  			  VALUES('$userId', '$type', '$timestamp')";
//    mysqli_query($db, $query);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
}

?>
