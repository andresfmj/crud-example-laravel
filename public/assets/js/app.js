
$(document).ready(function(){

    $( "#inputDateIni, #inputDateEnd" ).datepicker({ dateFormat: 'yy-mm-dd' })

})


function removeItem(obj, uri) {
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (confirm('¿desea eliminar este registro?')) {
        var userId = $(obj).data('id')
        var postUri = uri.replace('#id#', userId)
        $.post(postUri, {_token: token.content, id: userId})
            .done(function(res){
                if (!res.error) {
                    $('#alertTitle').parent().addClass('alert-success')
                    $('#alertTitle').parent().removeClass('alert-danger')
                    $(obj).parent().parent().remove()
                } else {
                    $('#alertTitle').parent().addClass('alert-danger')
                    $('#alertTitle').parent().removeClass('alert-success')
                }
                $('#alertTitle').text(res.message)
                $('#alertTitle').parent().toggle('200')
                setTimeout(function(){
                    $('#alertTitle').parent().toggle('200', function(){
                        $('#alertTitle').text('')
                    })
                }, 4000)
            })
    }
}
