<div class="users">

<?php echo $this->Session->flash('signup'); ?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'signup'))); ?>
    <fieldset>
        <legend><?php echo __('Sign up'); ?></legend>
        <?php
	echo $this->Form->input('username', array('style' => 'width:70%', 'after' => ' @ ' . $this->Form->input('domain_name', array('div' => false, 'label' => false, 'options' => array('globeloop.com' => 'globeloop.com', 'globeloop.com.ph' => 'globeloop.com.ph')))));
	echo $this->Form->input('first_name');
	echo $this->Form->input('last_name');
	$attributes=array('legend'=>false);
	$options=array('M'=>'Male','F'=>'Female');
	echo $this->Form->radio('gender',$options,$attributes);
	echo $this->Form->input('birthdate', array('minYear' => date('Y') - 18, 'maxYear' => date('Y') - 70));
	echo $this->Form->input('email_address');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Sign up')); ?>


</div>