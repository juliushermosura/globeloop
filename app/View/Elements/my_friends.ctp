<div class="graybar">

    <div class="friendstitle">Friends</div>
    
    <div class="filter"><input type="text" placeholder="Search Your Friends" /></div>

</div>

<div class="friendslist">

<?php if (empty($data)): ?>

<p>No friend yet.</p>

<?php else: ?>
    <?php //pr($data) ?>
    <?php foreach($data as $user): ?>
    
    <div class="friend_details" style="width: 280px">
        
        <div class="user_thumb_pic" style="margin-bottom: 0">
            <?php if (!empty($user['UserTo']['PhotoAlbum']['0']['Photo'])): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $user['UserTo']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $user['UserTo']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => '', 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('title' => 'Change Primary Photo', 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $user['UserTo']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('escape' => false)) ?>
            <?php endif ?>
        </div>
        
        <div class="user_search_info" style="margin-bottom: 0">
            <div class="user_brief_details"><?php echo $this->Html->link($user['UserTo']['full_name'], array('controller' => 'users', 'action' => 'view', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('escape' => false)) ?></div>
            <div class="user_brief_details" style="margin-bottom: 0">
                <sub>
                    <?php echo $this->Html->link('Send message', array('controller' => 'users', 'action' => 'compose', !empty($user['UserTo']['username']) ? $user['UserTo']['username'] : $user['UserTo']['id']), array('escape' => false)) ?> | 
                    <?php echo $this->Html->link('Remove', array('controller' => 'users', 'action' => 'remove_friend', $user['UserTo']['id']), array('escape' => false), 'You are about to unfriend this person.') ?>
                </sub>
            </div>
        </div>
        
        <div class="actions" style="margin-bottom: 0; font-size: 11px;">
            <a class="add_remove_selections <?php echo ($user['FriendFrom']['selection'] == 1) ? '' : 'add' ?>" title="Add to Selections" href="#add_remove_selections" id="friend-<?php echo $user['UserTo']['id'] ?>"><span class="selectionMarker" style="font-weight: bold; font-size: 19.5px; vertical-align: sub"><?php echo ($user['FriendFrom']['selection'] == 1) ? '-' : '+' ?></span> | Selections</a>
        </div>
    </div>

    <?php endforeach ?>
        
<?php endif ?>

</div>
