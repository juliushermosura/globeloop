<?php if ($this->Session->read('Auth.User')): ?>
<div id="headerbar">

    <div style="float: right;">
        <?php
            $username = $this->Session->read('Auth.User.username');
            $id = $this->Session->read('Auth.User.id');
            $user = !empty($username) ? $username : $id;
        ?>
        <li><?php echo $this->Html->link($this->Session->read('Auth.User.first_name') . ' ' . $this->Session->read('Auth.User.last_name') . ' is on the loop', '/u/' . $user, array('title' => 'Public Profile')) ?> | <?php echo $this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout'), array('escape' => false)) ?></li>
        <li>
            <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'search'))); ?>
            <?php echo $this->Form->input('globalsearch', array('id' => 'globalsearch', 'label' => false, 'div' => false, 'class' => 'greeninput', 'placeholder' => 'search')) ?>
            <?php echo $this->Form->end() ?>
        </li>
    </div>
</div>

<?php endif ?>