<?php if ($this->Session->read('Auth.User')): ?>

<?php
    $username = $this->Session->read('Auth.User.username');
    $id = $this->Session->read('Auth.User.id');
    $user = !empty($username) ? $username : $id;
?>

<div id="rightsidebar">
    <li>
        <div id="primary_photo">
            <?php if ($this->Session->check('Essentials.Photo.Photo.0')): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $this->Session->read('Essentials.Photo.Photo.0.photo_dir') . '/small_' . $this->Session->read('Essentials.Photo.Photo.0.photo'), array('alt' => $this->Session->read('Auth.User.full_name'), 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'photo_album', $this->Session->read('Essentials.Photo.id')), array('title' => 'Change Primary Photo', 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => 'Upload your photo', 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'photo_album', $this->Session->read('Essentials.Photo.id')), array('title' => 'Upload Primary Photo', 'escape' => false, )) ?>
            <?php endif ?>
        </div>
    </li>
    <li class="indent"><?php echo $this->Html->link('Profile', '/u/' . $user, array('class' => 'bluetext', 'escape' => false)) ?></li>
    <li class="indent"><?php echo $this->Html->link('Edit Profile', array('controller' => 'users', 'action' => 'profile'), array('class' => 'bluetext', 'escape' => false)) ?></li>
    <li class="indent"><?php echo $this->Html->link('Settings', array('controller' => 'users', 'action' => 'settings'), array('class' => 'bluetext', 'escape' => false)) ?></li>
    <li class="indent"><?php echo $this->Html->link('Calendar', array('controller' => 'users', 'action' => 'calendar'), array('class' => 'bluetext', 'escape' => false)) ?></li>
    <li>
        <ul id="mail">
            <li><?php echo $this->Html->link('New Mail', array('controller' => 'users', 'action' => 'compose'), array('escape' => false)) ?></li>
            <?php if ($this->Session->check('Notifications.UnreadMails')): ?>
                <?php if ($this->Session->read('Notifications.UnreadMails') > 0): ?>
            <li><?php echo $this->Html->link('Inbox <span class="encloser">(<span class="unreadCount">' . $this->Session->read('Notifications.UnreadMails') . '</span>)</span>', array('controller' => 'users', 'action' => 'inbox'), array('escape' => false)) ?></li>
                <?php else: ?>
            <li><?php echo $this->Html->link('Inbox', array('controller' => 'users', 'action' => 'inbox'), array('escape' => false)) ?></li>
                <?php endif ?>
            <?php else: ?>
            <li><?php echo $this->Html->link('Inbox', array('controller' => 'users', 'action' => 'inbox'), array('escape' => false)) ?></li>
            <?php endif ?>
            <li><?php echo $this->Html->link('Sent', array('controller' => 'users', 'action' => 'sent'), array('escape' => false)) ?></li>
            <li><?php echo $this->Html->link('Archive', array('controller' => 'users', 'action' => 'archive'), array('escape' => false)) ?></li>
            <li><?php echo $this->Html->link('Drafts', array('controller' => 'users', 'action' => 'drafts'), array('escape' => false)) ?></li>
        </ul>
    </li>
    <li>
        <ul id="chat">
            <div class="filter" style="width: auto; margin-right: -4px"><input type="text" style="width: 152px; height: 12px;" placeholder="Search Your Friends"></div>
            <div id="online_viewPort">
                <div class="online_canvas">
                
                </div>
            </div>
        </ul>
    </li>
    
    <br style="clear: both">
</div>
<?php endif ?>