$('.add-phone').click(function(){
    var newPhone = $('.'+$(this).attr('id')+'.template').clone().removeClass('template').removeAttr('style').removeAttr('id');
    var model = newPhone.data('model');
    newPhone.removeAttr('data-model');
    var input = newPhone.find('input[type=text]').removeAttr('id').uniqueId();
    var hidden = newPhone.find('input[type=hidden]');

    input.attr('name', model+'[phones]['+input.attr('id')+'][phone]');
    hidden.attr('name', model+'[phones]['+input.attr('id')+'][type]');
    newPhone.appendTo('#field-phones');
    $('#'+input.attr('id')).inputmask(window[input.data('pluginInputmask')]);
    return false;
});

$(document).on('click', '.delete-phone', function(){
    var id = $(this).data('id');
    if(id){
        $.ajax({
            url: $(this).data('url'),
            async: false,
            type: 'post',
            dataType: "json",
            data:{id:id, _csrf: yii.getCsrfToken()},
            statusCode: {
                404: function() {
                    console.log('Phone not deleted');
                    return false;
                }
            }
        });
    }
    $(this).parents('.phone').remove();
    return false;
});