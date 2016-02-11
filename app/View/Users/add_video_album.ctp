<div class="users">

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('VideoAlbum', array('url' => array('controller' => 'users', 'action' => 'add_video_album'))) ?>
    <fieldset>
        <legend><?php echo __('Please enter the details for your album'); ?></legend>
        <?php echo $this->Form->input('title', array('label' => 'Album Name')) ?>
        <?php echo $this->Form->input('description', array('label' => 'Description', 'type' => 'textarea')) ?>
    </fieldset>

<?php echo $this->Form->submit('Save', array('after' => ' ' . $this->Html->link('Cancel', array('controller' => 'users', 'action' => 'videos')))) ?>

<?php echo $this->Form->end() ?>

</div>