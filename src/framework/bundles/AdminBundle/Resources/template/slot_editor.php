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
        case 'photo':
            echo '<div class="line"><div class="preview" style="float: left; width: 75px; height: 75px; border: 1px solid black;">';
            if ($photo = $context->getPhoto()) {
                echo $photo;
            } else {
                echo 'Brak zdjęcia';
            }
            echo '</div>';
            echo '<input style="display: block; float: left; margin: 25px 5px;" type="file" id="'.$context->getId().'" name="'.$context->getFullyQualifiedName().'" />';
            echo '</div>';
            break;
        default:
            echo 'brak edytora';
            break;
    }
}
?></div>
