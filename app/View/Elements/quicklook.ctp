<style>
.user_search_details {
    width: 650px;
    padding: 10px;
    margin: 10px;
}
</style>
<div class="user_search_details">
    <div class="user_thumb_pic">
        <?php if (!empty($user['PhotoAlbum'])): ?>
            <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $user['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $user['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => '', 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('title' => $user['User']['full_name'], 'escape' => false, )) ?>
        <?php else: ?>
        <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $user['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?>
        <?php endif ?>
    </div>
    <?php
        $sent = false;
        $approved = false;
        $selection = false;
        foreach ($user['FriendTo'] as $friend) {
            if ($friend['user_from'] == $this->Session->read('Auth.User.id')) {
                $sent = true;
                if ($friend['status'] == 1) {
                    $approved = true;
                } else {
                    $approved = false;
                }
                break;
            }
        }
        foreach ($user['FriendFrom'] as $friend) {
            if ($friend['user_to'] == $this->Session->read('Auth.User.id')) {
                if ($friend['selection'] == 1) {
                    $selection = true;
                } else {
                    $selection = false;
                }
                break;
            }
        }
    ?>
    <div class="user_search_info">
        <div class="user_brief_details"><?php echo $this->Html->link($user['User']['full_name'], array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?></div>
        <div class="user_brief_details">
            <sub>
                <?php echo $this->Html->link('Send a message', array('controller' => 'users', 'action' => 'compose', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?>
                <?php if ($sent && $approved): ?>
                 | 
                <?php echo $this->Html->link('Remove', array('controller' => 'users', 'action' => 'remove_friend', $user['User']['id']), array('escape' => false), 'You are about to unfriend this person.') ?>
                <?php endif ?>
            </sub>
        </div>
        <?php if ($sent): ?>
            <?php if (!$approved): ?>
        <div class="user_brief_details actions btn_disabled"><?php echo $this->Html->link('Sent friend request', array('controller' => 'users', 'action' => 'send_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request')) ?></div>
            <?php endif ?>
        <?php else: ?>
        <div class="user_brief_details actions"><?php echo $this->Html->link('Add friend', array('controller' => 'users', 'action' => 'send_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request')) ?></div>
        <?php endif ?>
        
        <?php if ($approved): ?>
        <div class="actions" style="margin-bottom: 0; font-size: 11px;">
            <a class="add_remove_selections <?php echo ($selection == true) ? '' : 'add' ?>" title="Add to Selections" href="#add_remove_selections" id="friend-<?php echo $user['User']['id'] ?>"><span class="selectionMarker" style="font-weight: bold; font-size: 19.5px; vertical-align: sub"><?php echo ($selection == true) ? '-' : '+' ?></span> | Selections</a>
        </div>
        <?php endif ?>
    </div>
</div>