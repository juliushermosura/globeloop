<?php

$ctr = 0;
//pr($data);
?>

<style>
#content {
    width: auto;
    display: block;
    padding-top: 20px;
}
#contentarea {
    margin-top: 0px;
}
</style>

<div id="profile">
    <div class="user_thumb_pic">
        <?php if (!empty($data['PhotoAlbum']['0']['Photo'])): ?>
            <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $data['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/vga_' . $data['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $data['User']['full_name'], 'border' => 0, 'width' => '300')), array('controller' => 'users', 'action' => 'view', !empty($data['User']['username']) ? $data['User']['username'] : $data['User']['id']), array('title' => $data['User']['full_name'], 'escape' => false, )) ?>
        <?php else: ?>
        <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $data['User']['full_name'], 'border' => 0, 'width' => '306')), array('controller' => 'users', 'action' => 'view', !empty($data['User']['username']) ? $data['User']['username'] : $data['User']['id']), array('escape' => false)) ?>
        <?php endif ?>
    </div>
    
    <div>
        <li><a href="#photos" class="photos">View Photos</a></li>
        <li><a href="#videos" class="videos">View Videos</a></li>
    </div>
    
    <div class="user_details">
        <h4>Birthday</h4>
        <?php echo date('F d', strtotime($data['User']['birthdate'])) ?>
    </div>
    
    <div class="user_details">
    <h4>Friends</h4>
    <?php //echo $this->element('my_friends') ?>
    </div>
    
</div>

<div id="title"><h3><?php echo $data['User']['full_name'] ?></h3></div>

<div id="contentarea">
    
    <div class="graybar" style="margin-bottom: 30px;">
        <form>
            <?php
            echo $this->Form->input('parent_id', array('id' => 'parent_id', 'type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
            echo $this->Form->input('parent_model_name', array('type'=>'hidden','value'=>'Horizon'));
            echo $this->Form->textarea('content',array('id'=>'postContent','div'=>'false','class'=>'small','label'=>false, 'placeholder' => 'Post something here'));
            ?>
        
            <div class="submit"><input type="submit" id="postForm" value="Post" /></div>
        </form>
    </div>
    
    <div class="newsfeed_canvas">
<?php //pr($feeds) ?>
    <?php foreach ($feeds as $feed): ?>
    
    <?php
    
    switch ($feed['NewsFeed']['parent_model_name']) {
        case 'HorizonPost':
            ?>
            <div class="newsfeed_entry">
                <div class="user_thumb_pic">
                    <?php if (!empty($feed['User']['PhotoAlbum']['0']['Photo'])): ?>
                        <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('title' => $feed['User']['full_name'], 'escape' => false, )) ?>
                    <?php else: ?>
                    <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('escape' => false)) ?>
                    <?php endif ?>
                </div>
                <div class="newsfeed_details">
                    <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a>
                    <?php if ($feed['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                    <div style="float: right"><sub><?php echo $this->Html->link('<span class="ui-icon ui-icon-close"></span>', '#remove_post', array('escape' => false, 'title' => 'Remove Post', 'class' => 'remove_post', 'rel' => 'post-' . $feed['NewsFeed']['id'])) ?></sub></div>
                    <?php endif ?>
                    <div style="margin-top: 5px;"><?php echo nl2br($feed['HorizonPost']['content']) ?></div>
                    <?php echo $this->element('likes',array('data' => $feed['HorizonPost'],'type'=>'Post')) ?>
                    <?php echo $this->element('comments',array('data' => $feed,'type'=>'HorizonPost')) ?> 
                </div>
            </div>
            <?php
            break;
        case 'OtherPhoto':
        ?>
                <div class="newsfeed_entry">
                    <div class="user_thumb_pic">
                        <?php if (!empty($feed['User']['PhotoAlbum']['0']['Photo'])): ?>
                            <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('title' => $feed['User']['full_name'], 'escape' => false, )) ?>
                        <?php else: ?>
                        <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('escape' => false)) ?>
                        <?php endif ?>
                    </div>
                    <div class="newsfeed_details">
                        <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a> added <?php if (count($feed['OtherPhoto']['PhotoAlbum2']['Photo']) > 1) {
                            echo '<a href="/users/photo_album/' .$feed['OtherPhoto']['PhotoAlbum2']['id']. '">' . count($feed['OtherPhoto']['PhotoAlbum2']['Photo']) . ' new photos</a>';
                        } else {
                            echo 'a new photo';
                        } ?>.
                        <div style="margin-top: 5px; width: 580px">
                        <?php foreach($feed['OtherPhoto']['PhotoAlbum2']['Photo'] as $p): ?>
                            <?php if (($ctr) == 7) break; ?>
                                <?php if (count($feed['OtherPhoto']['PhotoAlbum2']['Photo']) == 1): ?>
                        <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $p['photo_dir'] . '/vga_' . $p['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '585')), '/files/photo/photo/' . $p['photo_dir'] . '/vga_' . $p['photo'], array('escape' => false, 'class' => 'gallery')) ?>
                                    <?php break ?>
                                <?php endif ?>
                        <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $p['photo_dir'] . '/small_' . $p['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, )), '/files/photo/photo/' . $p['photo_dir'] . '/vga_' . $p['photo'], array('escape' => false, 'class' => 'gallery')) ?>
                            <?php $ctr++ ?>
                        <?php endforeach ?>
                        </div>
                        <?php if (count($feed['OtherPhoto']['PhotoAlbum2']['Photo']) > 1): ?>
                        <?php echo $this->element('likes',array('data' => $feed['OtherPhoto']['PhotoAlbum2'],'type'=>'PhotoAlbum')) ?>
                        <?php else: ?>
                        <?php echo $this->element('likes',array('data' => $feed['OtherPhoto'],'type'=>'Photo')) ?>
                        <?php endif ?>
                    </div>
                </div>
            <?php
            break;
            
        default:
    }
    
    ?>
    
    <?php endforeach ?>
    
    
    </div>
</div>
