$(document).ready(function () {
    // Événements de clic sur les boutons de navigation
    $('.flickr_carrousel_prev').click(function () {
        $('.active').animate({ left: '100%' }, 500, function () {
            $(this).removeClass('active');
            $(this).css('left', '-100%');
            $(this).prev().addClass('active');
            $(this).prev().animate({ left: '0%' }, 500);
        });
    });
    $('.flickr_carrousel_next').click(function () {
        $('.active').animate({ left: '-100%' }, 500, function () {
            $(this).removeClass('active');
            $(this).css('left', '100%');
            $(this).next().addClass('active');
            $(this).next().animate({ left: '0%' }, 500);
        });
    });
});