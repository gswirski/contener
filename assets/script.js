function resizePanes(windowHeight) {
    
    $('.left-sidebar, .editor, .right-sidebar').height(windowHeight-73);
}

$(document).ready(function() {
    resizePanes($(window).height());
    
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
    
    /*$('.left-sidebar .navigation li').each(function() {
        if ( $(this).find('ul li').length > 0 ) {
          $(this).prepend('<span class="indicator opened">-</span>');
          $(this).find('ul li ul').hide();
        } else {
          $(this).prepend('<span class="indicator hidden"></span>');
        }
      });
      
      $('.left-sidebar .navigation li ul .indicator').removeClass('opened').addClass('closed').html('+');
      
      $('.indicator').not('.hidden').click(function() {
        $(this).next().next().slideToggle("fast");
        if ( $(this).html() == '+' ) {
          $(this).html('-');
        } else {
          $(this).html('+');
        }
      });
    */
});