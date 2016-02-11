<?php if ($this->Session->check('Notifications.FriendRequests')): ?>

    <?php $newFriends = $this->Session->read('Notifications.FriendRequests') ?>

    <?php if (!empty($newFriends)): ?>

        <?php foreach($newFriends as $user): ?>
    
        <div class="user_search_details">
            <div class="user_thumb_pic">
            <?php if (!empty($user['PhotoAlbum']['0']['Photo']['0'])): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $user['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $user['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => '', 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('title' => $user['User']['full_name'], 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $user['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?>
            <?php endif ?>
            </div>
            
            <div class="user_search_info">
                <div class="user_brief_details"><?php echo $this->Html->link($user['User']['full_name'], array('controller' => 'users', 'action' => 'view', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?></div>
                <div class="user_brief_details"><sub><?php echo $this->Html->link('Send a message', array('controller' => 'users', 'action' => 'compose', !empty($user['User']['username']) ? $user['User']['username'] : $user['User']['id']), array('escape' => false)) ?></sub></div>
                <div class="user_brief_details actions">
                    <?php echo $this->Html->link('Accept', array('controller' => 'users', 'action' => 'accept_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request_2')) ?> or
                    <?php echo $this->Html->link('Decline', array('controller' => 'users', 'action' => 'decline_friend_request', $user['User']['id']), array('rel' => $user['User']['id'],'escape' => false, 'class' => 'btn_friend_request_2')) ?>
                </div>
            </div>
            
        </div>
    
        <?php endforeach ?>
    
    <?php else: ?>

        <p>No friend request.</p>
    
    <?php endif ?>
    
<?php else: ?>

    <p>No friend request.</p>

<?php endif ?>