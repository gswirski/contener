<label for="<?php echo $context->getId(); ?>"><?php echo $context->getLabel(); ?></label>
<?php
    $error = '';
    $class = '';
    if ($context->hasErrors()) {
        $class .= ' error';
        
        $error = '<ul class="errors"><li>';
        $error .= implode('</li><li>', $context->getErrors());
        $error .= '</li></ul>';
    }
    echo $error;
?>
<div class="input"><?php

foreach ($editable_areas as $editable => $type) {
    switch ($type) {
        case 'string':
            echo '<input type="text" id="'.$context->getId().'" name="'.$context->getFullyQualifiedName().'" value="'.$context->getValue().'" />';
            break;
        case 'text':
            $class = '';
            if ($context->getOption('use_wysiwyg')) {
                $class = ' class="wysiwyg"';
            }
            echo '<textarea id="'.$context->getId().'"'.$class.' name="'.$context->getFullyQualifiedName().'">'.$context->getValue().'</textarea>';
            break;
        default:
            echo 'brak edytora';
            break;
    }
}
?></div>
