$(document).ready(function(){
    Permissions.disbleAssignedPermissionsDiv();
});

$('#save-permissions').click(function(){
    Permissions.save($(this));
});

$('#role').change(function(){
    Permissions.displayRole();
});

$('.permission-append').click(function(){
    Permissions.updateList($(this));
});





var Permissions = {
    init: function(){
        Permissions.disableUpdated();
        $("#permission-list").sortable({
            handle: '.handle',
            connectWith: '.connectedSortable',
            update: function(){
                Permissions.enableUpdated();
            },
            stop: function(ev, ui) {
                if($('#role').val() === null){
                    swal('Oops!', 'You must select a role first', 'error');
                    $(this).sortable('cancel');
                    return;
                }else{
                    var btn = 'remove';
                    if($(ui.item).parent().attr('id') == 'permission-list'){
                        btn = 'add';
                    }
                    Permissions.switchButton($(ui.item).find('button'), btn);
                }
            }
        }).disableSelection();

        $("#permission-role-list").sortable({
            handle: '.handle',
            connectWith: '.connectedSortable',
            update: function(item, container, _super){
                Permissions.enableUpdated();
            },
            stop: function(ev, ui){
                var btn = 'add';
                if($(ui.item).parent().attr('id') == 'permission-role-list'){
                    btn = 'remove';
                }
                Permissions.switchButton($(ui.item).find('button'), btn);
            }
        }).disableSelection();
    },
    save: function(elem){
        swal({
            title: elem.data('title'),
            text: elem.data('text'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1f91f3",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                if (elem.data('ajax') === true) {
                    var order = $("#permission-role-list").sortable('toArray');
                    var postData = {
                        list: order,
                        role: $('#role').val()
                    };

                    Action.sendAjax(elem, postData, Permissions.disableUpdated);
                }
            } else {
                swal("Cancelled", "", "error");
            }
        });
    },
    displayRole: function(){
        var role = $('#role').find(':selected').data('name');
        if(localStorage.getItem('updated') === "true"){
            swal({
                title: 'Please confirm',
                text: 'We\'ve detected unsaved changes in this page. Selecting a different role will reload this page. Do you want to proceed?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1f91f3",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    if(role === undefined){
                        return;
                    }
                    location.href = baseUrl + 'assign-permissions/' + role +'/edit';

                } else {
                    swal("Cancelled", "", "error");
                }
            });
        }else{
            if(role === undefined){
                return;
            }
            location.href = baseUrl + 'assign-permissions/' + role +'/edit';
        }
    },
    updateList: function(elem){
        if($('#role').val() === null){
            swal('Oops!', 'You must select a role first', 'error');
            return;
        }
        var permissions = $('#permission-list');
        var rolesPermissions = $('#permission-role-list');
        var parentUl = elem.closest('ul');
        var parentLi = elem.closest('li').detach();

        if(parentUl.attr('id') == permissions.attr('id')){
            rolesPermissions.append(parentLi);
            Permissions.switchButton(elem, 'remove');
        }else{
            permissions.append(parentLi);
            Permissions.switchButton(elem, 'add');
        }

        Permissions.enableUpdated();
    },
    enableUpdated: function(){
        localStorage.setItem("updated", "true");
    },
    disableUpdated: function(){
        localStorage.setItem("updated", "false");
    },
    switchButton: function(button, type){
        if(type == "remove"){
            button.html('REMOVE').removeClass('btn-success').addClass('btn-danger');
        }else{
            button.html('ADD').addClass('btn-success').removeClass('btn-danger');
        }
    },
    disbleAssignedPermissionsDiv: function(){
        var role = $('#role').find(':selected').data('name');
        var note = 'Note: Permission management for System Administrator is disabled.'
        if(role === 'system-administrator'){
            $("#permission-role-list").css('pointer-events','none');
            $("#permission-role-list").css('opacity', '0.4');
            $('#note').text(note);
        }
    }
};
Permissions.init();