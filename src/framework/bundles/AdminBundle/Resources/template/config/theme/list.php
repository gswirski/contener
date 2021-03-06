<ul class="line">
<?php foreach ($list as $name => $theme) { ?>
    <?php
    
    $style = '';
    
    if ($theme['is_selected']) {
        $style = 'background: #DDD;';
    }
    
    ?>
    <li style="width: 30%; float: left; <?php echo $style; ?>"><a href="<?php echo $this->url->build('admin/config/theme?select&name=' . $name) ?>">
        <h3><?php echo $theme['title']; ?> <?php echo ($theme['is_active']) ? '(Aktywny)' : ''; ?></h3>
        <p><?php echo $theme['description'] ?></p>
        <p><strong>Autor:</strong> <?php echo $theme['author']; ?></p>
    </a></li>
<?php } ?>
</ul>

<hr />
<a href="<?php echo $this->url->build('admin/config/theme?activate&name=' . $selected->name) ?>">Aktywuj</a> | 
<a href="<?php echo $this->url->build('admin/config/theme?edit&name=' . $selected->name) ?>">Edytuj</a>

<input type="submit" class="button" style="float: right; margin: -3px 0px;" value="Zapisz ustawienia szablonu" />
<hr />
