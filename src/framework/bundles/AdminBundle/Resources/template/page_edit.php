<h2>Edytuj zawartość</h2>
<div class="page-title"><input type="text" id="title" name="title" value="<?php echo $page->title; ?>" /></div>
<p class="permament-link">

    <strong>Bezpośredni odnośnik</strong>:
    http://localhost/<?php echo $page->getParentPath(); ?><span class="editable"><input type="text" id="filtered_title" name="filtered_title" value="<?php echo $page->filtered_title; ?>" /></span>/
</p>

<?php

foreach ($page->getSlotManager() as $slot) {
    echo $this->getWidget('AdminBundle_Widget_Editor')->setSlot($slot);
}

?>

<!--<ul class="tabs">
    <li><a href="#">Opis</a></li>
    <li class="active"><a href="#">Dane techniczne</a></li>
    <li><a href="#">Galeria</a></li>
</ul>


<label for="slots-text">Wartość tekstowa</label>
<div class="input"><input type="text" id="slots-text" name="slots[text]" value="" /></div>

<label for="slots-long_text">Długi tekst</label>
<div class="input"><textarea rows="10" cols="10" id="slots-long_text" class="wysiwyg" name="slots[long_text]"></textarea></div>

<label for="slots-long_text">Kolejny długi tekst</label>
<div class="input"><textarea rows="10" cols="10" id="slots-long_text_another" class="wysiwyg" name="slots[long_text]"></textarea></div>


<label for="slots-text">I mały bonus</label>
<div class="input"><input type="text" id="slots-text-another" name="slots[text]" value="" /></div>
</div>-->