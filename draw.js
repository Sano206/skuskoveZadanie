var id, id2;

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
    var canvas = document.getElementById(id);
    dataURL = canvas.toDataURL();
    dataURL = dataURL.substring(22);

    console.log(id2);
    if(dataURL != null){
        $.ajax({url: "https://api.imgur.com/3/image",
            headers: { 'Authorization': 'Client-ID 10e28e00e6c55b6' },
            data: {"image" : dataURL},
            type: "POST",
            success: function(result){
                $('#'+id2).html("check your link here (open as a new tab)")
                    .attr("value",result.data.link); //src = href
            },
            error: function(err){
                console.log(err);
            }});
      //  console.log(id2);
    }else{
        console.log("no image provided");
    }
}

function reply_click(clicked_id)
{
    id = clicked_id;
    var draw = this.__canvas = new fabric.Canvas(id, {
        backgroundColor: 'white',
        centeredScaling: true,
        isDrawingMode: true
    });

}

function reply(clicked_id)
{
    //this.preventDefault();
    id2 = "link"+clicked_id;
    send_imgur();
}

//$("#imgur").click(send_imgur);