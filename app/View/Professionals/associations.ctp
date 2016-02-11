<?php echo $this->Session->flash(); ?>

<div class="actions" style="width: 100%; display: block">
<?php echo $this->Html->link('Create New Association', array('controller' => 'users', 'action' => 'add_association')) ?>
</div>

<br /><br /><br />

<?php if (!empty($data)): ?>

<?php foreach($data as $association): ?>

<div class="association_name"><?php echo $this->Html->link($association['Association']['title'], array('controller' => 'users', 'action' => 'association', $association['Association']['id']), array('escape' => false)) ?></div>

<div class="association_actions"><?php echo $this->Html->link('Leave Association', array('controller' => 'users', 'action' => 'leave_association', $association['Association']['id']), array('escape' => false), 'Are you sure you want to leave this association?') ?></div>

<?php endforeach ?>

<?php else: ?>

<p>No group yet.</p>

<?php endif ?>