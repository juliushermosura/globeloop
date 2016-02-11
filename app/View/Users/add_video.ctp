<div class="users">

    <div class="actions">
        <?php echo $this->Html->link('Back to Album', array('controller' => 'users', 'action' => 'video_album', $this->params['pass']['0'])) ?> 
    </div>
    
    <?php echo $this->Form->create('Video', array('type' => 'file')); ?>
        <fieldset>
            <legend><?php echo __('Please enter the name for your group'); ?></legend>
        <?php echo $this->Form->input('Video.video', array('type' => 'file')); ?>
        <?php echo $this->Form->input('Video.video_dir', array('type' => 'hidden')); ?>
        </fieldset>
        
    <?php echo $this->Form->end('Upload'); ?>

</div>