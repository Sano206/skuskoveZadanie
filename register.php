<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

</head>
<body>
<div class="container">
    <div class="header">
        <h2>Register</h2>
    </div>
    <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label class="form-control">Username</label>
            <input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label class="form-control">Email</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label class="form-control">Password</label>
            <input class="form-control" type="password" name="password_1">
        </div>
        <div class="input-group">
            <label class="form-control">Confirm password</label>
            <input class="form-control" type="password" name="password_2">
        </div>
        <div>
            <?php
            require_once './2FA/PHPGangsta/GoogleAuthenticator.php';
            $ga = new PHPGangsta_GoogleAuthenticator();
            $websiteTitle = 'Skuska';

            $secret = $ga->createSecret();
            echo 'Secret is: ' . $secret . '<br />';
            echo '<input type="text" name="secret" value="' . $secret . '" hidden="true">';

            $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
            echo 'Google Charts URL QR-Code:<br /><img src="' . $qrCodeUrl . '" />';
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</div>
</body>
</html>
