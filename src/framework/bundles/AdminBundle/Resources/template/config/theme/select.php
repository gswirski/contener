<?php echo $this->render('config/theme/list', array('selected' => $selected, 'list' => $list)); ?>

<?php foreach ($selected->getSlotManager() as $slot) {
    echo $this->getWidget('AdminBundle_Widget_Editor')->setSlot($slot);
} ?>
