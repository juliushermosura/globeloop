<div class="graybar">

    <div class="friendstitle">Friends</div>
    
    <div class="filter"><input type="text" placeholder="Search Your Friends" /></div>

</div>

<div class="friendslist">

<?php if (empty($friends)): ?>

<p>No friend yet.</p>

<?php else: ?>
    
    <?php foreach($friends as $user): ?>
    
    <div class="friend_details btn">
        
        <div class="user_thumb_pic">
            <?php if (!empty($user['UserTo']['PhotoAlbum'])): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $user['UserTo']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $user['UserTo']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => '', 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('title' => 'Change Primary Photo', 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $user['UserTo']['first_name'] . ' ' . $user['UserTo']['last_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('escape' => false)) ?>
            <?php endif ?>
        </div>
        
        <div class="user_search_info">
            <div class="user_brief_details"><?php echo $this->Html->link($user['UserTo']['first_name'] . ' ' . $user['UserTo']['last_name'], array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('escape' => false)) ?></div>
        </div>
        
        <input type="checkbox" class="hide check" name="selectedFriend[]" value="<?php echo $user['UserTo']['id'] ?>" />
        
    </div>

    <?php endforeach ?>
        
<?php endif ?>

</div>
