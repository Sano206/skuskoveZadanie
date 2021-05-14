<?php include('server.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

</head>
<body>

<div style="position: absolute; right: 15px; top: 15px">
    <a class="btn btn-info" href="Credits/info.php">Made by</a>
    <a class="btn btn-info" href="Credits/tasks.php">Tasks</a>
</div>

<div style="min-width: 500px; padding-top: 50px" class="w-25 container">


    <div class="row">
        <div class="col-8">
            <h2 class="">Exam system login</h2>
        </div>
        <div class="col-4">
            <img class="" style="float: right; width: 50px; height: 50px" src="CSS/test-photo.png"/>

        </div>
    </div>

    <div class="row">

        <div id="accordion">
            <div class="card">
                <div class="card-header" >
                    <h5 class="mb-0">
                        <a class="btn btn-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Login Student
                        </a>
                        <a class="btn btn-info " data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Login Teacher
                        </a>
                    </h5>
                </div>



                <!-- LOGIN STUDENT -->
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">

                        <form method="post" action="login.php">
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="name" class="col-sm-3 col-form-label">ID</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="surname" class="col-sm-3 col-form-label">Surname</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="surname">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="code" class="col-sm-3 col-form-label">Test Code</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="code">
                                </div>
                            </div>
                            <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-secondary" name="login" value="student">Login Student</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- LOGIN TEACHER -->
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <?php include('errors.php');
                            session_start();
                            if(isset($_SESSION["msg"])){
                                echo $_SESSION["msg"];
                                unset($_SESSION["msg"]);
                            }
                            ?>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="name" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="name" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="padding-left: 15px" for="name" class="col-sm-3 col-form-label">Auth. Code</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="code">
                                </div>
                            </div>
                            <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-secondary" name="login" value="instructor">Login Instructor</button>
                                </div>
                            </div>
                            <p style="font-size: 11px; padding-left: 25px;">
                                Not yet a member? <a href="register.php">Sign up</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>
