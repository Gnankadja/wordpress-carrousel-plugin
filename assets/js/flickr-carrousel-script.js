$(document).ready(function() {
    // Control clic event
    $('.flickr_carrousel_prev').click(function() {
    $('.active').animate({ left: '100%' }, 500, function() {
        $(this).removeClass('active');
        $(this).css('left', '-100%');
        $(this).flickr_carrousel_prev().addClass('active');
        $(this).flickr_carrousel_prev().animate({ left: '0%' }, 500);
    });
    });
    $('.flickr_carrousel_next').click(function() {
    $('.active').animate({ left: '-100%' }, 500, function() {
        $(this).removeClass('active');
        $(this).css('left', '100%');
        $(this).flickr_carrousel_next().addClass('active');
        $(this).flickr_carrousel_next().animate({ left: '0%' }, 500);
    });
    });
});