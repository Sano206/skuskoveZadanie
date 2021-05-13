$(document).ready(function () {
    var table = $('#table_data').DataTable({
            "bFilter": false,
            'bInfo': false,
            'paging': false,
        }
    )


    $('.toggler').click((element) => {
        console.log(element)
        let id = element.delegateTarget.id
        changeTestState(id)

        //$('#modal-body').html("asdf")
    })



});

function changeTestState(id){
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

