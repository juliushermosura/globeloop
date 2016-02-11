<div class="users">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your email address'); ?></legend>
        <?php echo $this->Form->input('email_address'); ?>
    </fieldset>
<?php echo $this->Form->end(__('Reset Password')); ?>

<?php echo $this->Html->link('Return to Login', array('controller' => 'users', 'action' => 'login')) ?>

</div>