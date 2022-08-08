let add_image = '';
let old_image = '';
let add_category = '';
let add_subcategory1 = '';
let add_subcategory2 = '';
let add_subcategory3 = '';
let add_countryl = '';
let link_id = '';

let gate = true;
let upl = false;
let on = false;
let add_code = '';
let img = '';

function upload(){
    add_ammount = $('.i-a-l[name=ammount]').val();
    add_title = $('.i-a-l[name=title]').val();
    add_subtitle = $('.i-a-l[name=subtitle]').val();
    add_description = $('.i-a-l[name=description]').val();
    add_link = $('.i-a-l[name=link]').val();
    img = add_category.toLowerCase();
    if (add_category !== '',add_category !== '-') {
        $('.a-p-c-i-ico').remove();
        $('.a-p-c-img').attr('data-id',img);
        $('.s-r-d-container').attr('data-id',img);
        $('.a-p-c-img').append('' +
            '<div class="a-p-c-i-ico">' +
            '   <img src="../style/img/img_' + img + '.png"/>' +
            '</div>');
    }
    if (add_subcategory1 !== '' || add_subcategory2 !== '' || add_subcategory3 !== '') {
        $('.a-p-c-c-cat').remove();
        $('.a-p-c-category').append('<div class="a-p-c-c-cat">#' + add_subcategory1 + ' #' + add_subcategory2 + ' #' + add_subcategory3 + '</div>');
    }
    if (add_ammount !== '') {
        $('.a-p-c-ammount').html('<img src="../style/img/crowd.png"/> ' + add_ammount);
    }
    if (add_countryl !== '') {
        if(add_code !== undefined) {
            $('.a-p-c-flag').html('<img src="../style/img/flags/4x3/' + add_code + '.svg"/> ' + add_countryl);
        }
    }
    if (add_title !== '') {
        $('.a-p-c-title').remove();
        $('.s-r-d-container,.s-r-m-container').append('' +
            '<div class="a-p-c-title">' + add_title + '</div>');
    }
    if (add_subtitle !== '') {
        $('.a-p-c-subtitle').remove();
        $('.s-r-d-container,.s-r-m-container').append('' +
            '<div class="a-p-c-subtitle">' + add_subtitle + '</div>');
    }
    if (add_description !== '') {
        $('.a-p-c-description,.a-p-c-btn').remove();
        $('.s-r-d-container,.s-r-m-container').append('' +
            '<div class="a-p-c-description">'+add_description+'</div>\n' +
            '<div class="a-p-c-btn">Go to social</div>'
        );
    }
}

$( document ).ready(function() {
    add_image = $('.a-p-c-img>img').attr("data-id");
    add_category = $('.s-f-text[data-id=add-sm]').text();
    add_subcategory1 = $('.s-f-text[data-id=add-c1]').text();
    add_subcategory2 = $('.s-f-text[data-id=add-c2]').text();
    add_subcategory3 = $('.s-f-text[data-id=add-c3]').text();
    add_countryl = $('.s-f-text[data-id=add-cl]').text();
    add_ammount = $('.i-a-l[name=ammount]').val();
    add_title = $('.i-a-l[name=title]').val();
    add_subtitle = $('.i-a-l[name=subtitle]').val();
    add_description = $('.i-a-l[name=description]').val();
    add_link = $('.i-a-l[name=link]').val();
    link_id = $('.a-container').attr('data-id');
    old_image = $('.a-p-c-img>img').attr("data-id");

    img = add_category.toLowerCase();
    add_code = $('.a-p-c-flag').attr('data-code');

    $('.s-m-button').click(function (){
        $('.s-m-button').removeClass('s-m-b-active');
        $(this).addClass('s-m-b-active');
        if ($(this).attr('data-id') == 'desk'){
            $('.s-r-mob').hide();
            $('.s-r-desk').slideDown();
        } else if ($(this).attr('data-id') == 'mob'){
            $('.s-r-desk').hide();
            $('.s-r-mob').slideDown();
        }
    });

    $('.s-f-dropdown[data-id=add-sm] > .s-f-n-drop').click(function () {
        add_category = $(this).attr('data-id');
        $('.s-f-text[data-id=add-sm]').text(add_category);
        upload();
    });
    $('.s-f-dropdown[data-id=add-c1] > .s-f-n-drop').click(function () {
        add_subcategory1 = $(this).attr('data-id');
        $('.s-f-text[data-id=add-c1]').text(add_subcategory1);
        upload();
    });
    $('.s-f-dropdown[data-id=add-c2] > .s-f-n-drop').click(function () {
        add_subcategory2 = $(this).attr('data-id');
        $('.s-f-text[data-id=add-c2]').text(add_subcategory2);
        upload();
    });
    $('.s-f-dropdown[data-id=add-c3] > .s-f-n-drop').click(function () {
        add_subcategory3 = $(this).attr('data-id');
        $('.s-f-text[data-id=add-c3]').text(add_subcategory3);
        upload();
    });
    $('.s-f-dropdown[data-id=add-cl] > .s-f-n-drop').click(function () {
        add_countryl = $(this).attr('data-id');
        add_code = $(this).attr('data-code');
        $('.s-f-text[data-id=add-cl]').text(add_countryl);
        upload();
    });

    //Letter counter
    $('.i-a-l').click(function (){
        let attr = $(this).attr('name');
        $('.i-a-l[name='+attr+']').on('input', function() {
            upload();
            let letter = $('.i-a-l[name='+attr+']').val().length;
            let name = '';
            if (attr == 'title'){
                name = 60;
            } else if (attr == 'subtitle'){
                name = 90;
            } else if (attr == 'description'){
                name = 255;
            }
            $('.count-text[name='+attr+']').text(letter+'/'+name);
            if(letter == name){
                $('.count-text[name='+attr+']').css('color', 'red');
            } else {
                $('.count-text[name='+attr+']').css('color', '#525252');
            }
        });
    });

    //croppie
    $('.a-b-upload').click(function (){
        $('.pop-alert').show();
        $("body").css("overflow", "hidden");
        $('.pop-container').html('' +
            '<div class="p-c-exit" style="margin: 121px 0 0 538px;">x</div>\n' +
            '   <div class="panel panel-default" style="margin: 25px 0;">\n' +
            '        <div class="panel-body">\n' +
            '            <div class="row">\n' +
            '                <center><div class="col-md-4 text-center" style="padding-top:30px;">\n' +
            '                    <div id="upload-input" style="width:350px;"></div>\n' +
            '                </div>\n' +
            '                <div class="col-md-4 b-u">\n' +
            '                    <strong>Select Image:</strong>\n' +
            '                    <br/>\n' +
            '                    <input type="file" id="upload">\n' +
            '                    <br/></center>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>');

        if(add_image !== "") {
            if (gate == true) {
                $('.panel-body').append('<div class="panel-mask"><img src="../style/img/upload/' + add_image + '"/></div>');
                $('.panel-mask').css('display', 'flex');
            }else{
                $('.panel-body').append('<div class="panel-mask"><img src="' + add_image + '"/></div>');
                $('.panel-mask').css('display', 'flex');
            }
        }

        /* On click exit */
        $('.p-c-exit').click(function (){
            $("body").css("overflow", "visible");
            $('.pop-alert').hide();
        });

        $uploadCrop = $('#upload-input').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#upload').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    $('.panel-mask').hide();
                    gate = false;
                    upl = true;
                    on = true;
                    $('.btn-success').remove();
                    $('.b-u').append('<button class="btn btn-success upload-result">Upload Image</button>');

                    $('.upload-result').on('click', function (ev) {
                        if (on === true){
                            $uploadCrop.croppie('result', {
                                type: 'canvas',
                                size: 'viewport'
                            }).then(function (resp) {
                                add_image = resp;
                                $('.a-p-c-img>img,.a-p-c-i-ico').remove();
                                if(add_category == '',add_category == '-'){
                                    $(".a-p-c-img").append('<img data-id="img-back" src="'+resp+'" />');
                                }else{
                                    $(".a-p-c-img").append('<img data-id="img-back" src="'+resp+'" /><div class="a-p-c-i-ico"><img src="../style/img/img_' + img + '.png"/></div>');
                                }
                                $('.pop-alert').hide();
                                $("body").css("overflow", "visible");
                            });
                        } else {
                            $('.pop-alert').hide();
                            $("body").css("overflow", "visible");
                        }
                    });
                });

            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    $('button[data-id=link]').click(function (){
        let add_ammount = $('.i-a-l[name=ammount]').val();
        let add_title = $('.i-a-l[name=title]').val();
        let add_subtitle = $('.i-a-l[name=subtitle]').val();
        let add_description = $('.i-a-l[name=description]').val();
        let add_link = $('.i-a-l[name=link]').val();
        $('.error,.success').remove();
        if($(this).attr('name') == 'addlink'){
            let data_action = 'add';
            $.post("../action.php", {links: 'links',data_action: data_action, image: add_image, socialmedia:add_category, subcategory1:add_subcategory1, subcategory2:add_subcategory2, subcategory3:add_subcategory3, countryl:add_countryl, ammount:add_ammount, title:add_title, subtitle:add_subtitle, description:add_description, link:add_link}, function (response) {
                $('.alert').append(response);
                if ($('.success').length){
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        }else if($(this).attr('name') == 'updatelink'){
            let data_action = 'upload';
            $.post("../action.php", {old_image: old_image, links: 'links',link_id: link_id, upl: upl, data_action: data_action, image: add_image, socialmedia:add_category, subcategory1:add_subcategory1, subcategory2:add_subcategory2, subcategory3:add_subcategory3, countryl:add_countryl, ammount:add_ammount, title:add_title, subtitle:add_subtitle, description:add_description, link:add_link}, function (response) {
                $('.alert').append(response);
                if ($('.success').length){
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        }
    });
});