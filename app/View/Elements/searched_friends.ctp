<div class="friendslist">

<?php if (is_null($data)): ?>

<p>No result.</p>

<?php else: ?>

    <?php foreach($data as $user): ?>
    
    <div class="user_search_details">
        
        <div class="user_thumb_pic">
            <?php if (!empty($user['PhotoAlbum']['0']['Photo']['0'])): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $user['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $user['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => '', 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('title' => $user['User']['full_name'], 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $user['User']['first_name'] . ' ' . $user['User']['last_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?>
            <?php endif ?>
        </div>
        
        <div class="user_search_info">
            <div class="user_brief_details"><?php echo $this->Html->link($user['User']['full_name'], array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?></div>
            <div class="user_brief_details"><sub><?php echo $this->Html->link('Send a message', array('controller' => 'users', 'action' => 'compose', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?></sub></div>
            <?php
            $sent = false;
            $approved = false;
            foreach ($data as $friendRequest) {
                foreach ($friendRequest['FriendTo'] as $friend) {
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
            }
            ?>
            <?php if ($sent): ?>
                <?php if (!$approved): ?>
            <div class="user_brief_details actions btn_disabled"><?php echo $this->Html->link('Sent friend request', array('controller' => 'users', 'action' => 'send_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request')) ?></div>
                <?php endif ?>
            <?php else: ?>
            <div class="user_brief_details actions"><?php echo $this->Html->link('Add friend', array('controller' => 'users', 'action' => 'send_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request')) ?></div>
            <?php endif ?>
        </div>
        
    </div>

    <?php endforeach ?>
        
<?php endif ?>

</div>
