$(document).ready(function() {
    var config = {
    	toolbar:
    	[
    	    ['Styles','-','Bold','Italic','Underline','Strike','-'],
        	['Link','Unlink','Anchor','-'],
        	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-'],
        	['NumberedList','BulletedList','-'],
            ['Source']
        ],
    	skin: 'contener'
    };
    $('textarea').ckeditor(config);
})