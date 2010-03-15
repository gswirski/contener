<ul class="line">
<?php foreach ($themes as $name => $theme) { ?>
    <?php
    
    $style = '';
    
    if ($theme['is_active']) {
        $style = 'background: #DDD;';
        
        $active = $theme;
        $active['name'] = $name;
    }
    
    ?>
    <li style="width: 30%; float: left; <?php echo $style; ?>"><a href="<?php url_for('admin/config/theme?select&name=' . $name) ?>">
        <h3><?php echo $theme['title']; ?></h3>
        <p><?php echo $theme['description'] ?></p>
        <p><strong>Autor:</strong> <?php echo $theme['author']; ?></p>
    </a></li>
<?php } ?>
</ul>

<hr />
<a href="<?php url_for('admin/config/theme?activate&name=' . $active['name']) ?>">Aktywuj</a> | 
<a href="<?php url_for('admin/config/theme?edit&name=' . $active['name']) ?>">Edytuj</a>
<hr />

<?php foreach ($theme['slots'] as $slot) {
    echo new AdminBundle_Widget_Editor($slot);
} ?> 