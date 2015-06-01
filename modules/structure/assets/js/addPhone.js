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
    $(this).parents('.phone').remove();
    return false;
});