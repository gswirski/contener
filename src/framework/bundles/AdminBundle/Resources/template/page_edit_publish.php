<div class="line">
<input type="submit" class="button" id="publish" name="publish" value="Publikuj" />
<input type="submit" class="button" id="save-draft" name="save-draft" value="Zachowaj szkic" />
<a class="button delete" href="<?php echo $this->url->build('admin/node?delete&id=' . $context->id); ?>">x</a>
</div>

<h3 class="opened">Opcje publikacji</h3>
<dl class="line">
    <?php $themeConfig = $theme->getConfig(); ?>
    
    <?php if ($context->template !== false) { ?>
    <dt>Szablon</dt>
    <dd>
        <select id="template" name="template">
            <option value="">Szablon domyślny</option>
            <?php foreach ($themeConfig['templates'] as $name => $options) { ?>
            <option value="<?php echo $name; ?>"<?php echo ($context->template === $name)?' selected="selected"':''; ?>><?php echo $options['title']; ?></option>
            <?php } ?>
        </select>
    </dd>
    <?php } ?>
    <dt>Status</dt>
    <dd>
        <input id="publish_status" name="publish_status" type="checkbox"<?php echo ($context->publish_status)?' checked="checked"':''; ?> /> <label for="publish_status">opublikowany</label>
        <span>o: <br /><input id="created_at" name="created_at" type="text" value="<?php echo $context->created_at; ?>" class="editable" /></span>
    </dd>
    
    <dt>Nawigacja</dt>
    <dd>
        <input id="in_navigation" name="in_navigation" type="checkbox"<?php echo ($context->in_navigation)?' checked="checked"':''; ?> /> <label for="in_navigation">pokazuj</label>
        <span>jako:<br /><input id="navigation" name="navigation" type="text" value="<?php echo $context->navigation; ?>" class="editable" /></span>
    </dd>
    
    <dt>Autor</dt>
    <dd>Grzegorz Świrski</dd>
</dl>