<?php echo $this->Html->css("ui-lightness/jquery-ui-1.10.3.custom.min") ?>
<?php echo $this->Html->css('colorbox') ?>
<?php echo $this->Html->css('jqueryui-editable') ?>

<?php echo $this->Html->script('jquery.colorbox-min') ?>
<?php echo $this->Html->script('jqueryui-editable.min') ?>
<?php echo $this->Html->script('jquery.selectable'); ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        var editMode = false;
        
        $('a.gallery').colorbox({rel: 'gal', onComplete:function(){ $.colorbox.resize({innerWidth: '485px', innerHeight: '290'}); } });
        
        $('a.gallery').click(function(e) {
            if (editMode == true) {
                e.preventDefault();
            }
        });
        
        $('.editMode').click(function () {
            $('#contentarea .editable').editable('toggleDisabled');
            if (editMode == true) {
                editMode = false;
                $('.deleteVideos, .deleteAlbum').hide();
                $('a.gallery').colorbox({rel: 'gal'});
                selectable.disable();
                selectable.deselectAll();
                $(this).text('Edit Mode');
            } else {
                editMode = true;
                $('.deleteVideos, .deleteAlbum').show();
                $.colorbox.remove();
                selectable.enable();
                selectable.deselectAll();
                $(this).text('Done');
            }
            return false;
        });
        
        $('.deleteVideos').click(function () {
            $.ajax({
                url: '/users/delete_videos/',
                type: 'POST',
                data: {selected_videos: $('#SelectedVideosData').text() }
            }).done(function(msg) {
                if (msg != 'success') {
                    location.reload();
                } else {
                    selectable.removeSelected();
                }
            }).fail(function() {
                location.reload();
            });
            return false;
        });
        
        $.fn.editable.defaults.mode = 'inline';
        
        $('#albumTitle, #albumDescription').editable({
            disabled: true
        });
        
        var selectable = $('.btn').selectable({
            'class': 'btn-info',
            'disabled': true,
            onChange: function() {
                isChecked();
                $('#SelectedVideosData').html( decodeURIComponent($('input:checkbox.check').serialize()) );
            }
        });
        
        function isChecked() {
            if ($('input.check[type=checkbox]:checked').length > 0) {
                $('.deleteVideos').prop('disabled', false);
            } else {
                $('.deleteVideos').prop('disabled', 'disabled');
            }
        }
        
    });
                                    ") ?>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->textarea('selected_videos', array('id' => 'SelectedVideosData', 'class' => 'hide')); ?>

<h2><a href="#" id="albumTitle" data-type="text" data-pk="<?php echo $data['VideoAlbum']['id'] ?>" data-url="/users/edit_video_album" data-original-title="Enter Album Title"><?php echo $data['VideoAlbum']['title'] ?></a></h2>

<h4><a href="#" id="albumDescription" data-type="textarea" data-pk="<?php echo $data['VideoAlbum']['id'] ?>" data-url="/users/edit_video_album" data-original-title="Enter Album Description"><?php echo $data['VideoAlbum']['description'] ?></a></h4>

<div class="actions">
    <?php echo $this->Html->link('Back to Albums', array('controller' => 'users', 'action' => 'videos')) ?> 
    <?php echo $this->Html->link('Add Video', array('controller' => 'users', 'action' => 'add_video', $data['VideoAlbum']['id'])) ?> 
</div>

<div class="actions hiddenActions">
    <?php echo $this->Html->link('Edit Mode', '#', array('escape' => false, 'class' => 'editMode')) ?>
    <?php echo $this->Html->link('Delete Videos', '#', array('escape' => false, 'class' => 'deleteVideos btn', 'disabled' => 'disabled')) ?>
    <?php echo $this->Html->link('Delete Album', array('controller' => 'users', 'action' => 'delete_video_album', $data['VideoAlbum']['id']), array('escape' => false, 'class' => 'deleteAlbum'), 'This will permanently delete this album.') ?>
</div>

<br /><br /><br />

<?php if (!empty($data['Video'])): ?>

<div class="videoPage<?php echo ($data['VideoAlbum']['primary'] == 1) ? ' primary' : '' ?>">

<?php foreach($data['Video'] as $video): ?>

    <div class="video_details btn" id="video-<?php echo htmlentities($video['id']) ?>">
        <?php $filename = pathinfo($video['video']) ?>
        <div class="video_image"><?php echo $this->Html->link($this->Html->image('/files/video/video/' . $video['video_dir'] . '/' . $filename['filename'] . '.jpg', array('alt' => $video['title'], 'border' => 0, 'width' => '150', 'height' => '150')), array('controller' => 'users', 'action' => 'video_player', $video['id']), array('escape' => false, 'rel' => 'gal', 'class' => 'gallery', 'title' => $video['title'])) ?></div>
        <input type="checkbox" class="hide check" name="selectedVideo[]" value="<?php echo $video['id'] ?>" />
    </div>

<?php endforeach ?>

</div>

<?php else: ?>

<p>No video yet.</p>

<?php endif ?>