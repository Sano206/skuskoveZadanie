<?php include('server.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

</head>
<body>

<div style="position: absolute; right: 15px; top: 15px">
    <a class="btn btn-info" href="Credits/info.html"><i class="fab fa-accessible-icon"></i>Made by</a>
    <a class="btn btn-info" href="Credits/tasks.html"><i class="fas fa-check"></i>Tasks</a>
</div>

<div  class="w-25 container" id="content">


    <div class="row">
        <div class="col-8">
            <h3 class="">Exam system login</h3>
        </div>
        <div class="col-4">
            <img class="" style="float: right; width: 50px; height: 50px" src="CSS/test-photo.png"/>

        </div>
    </div>

    <div class="row">
        <div id="accordion">
            <div class="header" >
                <h5 class="mb-0">

                    <a class="btn btn-secondary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Login Student <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                        </svg>
                    </a>
                    <a class="btn btn-secondary " data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Login Teacher <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                        </svg>
                    </a>
                </h5>
            </div>

            <!-- LOGIN STUDENT -->
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">

                    <form method="post" action="login.php">
                        <div class="form-group row">
                            <label  for="name" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  for="surname" class="col-sm-3 col-form-label">Surname</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="surname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  for="code" class="col-sm-3 col-form-label">Test Code</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="code">
                            </div>
                        </div>
                        <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                            <div class="input-group">
                                <button type="submit" class="btn btn-secondary" name="login" value="student"><i class="fas fa-sign-in-alt"></i>Login</button>
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
                            //echo $_SESSION["msg"];
                            unset($_SESSION["msg"]);
                        }
                        ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Auth. Code</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="code">
                            </div>
                        </div>
                        <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                            <div class="input-group">
                                <button type="submit" class="btn btn-secondary" name="login" value="instructor"><i class="fas fa-sign-in-alt"></i>Login</button>
                            </div>
                        </div>
                        <p style="font-size: 11px; padding-left: 25px;">
                            Not a member yet? <a style="font-size: 15px;" href="register.php">Sign up</a>
                        </p>
                    </form>

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
