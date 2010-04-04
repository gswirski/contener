$(document).ready(function() {
    var config = {
    	toolbar:
    	[
    		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
    		['UIColor']
    	]
    };
    $('textarea').ckeditor(config);
})