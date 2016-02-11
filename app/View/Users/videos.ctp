<?php echo $this->Session->flash(); ?>

<div class="actions" style="width: 100%; display: block">
<?php echo $this->Html->link('Add New Album', array('controller' => 'users', 'action' => 'add_video_album')) ?>
</div>

<br /><br /><br />

<?php if (!empty($data)): ?>

<div class="albumPage">

<?php foreach($data as $album): ?>

    <div class="album_details">
        <?php if (isset($album['Video']['0']['video'])) $filename = pathinfo($album['Video']['0']['video']) ?>
        <div class="album_cover"><?php echo $this->Html->link(!empty($album['Video']) ? $this->Html->image('/files/video/video/' . $album['Video']['0']['video_dir'] . '/' . $filename['filename'] . '.jpg', array('alt' => $album['Video']['0']['title'], 'border' => 0, 'width' => '150', 'height' => '150')) : $this->Html->image('photoplaceholder.png', array('alt' => 'Upload your video', 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'video_album', $album['VideoAlbum']['id']), array('escape' => false)) ?></div>
        <div class="album_title"><?php echo $this->Html->link($album['VideoAlbum']['title'], array('controller' => 'users', 'action' => 'video_album', $album['VideoAlbum']['id']), array('escape' => false)) ?></div>
        <div class="album_title"><sub><?php echo !empty($album['Video']) ? (count($album['Video']) > 1) ? count($album['Video']) . ' videos' : count($album['Video']) . ' video' : 'Empty' ?></sub></div>
    </div>

<?php endforeach ?>

</div>

<?php else: ?>

<p>No album yet.</p>

<?php endif ?>