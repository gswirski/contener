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
            echo '<div class="line"><div class="preview" style="float: left; width: 75px; height: 75px; -moz-box-shadow: 0 0 5px #888; margin: 5px;">';
            if ($photo = $context->getPhoto()) {
                echo '<img src="'.$this->assets->getUrl('/uploads/'.$photo). '" width="75" height="75" />';
            } else {
                echo 'Brak zdjęcia';
            }
            echo '</div>';
            echo '<div style="float: left; margin: 5px;">';
            echo '<p>Zmień zdjęcie:';
            echo '<input style="display: block;" type="file" id="'.$context->getId().'" name="'.$context->getFullyQualifiedName().'" /></p>';
            echo '<p>Zmianę zobaczysz po zapisaniu strony</p>';
            echo '</div>';
            echo '</div>';
            break;
        default:
            echo 'brak edytora';
            break;
    }
}
?></div>
