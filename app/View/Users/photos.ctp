<?php echo $this->Session->flash(); ?>

<div class="actions" style="width: 100%; display: block">
<?php echo $this->Html->link('Add New Album', array('controller' => 'users', 'action' => 'add_photo_album')) ?>
</div>

<br /><br /><br />

<?php if (!empty($data)): ?>

<div class="albumPage">

<?php foreach($data as $album): ?>

    <div class="album_details">
        <div class="album_cover"><?php echo $this->Html->link(!empty($album['Photo']) ? $this->Html->image('/files/photo/photo/' . $album['Photo']['0']['photo_dir'] . '/small_' . $album['Photo']['0']['photo'], array('alt' => $album['Photo']['0']['title'], 'border' => 0, 'width' => '150', 'height' => '150')) : $this->Html->image('photoplaceholder.png', array('alt' => 'Upload your photo', 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'photo_album', $album['PhotoAlbum']['id']), array('escape' => false)) ?></div>
        <div class="album_title"><?php echo $this->Html->link($album['PhotoAlbum']['title'], array('controller' => 'users', 'action' => 'photo_album', $album['PhotoAlbum']['id']), array('escape' => false)) ?></div>
        <div class="album_title"><sub><?php echo !empty($album['Photo']) ? (count($album['Photo']) > 1) ? count($album['Photo']) . ' photos' : count($album['Photo']) . ' photo' : 'Empty' ?></sub></div>
    </div>

<?php endforeach ?>

</div>

<?php else: ?>

<p>No album yet.</p>

<?php endif ?>