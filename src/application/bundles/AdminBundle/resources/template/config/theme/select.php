<?php echo $this->render('config/theme/list', array('selected' => $selected, 'list' => $list)); ?>

<?php foreach ($selected->getSlotManager() as $slot) {
    echo new AdminBundle_Widget_Editor($slot);
} ?>
