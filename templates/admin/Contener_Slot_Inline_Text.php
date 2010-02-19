<label for="<?php echo $context->getId(); ?>"><?php echo $context->getLabel(); ?></label>
<?php
    $error = '';
    if ($context->hasErrors()) {
        $class .= ' error';
        
        $error = '<ul class="errors"><li>';
        $error .= implode('</li><li>', $context->getErrors());
        $error .= '</li></ul>';
    }
    echo $error;
?>
<div class="input">
<?php

if ($context->getOption('length') == 'short') {
    echo '<input type="text" id="'.$context->getId().'" name="'.$context->getFullyQualifiedName().'" value="'.$context->getValue().'" />';
} else if ($context->getOption('length') == 'long') {
    $class = '';
    if ($context->getOption('use_wysiwyg')) {
        $class = ' class="wysiwyg"';
    }
    echo '<textarea id="'.$context->getId().'"'.$class.' name="'.$context->getFullyQualifiedName().'">'.$context->getValue().'</textarea>';
}

?>
</div>