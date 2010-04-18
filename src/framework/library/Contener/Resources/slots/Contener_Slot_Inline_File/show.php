<label><?php echo $slot->getLabel(); ?></label>
<div class="input"><?php if ($file = $slot->getFile()) { 
    echo $file;
} else { ?>
<input type="file" name="<?php echo $slot->getFullyQualifiedName(); ?>" id="<?php echo $slot->getId(); ?>" />
<?php } ?></div>