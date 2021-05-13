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
                saveLoginInfo($userId, 'registration', $username,$db);
            } else {
                array_push($errors, "Wrong code");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}


function saveLoginInfo($userId, $type, $username,$db){
//    $timestamp = date('Y-m-d G:i:s', time()+3600*2);
//    $query = "INSERT INTO logins (user_id, reg_type, timestamp)
//  			  VALUES('$userId', '$type', '$timestamp')";
//    mysqli_query($db, $query);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
}

?>
