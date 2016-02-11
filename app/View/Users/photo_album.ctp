<?php echo $this->Html->css("ui-lightness/jquery-ui-1.10.3.custom.min") ?>
<?php echo $this->Html->css('colorbox') ?>
<?php echo $this->Html->css('jqueryui-editable') ?>

<?php echo $this->Html->script('jquery.colorbox-min') ?>
<?php echo $this->Html->script('jqueryui-editable.min') ?>
<?php echo $this->Html->script('jquery.selectable'); ?>
<?php echo $this->Html->script('facedetection/ccv') ?>
<?php echo $this->Html->script('facedetection/face') ?>
<?php echo $this->Html->script('jquery.facedetection') ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        var editMode = false;
        var updatePrimaryPhoto = false;
        var order;
        
        $('a.gallery').colorbox({rel: 'gal', onComplete: function() { alert('aa'); }});
        
        $('a.gallery').click(function(e) {
            if (editMode == true) {
                e.preventDefault();
            }
        });
        
        $('.photoPage').sortable({
            disabled: true,
            stop: function(e, ui) {
                updatePositions($(this));
            }
        });
        $('.photoPage').disableSelection();
        
        function updatePositions(e) {
            order = $.map(e.find('.photo_details'), function(el) {
                return el.id + ' = ' + $(el).index();
            });
            $.ajax({
                url: '/users/update_photo_order/" . $data['PhotoAlbum']['id'] . "',
                type: 'POST',
                data: {photos_order: order }
            }).done(function(msg) {
                if (msg == 'success') {
                    //location.reload();
                } else if (msg == 'reload') {
                    updatePrimaryPhoto = true;
                } else if (msg == 'reload2') {
                    location.reload();
                } else {
                    alert('Oops! Something went wrong during setting the photo. Please reload the page and try again later.');
                }
            }).fail(function() {
                location.reload();
            });
        }
        
        $('.editMode').click(function () {
            if (editMode == true) {
                editMode = false;
                $('.deletePhotos, .deleteAlbum').hide();
                $('a.gallery').colorbox({rel: 'gal'});
                selectable.disable();
                selectable.deselectAll();
                $('.photoPage').sortable('disable');
                $(this).text('Edit');
                if (updatePrimaryPhoto == true) {
                    $('#primary_photo img').prop('src', $('.photo_details:first div.photo_image img').prop('src'));
                    updatePrimaryPhoto = false;
                }
            } else {
                editMode = true;
                $('.deletePhotos, .deleteAlbum').show();
                $.colorbox.remove();
                selectable.enable();
                selectable.deselectAll();
                $('.photoPage').sortable('enable');
                $(this).text('Done');
            }
            $('#contentarea .editable2').editable('toggleDisabled');
            return false;
        });
        
        $('.deletePhotos').click(function () {
            var attr = $(this).prop('disabled');
            if (typeof attr !== 'undefined' && attr !== false) {
            } else {
                var ans = confirm('This will delete the selected photo(s).');
                if (ans) {
                    $.ajax({
                        url: '/users/delete_photos/',
                        type: 'POST',
                        data: {selected_photos: $('#SelectedPhotosData').text(), id: '" . $data['PhotoAlbum']['id'] . "' }
                    }).done(function(msg) {
                        if (msg != 'success') {
                            location.reload();
                        } else {
                            selectable.removeSelected();
                            updatePositions($('.photoPage').sortable());
                        }
                    }).fail(function() {
                        location.reload();
                    });
                }
            }
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
                $('#SelectedPhotosData').html( decodeURIComponent($('input:checkbox.check').serialize()) );
            }
        });
        
        function isChecked() {
            if ($('input.check[type=checkbox]:checked').length > 0) {
                $('.deletePhotos').prop('disabled', false);
            } else {
                $('.deletePhotos').prop('disabled', 'disabled');
            }
        }
        
    });
                                    ") ?>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->textarea('selected_photos', array('id' => 'SelectedPhotosData', 'class' => 'hide')); ?>

<h2><a href="#" class="editable2" id="albumTitle" data-type="text" data-pk="<?php echo $data['PhotoAlbum']['id'] ?>" data-url="/users/edit_photo_album" data-original-title="Enter Album Title"><?php echo $data['PhotoAlbum']['title'] ?></a></h2>

<h4><a href="#" class="editable2" id="albumDescription" data-type="textarea" data-pk="<?php echo $data['PhotoAlbum']['id'] ?>" data-url="/users/edit_photo_album" data-original-title="Enter Album Description"><?php echo $data['PhotoAlbum']['description'] ?></a></h4>

<div class="actions">
    <?php echo $this->Html->link('Back to Albums', array('controller' => 'users', 'action' => 'photos')) ?> 
    <?php echo $this->Html->link('Add Photo', array('controller' => 'users', 'action' => 'add_photo', $data['PhotoAlbum']['id'])) ?> 
</div>

<div class="actions hiddenActions">
    <?php echo $this->Html->link('Edit', '#', array('escape' => false, 'class' => 'editMode')) ?>
    <?php echo $this->Html->link('Delete Photos', '#', array('escape' => false, 'class' => 'deletePhotos btn', 'disabled' => 'disabled')) ?>
    <?php echo $this->Html->link('Delete Album', array('controller' => 'users', 'action' => 'delete_photo_album', $data['PhotoAlbum']['id']), array('escape' => false, 'class' => 'deleteAlbum'), 'This will permanently delete this album.') ?>
</div>

<br /><br /><br />

<?php if (!empty($data['Photo'])): ?>

<div class="photoPage<?php echo ($data['PhotoAlbum']['primary'] == 1) ? ' primary' : '' ?>">

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