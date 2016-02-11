<?php echo $this->Html->css("ui-lightness/jquery-ui-1.10.3.custom.min") ?>
<?php echo $this->Html->css('colorbox') ?>

<?php echo $this->Html->script('jquery.colorbox-min') ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        
        $('a.gallery').colorbox({rel: 'gal'});
        
    });
                                    ") ?>

<?php echo $this->Session->flash(); ?>

<h2><?php echo $data['PhotoAlbum']['title'] ?></h2>

<h4><?php echo $data['PhotoAlbum']['description'] ?></h4>

<div class="actions">
    <?php echo $this->Html->link('Back to Albums', array('controller' => 'users', 'action' => 'photos')) ?> 
</div>

<br /><br /><br />

<?php if (!empty($data['Photo'])): ?>

<div class="photoPage">

<?php foreach($data['Photo'] as $photo): ?>

    <div class="photo_details btn" id="photo-<?php echo htmlentities($photo['id']) ?>">
        <div class="photo_image"><?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $photo['photo_dir'] . '/small_' . $photo['photo'], array('alt' => $photo['title'], 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'photoviewer', $photo['id']), array('escape' => false, 'rel' => 'gal', 'class' => 'gallery', 'title' => $photo['title'])) ?></div>
        <input type="checkbox" class="hide check" name="selectedPhoto[]" value="<?php echo $photo['id'] ?>" />
    </div>

<?php endforeach ?>

</div>

<?php else: ?>

<p>No photo yet.</p>

<?php endif ?>