function hideEditForm(form) {
    form.addClass('display-none');
    form.prevAll('span.equipment-type-name').removeClass('display-none');
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var submitting = false;
var equipmentTypes = $(".equipment-types");
equipmentTypes.on('click', 'a.folder', function (e) {
    e.preventDefault();
    if(!submitting){
        submitting = true;
        $(".equipment-types a").removeClass('active');
        var link = $(this);
        link.addClass('active');
        if(link.hasClass('loaded')){
            if(link.hasClass('open')){
                link.next('div').hide();
                link.find('i.folder-icon').removeClass('fa-folder-open-o').addClass('fa-folder-o');
                link.removeClass('open');
            }
            else {
                link.next('div').show();
                link.find('i.folder-icon').removeClass('fa-folder-o').addClass('fa-folder-open-o');
                link.addClass('open');
            }
            submitting = false;
        }
        else{
            $.get('equipment-types/get-items/'+link.data('id')+'/'+link.find('div').data('deep')).done(function (data) {
                link.addClass('open loaded');
                link.find('i.folder-icon').removeClass('fa-folder-o').addClass('fa-folder-open-o');
                $(data).insertAfter(link);
                submitting = false;
            });
        }
    }
});
equipmentTypes.on('click', 'button.edit-equipment-type', function (){
    var thisButton = $(this);
    var editForm = thisButton.prevAll('form.equipment-edit-name');
    var nameInput = editForm.find('input.edit-name');
    var spanEl = thisButton.prevAll('span.equipment-type-name');
    nameInput.val(spanEl.html());
    spanEl.addClass('display-none');
    editForm.removeClass('display-none');
    nameInput.select();
    return false;
});
equipmentTypes.on('click', 'button.delete-equipment-type', function (){
    var thisButton = $(this);
    swal({
            title: "Вы уверены?",
            text: "Это действие нельзя будет отменить!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Удалить!",
            cancelButtonText: "Отмена",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function(){
            $.post(thisButton.data('url'),{_method: 'delete'}).done(function (data) {
                var equipmentElement = thisButton.parents('a.equipment-type');
                equipmentElement.next('div').remove();
                equipmentElement.remove();
                swal("Удалено!", "Тип оборудования успешно удален!", "success");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                swal("Ошибка", textStatus, "error");
            });
        });
    return false;
});
equipmentTypes.on('click', 'button.update-name', function () {
    if(!submitting){
        submitting = true;
        var thisButton = $(this);
        var newName = thisButton.prevAll('input.edit-name').val();
        $.post(thisButton.data('url'), {
            _method: 'patch',
            name: newName
        }).done(function (data) {
            var form = thisButton.parents('form');
            form.prevAll('span.equipment-type-name').html(newName);
            hideEditForm(form);
            console.log(data);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }).always(function () {
            submitting = false;
        });
    }
    return false;
});
equipmentTypes.on('click', 'button.cancel-update', function () {
    hideEditForm($(this).parents('form'));
    return false;
});
equipmentTypes.on('focus click blur', 'input.edit-name', function () {
    return false;
});
$(".equipment-form").on('submit', function (e) {
    e.preventDefault();
    var parent = $(".equipment-types a.active");
    var folder = $('#folder');
    var rootFolderChecked = $("#rootfolder").is(':checked');
    if(!folder.is(':checked') && !parent.length){
        console.log('Нельзя джобавить элемент не в папку!');
    }
    else {
        var name = $("#name");
        var deep = rootFolderChecked?-1:parent.find('div').data('deep');
        $.post('equipment-types', {
            name: name.val(),
            folder: folder.is(':checked')?1:0,
            parent_id: parent.length && !rootFolderChecked?parent.data('id'):null,
            deep: deep
        }).done(function(data){
            if($('#empty-types').length){
                $('#empty-types').remove();
            }
            var insertHTML = $(data);
            if(parent.length && !rootFolderChecked){
                parent.next('div').append(insertHTML);
            }
            else {
                $(".equipment-types").append(insertHTML);
            }
            name.val('');
            folder.prop('checked', false);
            folder.trigger('change');
        });
    }
});
$('#folder').change(function(){
    var rootFolder = $('#rootfolder');
    if($(this).is(':checked')){
        rootFolder.removeAttr('disabled');
    }
    else {
        rootFolder.prop("checked", false);
        rootFolder.attr('disabled', true);
    }
});