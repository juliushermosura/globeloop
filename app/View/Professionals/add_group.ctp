<?php echo $this->Html->script('jquery.selectable.min'); ?>
<?php echo $this->Html->scriptBlock(
  "$(function() {
        $('#GroupAddGroupForm .btn').selectable({
            'class': 'btn-info',
            onChange: function() {
                $('#GroupAddGroupForm-serialized').html( decodeURIComponent($('#GroupAddGroupForm input:checkbox.check').serialize()) );
            }
        });
    });"
);
?>

<div class="users">

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Group', array('url' => array('controller' => 'professionals', 'action' => 'add_group'))) ?>
    <fieldset>
        <legend><?php echo __('Please enter the name for your group'); ?></legend>
        <?php echo $this->Form->input('title', array('label' => 'Group Name')) ?>
    </fieldset>

    <fieldset>
        <legend><?php echo __('Select your group members'); ?></legend>
        <?php echo $this->element('select_friends') ?>
    </fieldset>

    <?php echo $this->Form->textarea('selected_friends', array('id' => 'GroupAddGroupForm-serialized', 'class' => 'hide')); ?>

<?php echo $this->Form->submit('Save', array('after' => ' ' . $this->Html->link('Cancel', array('controller' => 'professionals', 'action' => 'groups')))) ?>

<?php echo $this->Form->end() ?>

</div>