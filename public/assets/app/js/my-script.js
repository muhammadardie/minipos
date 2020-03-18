$(document).ready(function(){
    $('body').on('click', '.delete_this', function(){
        var delete_id  = $(this).attr('data-delete');
        var remark     = $('.pos-table').attr('data-remark');
        var url_delete = $('.pos-table').attr('data-delete-url');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':   $('meta[name="csrf-token"]').attr('content')
            }
        });

        swal({
            title: "Are you sure?",
            text: "You can't undo this process!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonText: "Cancel",
            confirmButtonText: "Yes, delete it!"
            })
            .then( function (result) {
                if (result.value) {  
                    $.ajax({
                        type: "DELETE",
                        dataType: "JSON",
                        url: url_delete+'/'+delete_id,
                        success: function(data){
                            if(data === true){
                                swal("Success!", remark+" has been deleted", "success");
                                $('#'+remark+'-table').DataTable().ajax.reload();
                            } else {
                                console.log(data);
                                swal("Failed!", "Unable to delete "+remark+".", "error");
                            }
                        }
                    });
                }
              
            });
    });
});