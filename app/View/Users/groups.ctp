<?php echo $this->Session->flash(); ?>

<div class="actions" style="width: 100%; display: block">
<?php echo $this->Html->link('Create New Group', array('controller' => 'users', 'action' => 'add_group')) ?>
</div>

<br /><br /><br />

<?php if (!empty($data)): ?>

<?php foreach($data as $group): ?>

<div class="group_name"><?php echo $this->Html->link($group['Group']['title'], array('controller' => 'users', 'action' => 'group', $group['Group']['id']), array('escape' => false)) ?></div>

<div class="group_actions"><?php echo $this->Html->link('Leave Group', array('controller' => 'users', 'action' => 'leave_group', $group['Group']['id']), array('escape' => false), 'Are you sure you want to leave this group?') ?></div>

<?php endforeach ?>

<?php else: ?>

<p>No group yet.</p>

<?php endif ?>