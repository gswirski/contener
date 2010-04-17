<label>Nazwa slotu</label>
<ul style="list-style-type: circle; margin: 0px 0px 0px 15px;">
    <?php foreach ($slot->getSlots() as $child) { ?>
        <li><?php echo $this->display($child); ?></li>
    <?php } ?>
</ul>
<div>
    <?php echo $this->display($slot->getStackType()->setName('n')); ?>
    
    <input type="submit" class="button" style="float: none; margin: 5px 5px 15px 5px" value="Dodaj element" />
</div>