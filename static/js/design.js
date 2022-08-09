function loaddesign(){
    $('.l-c-3[data-s=facebook] .l-c-3-text').text(' like/people');
    $('.l-c-3[data-s=instagram] .l-c-3-text').text(' followers');
    $('.l-c-3[data-s=youtube] .l-c-3-text').text(' subscriptions');
    $('.l-c-3[data-s=snapchat] .l-c-3-text').text(' friends');
    $('.l-c-3[data-s=tiktok] .l-c-3-text').text(' followers');
    $('.l-c-3[data-s=twitter] .l-c-3-text').text(' followers');
    $('.l-c-3[data-s=pinterest] .l-c-3-text').text(' followers');
    $('.l-c-3[data-s=website] .l-c-3-text').text(' visits per month');

    $('.l-c-1[data-verified=1]').append('<div class="verified"><img src="../style/img/verified.png"/>verified</div>');
}