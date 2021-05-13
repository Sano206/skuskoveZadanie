<?php include('server.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

</head>
<body>
<div class="container">
    <div class="header">
        <h2>Login</h2>
    </div>
    <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label class="form-control">Username</label>
            <input class="form-control" type="text" name="username">
        </div>
        <div class="input-group">
            <label class="form-control">Password</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="input-group">
            <label class="form-control">Code</label>
            <input class="form-control" type="text" name="code">
        </div>
        <div class="button-group">
            <div class="input-group">
                <button type="submit" class="btn btn-secondary" name="login" value="instructor">Login Instructor</button>
            </div>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
    <form method="post" action="login.php">
        <div class="input-group">
            <label class="form-control">Username</label>
            <input class="form-control" type="text" name="username">
        </div>
        <div class="input-group">
            <label class="form-control">Password</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="input-group">
            <label class="form-control">Code</label>
            <input class="form-control" type="text" name="code">
        </div>
        <div class="button-group">
            <div class="input-group">
                <button type="submit" class="btn btn-secondary" name="login" value="student">Login Student</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
