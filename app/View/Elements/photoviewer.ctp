<?php //pr($data) ?>
<div style="float:left; width: 640px; height: 490px">
    <?php echo $this->Html->image('/files/photo/photo/' . $data['Photo']['photo_dir'] . '/vga_' . $data['Photo']['photo'], array('alt' => $data['PhotoAlbum']['User']['full_name'], 'border' => 0)); ?>
</div>

<div style="float:right; width: 300px; margin-left: 10px;">
    <div class="user_thumb_pic" style="float: left;">
        <?php if (!empty($data['PhotoAlbum']['User']['PhotoAlbum']['0']['Photo']['0'])): ?>
            <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $data['PhotoAlbum']['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $data['PhotoAlbum']['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $data['PhotoAlbum']['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($data['PhotoAlbum']['User']['username']) ? $data['PhotoAlbum']['User']['username'] : $data['PhotoAlbum']['User']['id']), array('title' => $data['PhotoAlbum']['User']['full_name'], 'escape' => false, )) ?>
        <?php else: ?>
        <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $data['PhotoAlbum']['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($data['PhotoAlbum']['User']['username']) ? $data['PhotoAlbum']['User']['username'] : $data['PhotoAlbum']['User']['id']), array('escape' => false)) ?>
        <?php endif ?>
    </div>
    <div style="float: left; margin-left: 10px; color: #808000">
        <a href="/users/view/<?php echo $data['PhotoAlbum']['User']['id'] ?>"><?php echo $data['PhotoAlbum']['User']['full_name'] ?></a>
        <br /><sub><?php echo date('M d \'y H:i:s', strtotime($data['Photo']['created'])) ?></sub>
    </div>
    <div class="clear-both">
        <?php if ($data['PhotoAlbum']['User']['id'] == $this->Session->read('Auth.User.id')): ?>
        <a href="#" id="photoDescription" data-type="text" data-pk="<?php echo $data['Photo']['id'] ?>" data-url="/users/edit_photo_description" data-original-title="Enter Photo Description"><?php echo nl2br($data['Photo']['description']) ?></a>
        <?php else: ?>
        <?php echo nl2br($data['Photo']['description']) ?>
        <?php endif ?>
        <?php echo $this->element('likes',array('data' => $data['Photo'],'type'=>'Photo')) ?>
    </div>
</div>