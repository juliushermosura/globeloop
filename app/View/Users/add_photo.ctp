<div class="users">

    <div class="actions">
        <?php echo $this->Html->link('Back to Album', array('controller' => 'users', 'action' => 'photo_album', $this->params['pass']['0'])) ?> 
    </div>
    
    <?php echo $this->Form->create('Photo', array('type' => 'file')); ?>
        <fieldset>
            <legend><?php echo __('Please enter the name for your group'); ?></legend>
        <?php echo $this->Form->input('Photo.photo', array('type' => 'file')); ?>
        <?php echo $this->Form->input('Photo.description'); ?>
        <?php echo $this->Form->input('Photo.photo_dir', array('type' => 'hidden')); ?>
        </fieldset>
        
    <?php echo $this->Form->end('Upload'); ?>

</div>