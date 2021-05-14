<?php
session_start();
require_once "config.php";
$test = $_SESSION["test"];
$test_id = $test[0];
$statement = $conn->prepare("SELECT * FROM questions WHERE test_id = :test_id");
$statement->execute(array(':test_id' => $test_id));
$rows = $statement->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script>
        var canvas, ctx, flag = false,
            prevX = 0,
            currX = 0,
            prevY = 0,
            currY = 0,
            dot_flag = false;

        var x = "black",
            y = 2;

        function init() {
            canvas = document.getElementById('can');
            ctx = canvas.getContext("2d");
            w = canvas.width;
            h = canvas.height;

            canvas.addEventListener("mousemove", function (e) {
                findxy('move', e)
            }, false);
            canvas.addEventListener("mousedown", function (e) {
                findxy('down', e)
            }, false);
            canvas.addEventListener("mouseup", function (e) {
                findxy('up', e)
            }, false);
            canvas.addEventListener("mouseout", function (e) {
                findxy('out', e)
            }, false);
        }

        function color(obj) {
            switch (obj.id) {
                case "green":
                    x = "green";
                    break;
                case "blue":
                    x = "blue";
                    break;
                case "red":
                    x = "red";
                    break;
                case "yellow":
                    x = "yellow";
                    break;
                case "orange":
                    x = "orange";
                    break;
                case "black":
                    x = "black";
                    break;
                case "white":
                    x = "white";
                    break;
            }
            if (x == "white") y = 14;
            else y = 2;

        }

        function draw() {
            ctx.beginPath();
            ctx.moveTo(prevX, prevY);
            ctx.lineTo(currX, currY);
            ctx.strokeStyle = x;
            ctx.lineWidth = y;
            ctx.stroke();
            ctx.closePath();
        }

        function erase() {
            var m = confirm("Want to clear");
            if (m) {
                ctx.clearRect(0, 0, w, h);
                document.getElementById("canvasimg").style.display = "none";
            }
        }

        function save() {
            document.getElementById("canvasimg").style.border = "2px solid";
            var dataURL = canvas.toDataURL();
            document.getElementById("canvasimg").src = dataURL;
            document.getElementById("canvasimg").style.display = "inline";
        }

        function findxy(res, e) {
            if (res == 'down') {
                prevX = currX;
                prevY = currY;
                currX = e.clientX - canvas.offsetLeft;
                currY = e.clientY - canvas.offsetTop;

                flag = true;
                dot_flag = true;
                if (dot_flag) {
                    ctx.beginPath();
                    ctx.fillStyle = x;
                    ctx.fillRect(currX, currY, 2, 2);
                    ctx.closePath();
                    dot_flag = false;
                }
            }
            if (res == 'up' || res == "out") {
                flag = false;
            }
            if (res == 'move') {
                if (flag) {
                    prevX = currX;
                    prevY = currY;
                    currX = e.clientX - canvas.offsetLeft;
                    currY = e.clientY - canvas.offsetTop;
                    draw();
                }
            }
        }
    </script>
</head>
<body>
<h1 style="text-align: center">TESTERINO</h1>

<?php echo "<h3 style='text-align: center'>" . $_SESSION["username"] . " vitaj na teste prajeme ti vela stasti:) </h3>" ?>

<form class="container" method="post">
    <?php
    $x = "q";
    $i = 0;
    foreach ($rows as $row) {

        if ($row["type"] == "short") {
            echo "<div class='form-control'>";
            echo "<p>" . $row["question"] . "</p>";

            echo "<input type='text' name='$x$i' id='$x$i'> ";
            echo "<p>" . $row["points"] . "b" . "</p>";
            echo "</div>";
        } elseif ($row["type"] == "multiple") {
            $statement = $conn->prepare("SELECT * FROM options WHERE question_id = :question_id");
            $statement->execute(array(':question_id' => $row["id"]));
            $columns = $statement->fetch();
            echo "<div class='form-control'>";
            echo "<p>" . $row["question"] . "</p>";
            echo "<select>";
            echo "<option value=" . $row['answer'] . ">" . $row['answer'] . "</option>";
            echo "<option value=" . $columns['option1'] . ">" . $columns['option1'] . "</option>";
            echo "<option value=" . $columns['option2'] . ">" . $columns['option2'] . "</option>";
            echo "<option value=" . $columns['option3'] . ">" . $columns['option3'] . "</option>";
            echo "</select>";
            echo "<p>" . $row["points"] . "b" . "</p>";
            echo "</div>";


        } elseif ($row["type"] == "connection") {

        } elseif ($row["type"] == "math") {

        } elseif ($row["type"] == "image") {


//            echo "<div style='z-index: 156456'>";
//
//
//            echo "<canvas onload='init()' id='can' width='400' height='400' style='position:static;top:10%;left:10%;border:2px solid;'></canvas>
//        <div style='position:static;top:12%;left:43%;'>Choose Color</div>
//        <div style='position:static;top:15%;left:45%;width:10px;height:10px;background:green;' id='green' onclick='color(this)'></div>
//        <div style='position:static;top:15%;left:46%;width:10px;height:10px;background:blue;' id='blue' onclick='color(this)'></div>
//        <div style='position:static;top:15%;left:47%;width:10px;height:10px;background:red;' id='red' onclick='color(this)'></div>
//        <div style='position:static;top:17%;left:45%;width:10px;height:10px;background:yellow;' id='yellow' onclick='color(this)'></div>
//        <div style='position:static;top:17%;left:46%;width:10px;height:10px;background:orange;' id='orange' onclick='color(this)'></div>
//        <div style='position:static;top:17%;left:47%;width:10px;height:10px;background:black;' id='black' onclick='color(this)'></div>
//        <div style='position:static;top:20%;left:43%;'>Eraser</div>
//        <div style='position:static;top:22%;left:45%;width:15px;height:15px;background:white;border:2px solid;' id='white' onclick='color(this)'></div>
//        <img id='canvasimg' style='position:static;top:10%;left:52%;' style='display:none;'>
//        <input type='button value='save' id='btn' size='30' onclick='save()' style='position:absolute;top:55%;left:10%;'>
//        <input type='button' value='clear' id='clr' size='23' onclick='erase()' style='position:static;top:55%;left:15%;'>";
//            echo "Idz do pici z kanvasom";
//            echo "</div>";

        }
        $i++;
    }

    ?>

    <div class="form-control">
        <input type="submit" class="btn-primary" value="Chuju posielaj">
    </div>


</form>


</body>
</html>