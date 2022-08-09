let id_category = '';
let id_subcategory = '';
let id_follow_1 = '';
let id_follow_2 = '';
let id_verifi = '';
let id_countryl = '';
let part = '';
let loader = '0';
let id_sort = '';

window.onbeforeunload = function () {
    window.scrollTo(0, 0);
  }

// On click follow
function load_viewlink(this_id,ff_active){
    function alert_follow(){
        $('.pop-container').html('' +
            '<div class="p-c-f">You must be logged in to follow' +
            '   <div class="f-exit"></div>' +
            '</div>');
        $('.pop-alert').show();
        $('.f-exit').click(function (){
            $('.pop-alert').hide();
            $('.p-c-f').remove();
        });
    }

    let data_id = $(this_id).attr('data-id');
    let data_f = $(this_id).attr('data-f');
    if ($(this_id).hasClass('ff')) {
        if (data_f == 'on') {
            $.post("../action.php", {followed: 'change', data_id: data_id, data_f: data_f}, function (response) {
                if(response == 'false'){
                    alert_follow();
                } else {
                    $('.p-love[data-id=' + data_id + ']').attr('data-f', response);
                    $('.p-box[data-id=' + data_id + ']').fadeOut(700);
                }
            });
        }
    } else {
        if (data_f == 'on') {
            $.post("../action.php", {followed: 'change', data_id: data_id, data_f: data_f}, function (response) {
                if(response == 'false'){
                    alert_follow();
                } else {
                    $('.p-love[data-id=' + data_id + ']').attr('data-f', response);
                    if (ff_active == '1') {
                        $("body").css("overflow", "visible");
                        $('.pop-alert').hide();
                        $('.p-box[data-id=' + data_id + ']').fadeOut(700);
                    }
                }
            });
        } else {
            $.post("../action.php", {followed: 'change', data_id: data_id, data_f: data_f}, function (response) {
                if(response == 'false'){
                    alert_follow();
                } else {
                    if (response == 'limit'){
                        $('.pop-container').html('' +
                            '<div class="p-c-f">You have reached your follow limit' +
                            '   <div class="f-exit"></div>' +
                            '</div>');
                        $('.pop-alert').show();
                        $('.f-exit').click(function (){
                            $('.pop-alert').hide();
                            $('.p-c-f').remove();
                        });
                    } else $('.p-love[data-id=' + data_id + ']').attr('data-f', response);
                }
            });
        }
    }
}
// On click view link
function viewlink(){
    $('.list,.p-box').click(function (){
        let ff_active = '';
        if($(this).hasClass('ff')){
            ff_active = '1';
        }
        $("body").css("overflow", "hidden");
        let list_id = $(this).attr('data-id');
        $.post("../action.php", {addview: 'addview', id: list_id});
        $.post("../action.php", {viewlink: 'viewlink', id: list_id}, function (response) {
            $('.pop-alert').html(response);
            $('.pop-alert').show();
            // On click follow
            $('.p-love.view').click(function (){
                let this_id = $(this);
                load_viewlink(this_id,ff_active);
            });
            // On click exit
            $('.p-c-exit').click(function (){
                $("body").css("overflow", "visible");
                $('.pop-alert').hide();
                $('.p-c-f').remove();
            });
            $('.p-c-btn').click(function (){
                let btn_id = $(this).attr('data-id')
                $.post("../action.php", {addclick: 'addclick', id: btn_id}, function (response) {
                    if (response == 0){
                        location.replace('../login.php');   
                    } else location.replace(response);
                });
            });
            $('.p-c-v[data-verified=1]').append('<div class="verified-v"><img src="../style/img/verified.png"/>This profile is verified</div>');
        });
    });
}
// Loading link
    function load(){
        part = ''; 
        $.post("../action.php", {action: 'change', part: part, cat: id_category, scat: id_subcategory, coun: id_countryl, follow1: id_follow_1, follow2: id_follow_2, verifi: id_verifi, sort: id_sort}, function (response) {
            $('.container').attr('data-category', id_verifi).fadeOut(300, function() {
                $(this).html(response).fadeIn(300);
                loaddesign();
                viewlink();
                sort();
            });
        });
    }
// On click result sort
    let id_sort_text = 'The lastest';
    function sort(){
        $('.s-f-text[data-id=so]').text(id_sort_text);
    }
    $(document).on('click','.s-f-dropdown[data-id=so] > .s-f-n-drop',function () {
        id_sort_text = $(this).text();
        id_sort = $(this).attr('data-id');
        load();
        $('.s-f-text[data-id=so]').text(id_sort_text);
    });
// Dynamic loading category and country
    function dynamic_c_c(){
        $('.s-f-remove').remove();
        $.post("../action.php", {action: 'category_change', social:id_category}, function (response) {
            $('.s-f-dropdown[data-id=c]').append(response);
            // On click result category
            $('.s-f-dropdown[data-id=c] > .s-f-n-drop').click(function () {
                if ($(this).attr('data-id') == 'All') {
                    id_subcategory = '';
                    load();
                    $('.s-f-text[data-id=c]').text('All');
                } else {
                    id_subcategory = $(this).attr('data-id');
                    load();
                    $('.s-f-text[data-id=c]').text(id_subcategory);
                }
            });
        });
        $.post("../action.php", {action: 'country_change', social:id_category}, function (response) {
            $('.s-f-dropdown[data-id=cl]').append(response);
            // On click result country
            $('.s-f-dropdown[data-id=cl] > .s-f-n-drop').click(function () {
                if ($(this).attr('data-id') == 'All') {
                    id_countryl = '';
                    load();
                    $('.s-f-text[data-id=cl]').text('All');
                } else {
                    id_countryl = $(this).attr('data-id');
                    load();
                    $('.s-f-text[data-id=cl]').text(id_countryl);
                }
            });
        });
    }
$( document ).ready(function() {
// On click promo link
    viewlink();

// On click loading
    $(document).on('click','.load-more',function(){
        if(loader == '1') {
            id_category = $('.container-l').attr('data-s')
            part = $('.container-l').attr('data-parts');
            $('.load-container').fadeOut(300,function(){
                (this).remove();
            });
            $.post("../action.php", {action: 'change', part: part, cat: id_category, scat: id_subcategory, coun: id_countryl, follow1: id_follow_1, follow2: id_follow_2, verifi: id_verifi}, function (response) {
                new_parts = parseInt($('.container-l').attr('data-parts')) + 1;
                $('.container-l').append(response).attr('data-parts', new_parts);
                viewlink();
                loaddesign();
            });
        }
    });

    loaddesign();
    $('.s-social').click(function(){
        id_category = $(this).attr('data-s');
        dynamic_c_c();
        if(!$(this).hasClass('adrop')){
            $('.s-social').removeClass('adrop');
            $(this).addClass('adrop');
            let cat = $('.s-t-c-name').attr('data-c');
            let s = $(this).attr('data-s');
            $('.s-f-text').text('-');
            $('.s-f-text[data-id=sm]').text(s);
            $(".s-table").slideUp("fast", function(){
                $.post("../action.php", {action: 'count', cat:s}, function (response) {
                    $('.s-t-c-name').remove();
                    $('.s-t-c-container').append(response);
                    $(".s-table").slideDown("slow");
                    $('.r-social,.s-t-all').text('All ' + s).attr('data-s', s);
                    // Filter subcategories
                    $('.s-t-c-name').click(function () {
                        $('.p-links').slideUp('slow');
                        $('.s-social').removeClass('adrop');
                        id_subcategory = $(this).attr('data-c');
                        id_category = $('.s-t-all').attr('data-s');
                        load();
                        loader = '1';
                        $('.s-f-text[data-id=c]').text(id_subcategory);
                        $(".s-table").slideUp("slow");
                        $('.s-f-text[data-id=sm]').text(id_category);
                    });
                    $('.s-t-c-name').click(function () {
                        $(".s-filter").css('display', 'flex');
                    });
                });
            });
            $('.search').css('border-bottom','none');
            id_subcategory = '';
            id_follow_1 = '';
            id_follow_2 = '';
            id_follow_3 = '';
            id_verifi = '';
            id_countryl = '';
            part = '';
        } else {

        }
    });
// Filter categories (facebook,youtube,etc.)
    $('.s-t-all').click(function () {
        $('.s-social').removeClass('adrop');
        $('.p-a-text').hide();
        $('.p-links').slideUp('slow');
        id_category = $(this).attr('data-s');
        load();
        loader = '1';
        $('.s-f-text[data-id=sm]').text(id_category);
        $('.s-f-text[data-id=c]').text('-');
        $(".s-table").slideUp("slow");
    });
// Filter menu
    $('.r-social,.s-t-all').click(function () {
        $(".s-filter").css('display', 'flex');
    });
// Filter sm
    $(document).on('click','.s-f-select', function (event) {
        $('.p-a-text').hide();
        let attr = $(this).attr('data-id');
        $('.s-f-dropdown').removeClass('drop');
        $('.s-f-dropdown[data-id=' + attr + ']').addClass('drop');
        $('.s-f-dropdown').not('.drop').hide();
        if ($('.s-f-dropdown').hasClass('drop')) {
            if ($('.s-f-dropdown[data-id=' + attr + ']').is(':visible')) {
                $('.s-f-dropdown[data-id=' + attr + ']').slideUp('fast');
            } else {
                $('.s-f-dropdown[data-id=' + attr + ']').slideDown('fast');
            }
        }
        event.stopPropagation();

    });
// On click result social
    $('.s-f-dropdown[data-id=sm] > .s-f-n-drop').click(function () {
        id_category = $(this).attr('data-id');
        $('.s-f-text[data-id=sm]').text(id_category);
        $('.s-f-text[data-id=c]').text('-');
        $('.s-f-text[data-id=cl]').text('-');
        $('.s-f-text[data-id=f]').text('-');
        $('.s-f-text[data-id=v]').text('-');
        id_subcategory = "";
        id_follow_1 = '';
        id_follow_2 = '';
        id_verifi = '';
        id_countryl = '';
        load();
        dynamic_c_c();
    });
// On click result ammount
    $('.s-f-dropdown[data-id=f] > .s-f-n-drop').click(function () {
        if($(this).attr('data-id') == 'All'){
            id_follow_1 = '';
            id_follow_2 = '';
            load();
            $('.s-f-text[data-id=f]').text('All');
        } else {
            id_follow = $(this).attr('data-id');
            id_follow_text = $(this).text();
            if (id_follow == 1){
                id_follow_1 = 1;
                id_follow_2 = 1000;
            } else if(id_follow == 2){
                id_follow_1 = 1000;
                id_follow_2 = 5000;
            } else if(id_follow == 3){
                id_follow_1 = 5000;
                id_follow_2 = 10000;
            } else if(id_follow == 4){
                id_follow_1 = 10000;
                id_follow_2 = 50000;
            } else if(id_follow == 5){
                id_follow_1 = 50000;
                id_follow_2 = 100000;
            } else if(id_follow == 6){
                id_follow_1 = 100000;
                id_follow_2 = 500000;
            } else if(id_follow == 7){
                id_follow_1 = 500000;
                id_follow_2 = 1000000;
            } else if(id_follow == 8){
                id_follow_1 = 1000000;
                id_follow_2 = 999999999;
            }
            load();
            $('.s-f-text[data-id=f]').text(id_follow_text);
        }
    });
// On click result verification
    $('.s-f-dropdown[data-id=v] > .s-f-n-drop').click(function () {
        let id_verifi_text = $(this).text();
        id_verifi = $(this).attr('data-id');
        load();
        $('.s-f-text[data-id=v]').text(id_verifi_text);
    });

    $(window).click(function () {
        $('.s-f-dropdown').hide();
    });
    $('.p-love').on('click touchstart', function(event) { // for mobile
        event.stopPropagation();
        let this_id = $(this);
        load_viewlink(this_id);
    });
});