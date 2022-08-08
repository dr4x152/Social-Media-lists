$(document).ready(function() {
    let name = '';
    let id_button = '';

    $(document).on('click','.btn-myacc[name]', function (event){
        name = $(this).attr('name');
        if(name == 'edit'){
            event.stopPropagation();
        } else {
            $('.p-alert').remove();
            $('.p-c-f').remove();
            id_button = $(this).attr('data-id');
            if(name == 'refresh') {
                $.post('../action.php', {action: name, id: id_button}, function (response) {
                    $('.pop-alert').html('' +
                        '<div class="p-alert">' +
                        '   <div class="p-text h">'+response+'</div>' +
                        '   <div class="p-menu">' +
                        '       <button class="p-btn" name="close">Close</button>' +
                        '   </div>' +
                        '</div>');
                    $('.p-btn[name]').click(function () {
                        let btn_name = $(this).attr('name');
                        if (btn_name == 'close') {
                            $('.pop-alert').hide();
                            $("body").css("overflow", "visible");
                        }
                    });
                });
            } else if(name == 'bonus') {
                id_button = $(this).attr('data-id');
                $.post('../action.php', {action: name, id: id_button}, function (response) {
                    $('.pop-alert').html(response);
                    $('.p-btn[name]').click(function () {
                        let btn_name = $(this).attr('name');
                        if (btn_name == 'close') {
                            $('.pop-alert').hide();
                            $("body").css("overflow", "visible");
                        }
                    });
                });
            }else if(name == 'waste') {
                $('.pop-alert').html('' +
                    '<div class="p-alert">' +
                    '   <div class="p-text h">Are you sure you want to delete the social link?</div>' +
                    '   <div class="p-menu">' +
                    '       <button class="p-btn" name="yes">Yes</button>' +
                    '       <button class="p-btn" name="no">No</button>' +
                    '   </div>' +
                    '</div>');
                $('.p-btn[name]').click(function (){
                    let btn_name = $(this).attr('name');
                    if(btn_name == 'yes') {
                        $('.pop-alert').hide();
                        $("body").css("overflow", "visible");
                        $.post('../action.php', {action: name, id: id_button}, function (response) {
                            $('.e-list[data-id=' + response + ']').fadeOut();
                        });
                    } else {
                        $('.pop-alert').hide();
                        $("body").css("overflow", "visible");
                    }
                });
            }
            $('.pop-alert').show();
            $("body").css("overflow", "hidden");
        }
    });
});