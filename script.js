$(document).ready(function () {



    $('.toggler').click((element) => {
        console.log(element)
        let id = element.delegateTarget.id
        changeTestState(id)

        //$('#modal-body').html("asdf")
    })

    $('#type').change(() => {
        $('.option-div').css("display", "none")
        $('.option-div-conn').css("display", "none")
        $('.question-style-answer').css("display", "block")

        if($('#type  option:selected').val() === "multiple"){
            $('.option-div').css("display", "block")
        }else if($('#type  option:selected').val() === "connection"){
            $('.option-div-conn').css("display", "block")

        }
        else if($('#type  option:selected').val() === "image"){
            $('.question-style-answer').css("display", "none")

        }else{
            $('.option-div').css("display", "none")
            $('.question-style-answer').css("display", "block")

        }
    })


});

function changeTestState(id) {
    console.log(id)
    $.ajax({
        url: "testController.php",    //the page containing php script
        type: "post",    //request type,
        dataType: 'json',
        data: {action: "changeTestState", id: id},
        success: function (result) {
            location.reload();
        }
    });
}

