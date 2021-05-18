<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="CSS/custom.css">

    <link href="https://fonts.googleapis.com/css?family=Archivo:500|Open+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="mathquill-0.10.1/mathquill.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="mathquill-0.10.1/mathquill.js"></script>
    <title>Completed tests</title>
</head>
<body>
<div id="navbutton">
    <a class="btn btn-outline-success btn-lg" href="javascript:history.back()"><i class="fas fa-arrow-left"></i>Back</a>
</div>
<div class="container shadow-lg" id="content" style="width: 80%; opacity: 1 !important;">
    <?php
    session_start();
    $_SESSION['test_id'] =$_GET['test_id'] ;
    $_SESSION['student_id'] =$_GET['student_id'] ;
    require 'config.php';
    $zero = 0;
    $allright = 0 ;
    $a = $conn->prepare("SELECT * FROM tests WHERE id = :test_id");
    $a->bindParam(":test_id", $_GET['test_id']);
    $a->execute();
    $d = $a->fetch();

    echo "<h1> Test: " . $d['name'] . "</h1>";


    $a = $conn->prepare("SELECT * FROM test_complete WHERE test_id = :test_id and student_id = :student_id");
    $a->bindParam(":test_id", $_GET['test_id']);
    $a->bindParam(":student_id", $_GET['student_id']);
    $a->execute();
    $d = $a->fetchAll();

    $b = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id and id = :question_id");

    $e = $conn->prepare("SELECT * FROM answers WHERE question_id = :question_id");
    $poi = $conn->prepare("SELECT * FROM test_complete WHERE test_id = :test_id and student_id = :student_id and question_id = :question_id");
    $poi->bindParam(":test_id", $_GET['test_id']);
    $poi->bindParam(":student_id", $_GET['student_id']);


    ?>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>question</th>
                    <th>answer</th>
                    <th>type</th>
                    <th>Max points</th>
                    <th>points earned</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                $points = 0;
                $tmp = 0;
                $gosky = 0;

                foreach ($d as $row) {
                    $tmp = 0;
                    $b->bindParam(":test_id", $_GET['test_id']);
                    $b->bindParam(":question_id", $row['question_id']);
                    $b->execute();
                    $c = $b->fetch();
                    $poi->bindParam(":question_id", $row['question_id']);
                    $poi->execute();
                    $lasan  = $poi->fetch();


                    echo "<tr>";

                    //OTAZKA
                    echo "<td>" . $row['question'] . "</td>";


                    //ODPOVED PRE OBRAZOK A OSTATNE
                    if ($row['type'] == 'image') {
                        echo "<td><img style='width: 150px' src='" . $row['answer'] . "'></td>";
                    }elseif ($row['type'] == 'math'){
                        echo "<input id='latex$gosky' type='text' style='display:none;' value='" . $row['answer'] . "'></input>";
                        echo "<td id='frajer$gosky'></td>";
                        $gosky++;
                    }
                    else {
                        echo "<td>" . $row['answer'] . "</td>";
                    }
                    //TYP OTAZKY
                    echo "<td>" . $row['type'] . "</td>";
                    //MAX POINTS
                    echo "<td>" . $c['points'] . "</td>";
                    $upd = $conn->prepare("UPDATE test_complete SET point = :point WHERE test_id = :test_id and student_id = :student_id and question_id= :question_id");

                    $upd->bindParam(":test_id", $_SESSION['test_id']);
                    $upd->bindParam(":student_id", $_SESSION['student_id'] );
                    $upd->bindParam(":question_id", $row['question_id']);
                    //BODOVANIE
                    if($lasan['point'] == null) {


                        if ($row['type'] != 'connection') {
                            //SHORT ODPOVEDE BODOVANIE
                            if ($c['answer'] == $row['answer']) {
                                $upd->bindParam(":point", $c['points']);
                                try {
                                    $upd->execute();
                                } catch (Exception $e) {
                                    var_dump($e);
                                }
                                $tmp = $tmp + $c['points'];
                                //bodovanie pre short
                                echo "<td><input id='" . $row['question_id'] . "' style='width: 70px;' class='matchedit form-control'  type='number' name='points' value='" . $c['points'] . "'></td>";
                            } else {
                                $upd->bindParam(":point",$zero );
                                try {
                                    $upd->execute();
                                } catch (Exception $e) {
                                    var_dump($e);
                                }
                                echo "<td><input id='" . $row['question_id'] . "' style='width: 70px;' class='matchedit form-control' type='number' name='points' value='0'></td>";
                                $tmp = 0;
                            }
                            //SPAJANIE BODOVANIE
                        }
                        else {
                            $e->bindParam(":question_id", $row['question_id']);
                            $e->execute();
                            $r = $e->fetch();

                            //CONNECTION 1. ODPOVED
                            if ($row['question'] == 'answer1') {
                                if (trim($r['answer1']) == trim($row['answer'])) {
                                    $allright += 1 ;
                                    $upd->bindParam(":point", $c['points']);
                                    try {
                                        $upd->execute();
                                    } catch (Exception $e) {
                                        var_dump($e);
                                    }

                                    $tmp = $tmp + $c['points'];
                                    //bodovanie
                                    echo "<td><input id='" . $row['question_id'] . "' style='width: 70px;' class='matchedit form-control' type='number' name='points' value='" . $c['points'] . "'></td>";
                                } else {
                                    $upd->bindParam(":point",$zero );
                                    try {
                                        $upd->execute();
                                    } catch (Exception $e) {
                                        var_dump($e);
                                    }
                                    echo "<td><input id='" . $row['question_id'] . "'  style='width: 70px;' class='matchedit form-control' type='number' name='points' value='0'></td>";
                                    $tmp = 0;
                                }

                                //CONNECTION 2. ODPOVED
                            } elseif ($row['question'] == 'answer2') {
                                if (trim($r['answer2']) == trim($row['answer'])) {
                                    $allright += 1 ;
                                    $upd->bindParam(":point", $c['points']);
                                    try {
                                        $upd->execute();
                                    } catch (Exception $e) {
                                        var_dump($e);
                                    }

                                    //bodovanie
                                    echo "<td><input id='" . $row['question_id'] . "' style='width: 70px;' class='matchedit form-control' type='number' name='points' value='" . $c['points'] . "'></td>";
                                    $tmp = $tmp + $c['points'];
                                } else {
                                    $upd->bindParam(":point",$zero );
                                    try {
                                        $upd->execute();
                                    } catch (Exception $e) {
                                        var_dump($e);
                                    }
                                    echo "<td><input id='" . $row['question_id'] . "' style='width: 70px;' class='matchedit form-control' type='number' name='points' value='0'></td>";
                                    $tmp = 0;
                                }

                                //CONNECTION 3. ODPOVED
                            } else {
                                if (trim($r['answer3']) == trim($row['answer'])) {
                                    $allright += 1 ;

                                    //bodovanie
                                    echo "<td><input id='" . $row['question_id'] . "'  style='width: 70px;' class='matchedit form-control' type='number' name='points' value='" . $c['points'] . "'></td>";
                                    $tmp = $tmp + $c['points'];
                                } else {
                                    echo "<td><input id='" . $row['question_id'] . "'  style='width: 70px;' class='matchedit form-control' type='number' name='points' value='0'></td>";
                                    $tmp = 0;
                                }
                            }
                            if($allright == 3){
                                $points = $points + $c['points'];
                                $allright = 0;
                            }
                        }
                    }
                    else{
                        $upd->bindParam(":point", $lasan['point']);
                        try {
                            $upd->execute();
                        } catch (Exception $e) {
                            var_dump($e);
                        }
                        echo "<td><input id='" . $row['question_id'] . "'  style='width: 70px;' class='matchedit form-control' type='number' name='points' value='" . $lasan['point'] . "'></td>";
                        $points = $points + $lasan['point'];
                    }


                    echo "</tr>";
                    $i++;
                }
                $s = $conn->prepare("SELECT * FROM students WHERE id = :student_id");
                $s->bindParam(":student_id", $_GET['student_id']);
                $s->execute();
                $studentName = $s->fetch();


                echo " Student <strong>" . $studentName['name'] . " " . $studentName['surname'] . "</strong> got: " . $points . "points.";


                ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>

                    $(document).ready(function () {
                        $(".matchedit").on('change', function postinput() {
                            var matchvalue = $(this).val(); // this.value
                            var matchid = $(this).attr("id"); // this.value
                            console.log(matchid);
                            $.ajax({
                                url: 'NewPoints.php',
                                data: {matchvalue: matchvalue,matchid: matchid },
                                type: 'post'
                            }).done(function (responseData) {
                                console.log('Done: ', responseData);
                            }).fail(function () {
                                console.log('Failed');
                            });
                        });
                    });
                </script>

                </tbody>
            </table>
            <div style="padding-left: 25px; padding-top: 25px;" class="button-group">
                <div class="input-group">
                    <button type="button" class="btn btn-secondary" onClick="refreshPage()">Update points</button>
                </div>
            </div>



            <script>
                function refreshPage(){
                    window.location.reload();
                }
            </script>
        </div>
    </div>
</div>
<script src="completed_matika.js"></script>
</body>
</html>