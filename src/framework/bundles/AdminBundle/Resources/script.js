function resizePanes(windowHeight) {
    
    $('.left-sidebar, .editor, .right-sidebar').height(windowHeight-90);
}

$(document).ready(function() {
    resizePanes($(window).height());
    $('a.preview').lightBox();
    
    $(window).resize(function() {
        resizePanes($(this).height());
    });
    
    $('.left-sidebar h3, .right-sidebar h3').click(function() {
        $(this).next().slideToggle('fast');
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened').addClass('closed');
        } else {
            $(this).removeClass('closed').addClass('opened');
        }
    });
    
    $('#publish_status, #in_navigation').change(function() {
        if ($(this).attr('checked')) {
            $(this).next().next().css('display', 'inline');
        } else {
            $(this).next().next().css('display', 'none');
        };
    }).change().disableSelection().next().disableSelection();
    
    $('#template').change(function() {
        var uri = window.location.href;
        var parts = uri.split('&');
        var done = false;
        var value = $(this).val();
        
        parts.forEach(function(item, index) {
            if (item.substring(0, 9) == 'template=') { 
                parts[index] = 'template=' + value;
                done = true;
            } 
        });
        
        if (done) {
            uri = parts.join('&');
        } else {
            uri = window.location + '&template=' + value;
        }
        window.location = uri;
    });
});
