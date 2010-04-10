<h2>Dodaj węzeł</h2>
<p>
    Dodaj 
    <select id="node_type" name="node_type"><option value="Contener_Node_Page">Strona</option></select>
    z szablonem
    <select id="node_template" name="node_template"><option value="Contener_Node_Page">Szablon domyślny</option></select>
    jako podstrona dla 
    <select id="node_parent" name="node_parent">
        <option value="">Główny korzeń</option>
        <?php foreach ($list as $parent) { ?>
        <option value="<?php echo $parent['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;', $parent['level']) . $parent['title']; ?></option>
        <?php } ?>
    </select>
    &nbsp;&nbsp; <input type="submit" value="Uaktualnij edytor" />
</p>

<?php echo $this->render('page_edit', array('page' => $page, 'context' => $context)); ?>