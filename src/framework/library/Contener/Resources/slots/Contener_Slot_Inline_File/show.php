<label><?php echo $slot->getLabel(); ?></label>
<?php if ($file = $slot->getFile()) { 
    echo $file;
} else { ?>
<input type="file" name="<?php echo $slot->getFullyQualifiedName(); ?>" id="<?php echo $slot->getId(); ?>" />
<?php } ?>