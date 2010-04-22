var swfu;
var settings = {
    flash_url : "/assets/admin/scripts/swfupload/swfupload.swf",
    flash9_url : "/assets/admin/scripts/swfupload/swfupload_fp9.swf",
    upload_url: "/admin/media?upload",
    post_params: {"PHPSESSID" : ""},
    file_size_limit : "100 MB",
    file_types : "*.*",
    file_types_description : "All Files",
    file_upload_limit : 100,
    file_queue_limit : 0,
    custom_settings : {
        progressTarget : "fsUploadProgress",
        cancelButtonId : "btnCancel"
    },
    debug: false,
    
    // Button settings
    button_image_url: "/assets/admin/images/upload_button.png",
    button_width: "65",
    button_height: "29",
    button_placeholder_id: "spanButtonPlaceHolder",
    button_text: '<span class="theFont">Select</span>',
    button_text_style: ".theFont { font-size: 16; }",
    button_text_left_padding: 12,
    button_text_top_padding: 3,
    
    // The event handler functions are defined in handlers.js
    swfupload_preload_handler : preLoad,
    swfupload_load_failed_handler : loadFailed,
    file_queued_handler : fileQueued,
    file_queue_error_handler : fileQueueError,
    file_dialog_complete_handler : fileDialogComplete,
    upload_start_handler : uploadStart,
    upload_progress_handler : uploadProgress,
    upload_error_handler : uploadError,
    upload_success_handler : uploadSuccess,
    upload_complete_handler : uploadComplete,
    queue_complete_handler : queueComplete	// Queue plugin event
};

function resizePanes(windowHeight) {
    
    $('.left-sidebar, .editor, .right-sidebar').height(windowHeight-90);
}

function getPosition(e) {
    e = e || window.event;
    var cursor = {x:0, y:0};
    if (e.pageX || e.pageY) {
        cursor.x = e.pageX;
        cursor.y = e.pageY;
    } 
    else {
        var de = document.documentElement;
        var b = document.body;
        cursor.x = e.clientX + 
            (de.scrollLeft || b.scrollLeft) - (de.clientLeft || 0);
        cursor.y = e.clientY + 
            (de.scrollTop || b.scrollTop) - (de.clientTop || 0);
    }
    return cursor;
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
    
    $('.allow_swf').css('display', 'none').after('<div class="fieldset flash" id="fsUploadProgress"><span class="legend"></span></div><div><span id="spanButtonPlaceHolder"></span><input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" /></div>');
    if ($('#fsUploadProgress').length) {
        swfu = new SWFUpload(settings);
    }
    
    var clicked = false;
    $("a[href^='/admin/media?edit']").each(function(index, value) {
        $(this).attr('destination', $(this).attr('href'));
        $(this).attr('href', '#');
    }).click(function(e) {
        $('.panel').remove();
        if (clicked == this) {
            clicked = false;
        } else {
            clicked = this;
            
            $.ajax({
                url: $(clicked).attr('destination'),
                cache: false,
                success: function(html) {
                    var position = getPosition(e);
                    $('body').append('<div class="panel" style="top: '+position.y+'px; left: '+position.x+'px;"><form enctype="multipart/form-data" method="post" action="'+$(clicked).attr('destination')+'">'+html+'</form></div>');
                }
            });
        }
    });
});
