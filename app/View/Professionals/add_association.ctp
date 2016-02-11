<?php echo $this->Html->script('jquery.selectable.min'); ?>
<?php echo $this->Html->scriptBlock(
  "$(function() {
        $('#AssociationAddAssociationForm .btn').selectable({
            'class': 'btn-info',
            onChange: function() {
                $('#AssociationAddAssociationForm-serialized').html( decodeURIComponent($('#AssociationAddAssociationForm input:checkbox.check').serialize()) );
            }
        });
    });"
);
?>

<div class="users">

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Association', array('url' => array('controller' => 'professionals', 'action' => 'add_association'))) ?>
    <fieldset>
        <legend><?php echo __('Please enter the name for your Association'); ?></legend>
        <?php echo $this->Form->input('title', array('label' => 'Association Name')) ?>
    </fieldset>

    <fieldset>
        <legend><?php echo __('Invite your association members'); ?></legend>
        <?php echo $this->element('select_friends') ?>
    </fieldset>

    <?php echo $this->Form->textarea('selected_friends', array('id' => 'GroupAddGroupForm-serialized', 'class' => 'hide')); ?>

<?php echo $this->Form->submit('Save', array('after' => ' ' . $this->Html->link('Cancel', array('controller' => 'professionals', 'action' => 'associations')))) ?>

<?php echo $this->Form->end() ?>

</div>