var draw = this.__canvas = new fabric.Canvas('draw', {
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
function send_imgur(event) {
    event.preventDefault();
    var canvas = document.getElementById('draw');
    dataURL = canvas.toDataURL();
    dataURL = dataURL.substring(22);

    if(dataURL != null){
        $.ajax({url: "https://api.imgur.com/3/image",
            headers: { 'Authorization': 'Client-ID 10e28e00e6c55b6' },
            data: {"image" : dataURL},
            type: "POST",
            success: function(result){
                $("#link").html("check your link here (open as a new tab)")
                    .attr("value",result.data.link); //src = href
            },
            error: function(err){
                console.log(err);
            }});
    }else{
        console.log("no image provided");
    }
}

$("#imgur").click(send_imgur);