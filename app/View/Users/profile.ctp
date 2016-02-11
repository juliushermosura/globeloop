<div class="users">

<?php echo $this->Session->flash('user'); ?>

<?php if ($this->data['User']['username_updated'] <= 1): ?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'profile'))); ?>
<?php endif ?>

    <fieldset>
        <legend><?php echo ($this->data['User']['username_updated'] == 0) ? __('Add Username') : __('Update Username') ; ?></legend>
        <?php
        if ($this->data['User']['username_updated'] <= 1)
        echo $this->Form->input('username', array('style' => 'width:70%', 'after' => ' @ ' . $this->Form->input('domain_name', array('div' => false, 'label' => false, 'options' => array('globeloop.com' => 'globeloop.com', 'globeloop.com.ph' => 'globeloop.com.ph')))));
        else
        echo $this->Form->input('username', array('value' => $this->data['User']['username'] . '@' . $this->data['User']['domain_name'], 'readonly' => true));
    ?>
    <em>You can only change your username once.</em>
    </fieldset>
    
<?php if ($this->data['User']['username_updated'] <= 1): ?>
<?php echo $this->Form->end(__('Save')); ?>
<?php endif ?>

<hr /><br />


<?php echo $this->Session->flash('name'); ?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'profile'))); ?>
    <fieldset>
        <legend><?php echo __('Update Name'); ?></legend>
        <?php
        echo $this->Form->input('first_name');
	echo $this->Form->input('last_name');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>

<hr /><br />

<?php echo $this->Session->flash('email'); ?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'profile'))); ?>
    <fieldset>
        <legend><?php echo __('Change Email'); ?></legend>
        <?php
        echo $this->Form->input('email_address');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>

<hr /><br />

<?php echo $this->Session->flash('password'); ?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'profile'))); ?>
    <fieldset>
        <legend><?php echo __('Change Password'); ?></legend>
        <?php
        echo $this->Form->input('current_password', array('div' => 'input text required', 'type' => 'password', 'label' => 'Current Password'));
        echo $this->Form->input('new_password', array('div' => 'input text required', 'type' => 'password', 'label' => 'New Password'));
        echo $this->Form->input('confirm_password', array('div' => 'input text required', 'type' => 'password', 'label' => 'Confirm Password'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Save Changes')); ?>

</div>