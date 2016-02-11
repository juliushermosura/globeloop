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
        <li><?php echo $this->Html->link($this->Html->image('horizon.png', array('border' => 0, 'alt' => 'Featured Deals', 'width' => '64', 'height' => '64')), array('controller' => 'shops', 'action' => 'featured_deals'), array('title' => 'Featured Deals', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('photos.png', array('border' => 0, 'alt' => 'Today\'s Deals', 'width' => '64', 'height' => '64')), array('controller' => 'shops', 'action' => 'todays_deals'), array('title' => 'Todays Deals', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('selections.png', array('border' => 0, 'alt' => 'Products', 'width' => '64', 'height' => '64')), array('controller' => 'shops', 'action' => 'products'), array('title' => 'Products', 'escape' => false)) ?></li>
        <li><?php echo $this->Html->link($this->Html->image('videos.png', array('border' => 0, 'alt' => 'Travel', 'width' => '64', 'height' => '64')), array('controller' => 'shops', 'action' => 'travel'), array('title' => 'Escapes', 'escape' => false)) ?></li>
        <br style="clear: both">
    </div>
</div>
    
