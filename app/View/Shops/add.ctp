<?php echo $this->Form->create('Deal', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Add your deals/promos/ads here'); ?></legend>
    <?php echo $this->Form->input('place_id', array('options' => $places, 'empty' => 'Select here...')); ?>
    <?php echo $this->Form->input('title'); ?>
    <?php echo $this->Form->input('description'); ?>
    <?php echo $this->Form->input('price'); ?>
    <?php echo $this->Form->input('original_price'); ?>
    <?php echo $this->Form->input('link', array('placeholder' => 'http://')); ?>
    <?php echo $this->Form->input('exclusive'); ?>
    <?php echo $this->Form->input('installment'); ?>
    <?php echo $this->Form->input('category_id', array('options' => $categories)); ?>
    <?php echo $this->Form->input('publish_on'); ?>
    <?php echo $this->Form->input('publish_until'); ?>
    <?php echo $this->Form->input('photo', array('type' => 'file')); ?>
    <?php echo $this->Form->input('photo_dir', array('type' => 'hidden')); ?>
    </fieldset>
    
<?php echo $this->Form->end('Save and Preview'); ?>
