<?php if ($this->Session->read('Auth.User')): ?>
<div id="footer">
    <li><?php echo $this->Html->link('About Us', array('controller' => 'pages', 'action' => 'display', 'about_us')) ?></li>
    <li><?php echo $this->Html->link('Contact Us', array('controller' => 'pages', 'action' => 'display', 'contact_us')) ?></li>
    <li><?php echo $this->Html->link('Terms of Use', array('controller' => 'pages', 'action' => 'display', 'terms_of_use')) ?></li>
    <li><?php echo $this->Html->link('Privacy Policy', array('controller' => 'pages', 'action' => 'display', 'privacy_policy')) ?></li>
    <li><?php echo $this->Html->link('Site Map', array('controller' => 'pages', 'action' => 'display', 'site_map')) ?></li>
    <li>&copy; 2012-2014 Gloobloop.com &bull; All Rights Reserved.</li>
    <?php if ($this->params['controller'] == 'users'): ?>
    <script type="text/javascript" src="/app/webroot/arrowchat/external.php?type=djs" charset="utf-8"></script>
    <script type="text/javascript" src="/app/webroot/arrowchat/external.php?type=js" charset="utf-8"></script>
    <?php endif ?>
</div>
<?php endif ?>