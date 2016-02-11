<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
    
    var dockOptions = { align: 'top', labels: 'bc', size: 48, permanentLabels: true };
    
    $('#mainNavMenu').jqDock(dockOptions);

});
") ?>

<div id="mainNavMenu">
    <li style="width: 100px">
        <center><a href="/users/" title="Home"><img src="/img/horizon-home.png" border="0" /></a></center>
        <center><a href="/users/" title="Home">HOME</a></center>
    </li>
    <li style="width: 100px">
        <center><a href="/shopping/" title="Shopping"><img src="/img/shopping-bag.png" border="0" /></a></center>
        <center><a href="/shopping/" title="Shopping">SHOPPING</a></center>
    </li>
    <li style="width: 100px">
        <center><a href="/professionals/" title="Professional"><img src="/img/professionals.png" border="0" /></a></center>
        <center><a href="/professionals/" title="Professional">PROFESSIONALS</a></center>
    </li>
    <li style="width: 100px">
        <center><a href="/directories/" title="Yellow Pages"><img src="/img/yellow-pages.png" border="0" /></a></center>
        <center><a href="/directories/" title="Yellow Pages">YELLOW PAGES</a></center>
    </li>
</div>