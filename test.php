<?php
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <button class="btn" id="save">save</button>

    <button class="btn" id="imgur">send to IMGUR</button>

    <canvas id="canvas" width="500" height="500"></canvas>

    <!--  <a id="link" href=""></a> -->

    <img id="link" src="" alt="pepeg">
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

    var canvas = this.__canvas = new fabric.Canvas('canvas', {
        backgroundColor: 'white',
        centeredScaling: true,
        isDrawingMode: true
    });
    var dataURL = null;

    function download(url, name) {
        $("<a>")
            .attr({
                href: url,
                download: name
            })[0]
            .click();
    }
    function send_imgur() {
        if(dataURL != null){
            $.ajax({url: "https://api.imgur.com/3/image",
                headers: { 'Authorization': 'Client-ID 10e28e00e6c55b6' },
                data: {"image" : dataURL},
                type: "POST",
                success: function(result){
                    $("#link").html("check your link here (open as a new tab)")
                        .attr("src",result.data.link); //src = href
                },
                error: function(err){
                    console.log(err);
                }});
        }else{
            console.log("no image provided");
        }
    }
    function save() {
        var canvas = document.getElementById('canvas');
        dataURL = canvas.toDataURL();
        dataURL = dataURL.substring(22);
    }

    $("#save").click(save);
    $("#imgur").click(send_imgur);

</script>


</body>
</html>
