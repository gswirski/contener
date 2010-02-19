<div class="line">
<input type="submit" class="button" id="publish" name="publish" value="Publikuj" />
<input type="submit" class="button" id="save-draft" name="save-draft" value="Zachowaj szkic" />

<a class="button delete" href="#"><img src="<?php asset('images/trash.gif'); ?>" /></a>
</div>

<h3 class="opened">Opcje publikacji</h3>
<dl class="line">
    <dt>Status</dt>
    <dd>
        <input id="published" name="published" type="checkbox" /> <label for="published">opublikowany</label>
        <span style="display: none;">o: <br /><a>18.02.2010 22:26</a></span>
    </dd>
    
    <dt>Nawigacja</dt>
    <dd>
        <input id="in_navigation" name="in_navigation" type="checkbox" /> <label for="in_navigation">pokazuj</label>
        <span style="display: none;">jako:<br /><a>Strona główna</a></span>
    </dd>
    
    <dt>Autor</dt>
    <dd>Grzegorz Świrski</dd>

</dl>
