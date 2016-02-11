<?php echo $this->Html->scriptBlock("
$(document).ready(function() {

    var dockOptions = { align: 'left', left: '50px' };
    $('#links').jqDock(dockOptions);
    
});
") ?>

<div id="menu">
    <img src="/img/btn-dock.png" />
</div>


<div id="leftsidebar">
    <div id="links">
        <li><?php echo $this->Html->link($this->Html->image('horizon.png', array('border' => 0, 'alt' => 'Groups', 'width' => '64', 'height' => '64')), array('controller' => 'professionals', 'action' => 'groups'), array('title' => 'Featured Deals', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('photos.png', array('border' => 0, 'alt' => 'Forums', 'width' => '64', 'height' => '64')), array('controller' => 'professionals', 'action' => 'forums'), array('title' => 'Todays Deals', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('selections.png', array('border' => 0, 'alt' => 'Associations', 'width' => '64', 'height' => '64')), array('controller' => 'professionals', 'action' => 'associations'), array('title' => 'Products', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('videos.png', array('border' => 0, 'alt' => 'References', 'width' => '64', 'height' => '64')), array('controller' => 'professionals', 'action' => 'references'), array('title' => 'Escapes', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('friends.png', array('border' => 0, 'alt' => 'Professional Help', 'width' => '64', 'height' => '64')), array('controller' => 'professionals', 'action' => 'professional_help'), array('title' => 'Escapes', 'escape' => false)) ?></li>
        <br style="clear: both">
    </div>
</div>
    
