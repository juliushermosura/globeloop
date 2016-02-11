<?php if ($this->Session->read('Auth.User')): ?>
<?php //echo $this->Html->css("style_light.css") ?>
<?php //echo $this->Html->script("jquery-ui-1.10.3.custom.min") ?>

<?php echo $this->Html->scriptBlock("
$(document).ready(function() {

    var dockOptions = { align: 'left', labels: true, size: 48, permanentLabels: true };

    $('#links').jqDock(dockOptions);
    
});
") ?>

<div id="menu">
    <img src="/img/btn-dock.png" />
</div>

<div id="leftsidebar">
    <div id="links">
        <li id="horizonMenu">
            <?php echo $this->Html->link($this->Html->image('horizon.png', array('border' => 0, 'alt' => 'Horizon', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'horizon'), array('title' => 'Horizon', 'escape' => false)) ?>
            <?php echo $this->Html->link('Horizon', array('controller' => 'users', 'action' => 'horizon'), array('title' => 'Horizon', 'escape' => false)) ?>
        </li>
        <li id="friendsMenu">
            <?php echo $this->Html->link($this->Html->image('friends.png', array('border' => 0, 'alt' => 'Friends', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'friends'), array('title' => 'Friends', 'escape' => false)) ?>
            <?php echo $this->Html->link('Friends', array('controller' => 'users', 'action' => 'friends'), array('title' => 'Friends', 'escape' => false)) ?>
        </li>
        <li id="groupsMenu">
            <?php echo $this->Html->link($this->Html->image('network.png', array('border' => 0, 'alt' => 'Groups', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'groups'), array('title' => 'Groups', 'escape' => false)) ?>
            <?php echo $this->Html->link('Groups', array('controller' => 'users', 'action' => 'groups'), array('title' => 'Groups', 'escape' => false)) ?>
        </li>
        <li id="photosMenu">
            <?php echo $this->Html->link($this->Html->image('photos.png', array('border' => 0, 'alt' => 'Photos', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'photos'), array('title' => 'Photos', 'escape' => false)) ?>
            <?php echo $this->Html->link('Photos', array('controller' => 'users', 'action' => 'photos'), array('title' => 'Photos', 'escape' => false)) ?>
        </li>
        <li id="videosMenu">
            <?php echo $this->Html->link($this->Html->image('videos.png', array('border' => 0, 'alt' => 'Videos', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'videos'), array('title' => 'Videos', 'escape' => false)) ?>
            <?php echo $this->Html->link('Videos', array('controller' => 'users', 'action' => 'videos'), array('title' => 'Videos', 'escape' => false)) ?>
        </li>
        <li id="selectionMenu">
            <?php echo $this->Html->link($this->Html->image('selections.png', array('border' => 0, 'alt' => 'Selections', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'selections'), array('title' => 'Selections', 'escape' => false)) ?>
            <?php echo $this->Html->link('Selections', array('controller' => 'users', 'action' => 'selections'), array('title' => 'Selections', 'escape' => false)) ?>
        </li>
        <br style="clear: both">
        <li style="position: absolute;">
            <?php echo $this->Html->link($this->Html->image('photos.png', array('border' => 0, 'alt' => 'Apps', 'width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'apps'), array('title' => 'Apps', 'escape' => false)) ?>
        </li>
    </div>
</div>
    
<?php endif ?>