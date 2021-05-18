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
        $('.question-style').css("display", "block")
        $('.lalaland').css("display","none")

        if($('#type  option:selected').val() === "multiple"){
            $('.option-div').css("display", "block")

        }else if($('#type  option:selected').val() === "connection"){
            $('.option-div-conn').css("display", "block")
            $('.question-style-answer').css("display", "none")
            $('.question-style').css("display", "none")

        }
        else if($('#type  option:selected').val() === "image"){
            $('.question-style-answer').css("display", "none")


        }else if($('#type  option:selected').val() === "math"){
            $('.question-style-answer').css("display", "none")
            $('.lalaland').css("display","block")

        }else{
            $('.option-div').css("display", "none")
            $('.question-style-answer').css("display", "block")
            $('.lalaland').css("display","none")
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