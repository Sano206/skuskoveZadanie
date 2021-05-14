<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

</head>
<body>

<div style="position: absolute; right: 15px; top: 15px">
    <a class="btn btn-info" href="Credits/info.html">Made by</a>
    <a class="btn btn-info" href="Credits/tasks.html">Tasks</a>
</div>

<div class="container w-25" id="content">
    <div class="row">
        <div class="col-8">
            <h2>Register</h2>
        </div>
        <div class="col-4">
            <img class="" style="float: right; width: 50px; height: 50px" src="CSS/test-photo.png"/>
        </div>

    </div>
    <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="row card-body">

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" placeholder="enter username">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" placeholder="mail@domain.com">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="password" name="password_1" placeholder="enter password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Confirm</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="password" name="password_2" placeholder="confirm password">
                    </div>
                </div>

                <div style="padding-top: 10px;" class="row align-items-center">
                    <div class="col-sm-4 ">
                        Scan QR Code
                    </div>
                    <div style="padding-left: 20px" class="col-sm-8 ">
                        <?php
                        require_once './2FA/PHPGangsta/GoogleAuthenticator.php';
                        $ga = new PHPGangsta_GoogleAuthenticator();
                        $websiteTitle = 'Skuska';

                        $secret = $ga->createSecret();
                        //echo 'Secret is: ' . $secret . '<br />';
                        echo '<input type="text" name="secret" value="' . $secret . '" hidden="true">';

                        $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
                        echo '<img src="' . $qrCodeUrl . '" />';
                        ?>
                    </div>
                </div>
                <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                    <div class="input-group">
                        <button type="submit" class="btn btn-secondary" name="reg_user">Register</button>
                    </div>
                </div>
                <p style="font-size: 11px; padding-left: 25px;">
                    Already a member? <a style="font-size: 15px;" href="login.php">Sign in</a>
                </p>




        </div>
    </form>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>
