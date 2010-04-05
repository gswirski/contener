$(document).ready(function() {
    CKEDITOR.addStylesSet( 'my_styles',
    [
        { name : 'Bez formatowania', element : 'p' },
        { name : 'Nagłówek duży', element : 'h3' },
        { name : 'Nagłówek średni' , element : 'h4'  },
        { name : 'Nagłówek mały' , element : 'h5'  }
    ]);
    
    var config = {
    	toolbar:
    	[
        	['-','NumberedList','BulletedList','-','Blockquote','-'],
    	    ['Styles','-','Bold','Italic','Underline','Strike','-'],
        	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-'],
        	['Link','Unlink','Anchor','-'],
            ['Source']
        ],
        stylesCombo_stylesSet: 'my_styles',
    	skin: 'contener'
    };
    $('textarea').ckeditor(config);
})