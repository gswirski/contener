<h2>Dodaj węzeł</h2>
<p>
    Dodaj 
    <select id="new_node_type" name="new_node_type"><option value="Contener_Node_Page">Strona</option></select>
    z szablonem
    <select id="new_node_template" name="new_node_template">
        <option value="">Szablon domyślny</option>
        <?php $themeConfig = $theme->getConfig(); foreach ($themeConfig['templates'] as $name => $options) { ?>
        <option value="<?php echo $name; ?>"<?php echo ($page->template === $name)?' selected="selected"':''; ?>><?php echo $options['title']; ?></option>
        <?php } ?>
    </select>
    
    jako podstrona dla 
    <select id="new_node_parent" name="new_node_parent">
        <option value="">Główny korzeń</option>
        <?php foreach ($list as $parent) { ?>
        <option value="<?php echo $parent['id']; ?>"<?php echo ($page->parent === $parent['id'])?' selected="selected"':''; ?>><?php echo str_repeat('&nbsp;&nbsp;', $parent['level']) . $parent['title']; ?></option>
        <?php } ?>
    </select>
    &nbsp;&nbsp; <input type="submit" id="new_node_reload" name="new_node_reload" value="Uaktualnij edytor" />
</p>

<?php echo $this->render('page_edit', array('page' => $page, 'context' => $context)); ?>