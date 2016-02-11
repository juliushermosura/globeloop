<?php
$hasPhoto = $this->Session->check('Essentials.Photo.Photo.0');
$full_name = $this->Session->read('Auth.User.full_name');
$id = $this->Session->check('Auth.User.username') ? $this->Session->read('Auth.User.username') : $this->Session->read('Auth.User.id');
$photo = $this->Session->read('Essentials.Photo.Photo.0.photo');
$photo_dir = $this->Session->read('Essentials.Photo.Photo.0.photo_dir');
$img = $hasPhoto ? "$('.group_page').prepend('<div class=\"grouping\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/files/photo/photo/" . $photo_dir . "/thumb_" . $photo . "\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" border=\"0\" /></a></div><div class=\"group_post\"><div class=\"poster_name\"><a href=\"/users/view/" .$id. "\">" . $full_name . "</a><div style=\"float: right\"><sub><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></sub></div></div><div class=\"content\">' + $('#postContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><div class=\"comment_canvas\"><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"'+ msg +'\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"Post\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div></div></div>');" : "$('.grouping').prepend('<div class=\"grouping\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/img/photoplaceholder.png\" border=\"0\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" /></a></div><div class=\"group_post\"><div class=\"poster_name\"><a href\"/users/view/" . $id . "\">" . $full_name . "</a><div style=\"float: right\"><sub><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></sub></div></div><div class=\"content\">' + $('#postContent').val() +'</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><div class=\"comment_canvas\"><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"'+ msg +'\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"Post\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div></div></div>');";

$comment = $hasPhoto ? "$('<div class=\"comment_block\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/files/photo/photo/" . $photo_dir . "/thumb_" . $photo . "\" alt=\"" . $full_name . "\" width=\"50\" height=\"50\" border=\"0\" /></a></div><div class=\"commentPost\"><div class=\"poster_name\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\">" .$full_name. "</a><div style=\"float: right\"><sub><a href=\"#remove_comment\" title=\"Remove Comment\" class=\"remove_comment\" rel=\"comment-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></sub></div></div><div class=\"content\">' + parent.children('.commentContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-' + msg + '\">Like</a></sub><div class=\"likers\"><sub></sub></div></div></div>').insertBefore(parent);" : "$('<div class=\"comment_block\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/img/photoplaceholder.png\" alt=\"" . $full_name . "\" width=\"50\" height=\"50\" border=\"0\" /></a></div><div class=\"commentPost\"><div class=\"poster_name\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\">" .$full_name. "</a><div style=\"float: right\"><sub><a href=\"#remove_comment\" title=\"Remove Comment\" class=\"remove_comment\" rel=\"comment-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></sub></div></div><div class=\"content\">' + parent.children('.commentContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-' + msg + '\">Like</a></sub><div class=\"likers\"><sub></sub></div></div></div>').insertBefore(parent);";


?>

<?php echo $this->Html->script("jquery.infinitescroll.min") ?>
<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
    
        $('#postForm').click(function(e) {
            e.preventDefault();
            if ($('#postContent').val().length > 0) {
                $.ajax({
                    url: '/users/group_post/',
                    data: { parent_id: $('#parent_id').val(), content: $('#postContent').val() },
                    type: 'POST'
                }).done(function(msg) {
                    if (msg == 'failed') {
                        alert('Oops! Something went wrong during your posting. You may try it again later.');
                    } else {
                        " . $img . "
                        $('#postContent').val('');
                    }
                }).fail(function() {
                    alert('Oops! Something went wrong during your posting. You may try it again later.');
                });
            }
            return false;
        });
        
        $('.pagesX').infinitescroll({
            navSelector  : 'div.pageNav',            
            nextSelector : 'div.pageNav .next a',    
            itemSelector : '.pagesX',
            loading: {
                finishedMsg: '<em>Finish.</em>',
                msgText: '<em>Retrieving more posts...</em>',
            }
        }, function() {
            $(this).qtip_loader();
        });
        
        $('#contentarea').on('click', '.postComment', function(e) {
            var parent = $(this).parent();
            e.preventDefault();
            if ($(this).parent().children('.commentContent').val().length > 1) {
                $.ajax({
                    url: '/users/add_comment/',
                    data: { comment_parent_id: $(this).parent().children('.comment_parent_id').val(), comment_content: $(this).parent().children('.commentContent').val(), comment_parent_name: 'Post' },
                    type: 'POST'
                }).done(function(msg) {
                    if (msg == 'failed') {
                        alert('Oops! Something went wrong during your posting. You may try it again later.');
                    } else {
                        " . $comment . "
                        parent.children('.commentContent').val('');
                    }
                }).fail(function() {
                    alert('Oops! Something went wrong during your posting. You may try it again later.');
                });
            }
            return false;
        });
        
        $('#contentarea').on('click', '.remove_post', function(e) {
            e.preventDefault();
            var ans = confirm('This will remove this post. Do you want to continue?');
            if (ans) {
            var parent = $(this).parents('.grouping');
                $.ajax({
                    url: '/users/remove_post/',
                    data: { id: $(this).prop('rel').replace('post-', '') },
                    type: 'POST'
                }).done(function(msg) {
                    if (msg == 'success') {
                        parent.remove();
                    } else {
                        alert('Oops! Something went wrong during your post removing. You may try it again later.');
                    }
                }).fail(function() {
                    alert('Oops! Something went wrong during your post removing. You may try it again later.');
                });
            }
            return false;
        });
        
        $('#contentarea').on('click', '.remove_comment', function(e) {
            e.preventDefault();
            var ans = confirm('This will remove this comment. Do you want to continue?');
            if (ans) {
            var parent = $(this).parents('.comment_block');
                $.ajax({
                    url: '/users/remove_comment/',
                    data: { id: $(this).prop('rel').replace('comment-', '') },
                    type: 'POST'
                }).done(function(msg) {
                    if (msg == 'success') {
                        parent.remove();
                    } else {
                        alert('Oops! Something went wrong during your post removing. You may try it again later.');
                    }
                }).fail(function() {
                    alert('Oops! Something went wrong during your post removing. You may try it again later.');
                });
            }
            return false;
        });
        
        $('#contentarea').on('click', '.like', function(e) {
            e.preventDefault();
            var parent = $(this);
            var like = ($(this).text() == 'Like');
            var model;
            if ($(this).hasClass('Post')) {
                model = 'Post';
            }
            if ($(this).hasClass('Comment')) {
                model = 'Comment';
            }
            $.ajax({
                url: '/users/like_unlike/',
                data: { id: $(this).prop('rel').replace('like-', ''), like: like, model: model },
                type: 'POST'
            }).done(function(msg) {
                if (msg == 'success') {
                    if (like) {
                        parent.text('Unlike');
                        if (parent.parent().next('.likers').children('sub').text().length == 0) {
                            parent.parent().next('.likers').children('sub').prepend('You likes this');
                        } else {
                            parent.parent().next('.likers').children('sub').prepend('You, ');
                        }
                    } else {
                        parent.text('Like');
                        if (parent.parent().next('.likers').children('sub').text() == 'You likes this') {
                            parent.parent().next('.likers').children('sub').text('');
                        } else {
                            var text = parent.parent().next('.likers').children('sub').html();
                            parent.parent().next('.likers').children('sub').html(text.replace('You, ', ''));
                        }
                    }
                } else {
                    alert('Oops! Something went wrong during your post liking. You may try it again later.');
                }
            }).fail(function() {
                alert('Oops! Something went wrong during your post liking. You may try it again later.');
            });
            return false;
        });
        
    });
") ?>
    
<form>
<?php
echo $this->Form->input('parent_id', array('id' => 'parent_id', 'type'=>'hidden','value'=>$parent));
echo $this->Form->input('parent_model_name', array('type'=>'hidden','value'=>$type));
echo $this->Form->textarea('content',array('id'=>'postContent','div'=>'false','class'=>'small','label'=>false, 'placeholder' => 'Post something here'));
?>

<div class="submit"><input type="submit" id="postForm" value="Post" /></div>
</form>

<div class="group_page">
<?php if (!empty($data)): ?>
    <div class="pagesX">
    <?php foreach($data as $post): ?>
    <div class="grouping">
        <div class="user_thumb_pic">
            <?php if (!empty($post['User']['PhotoAlbum']['0']['Photo'])): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $post['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $post['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $post['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($post['User']['username']) ? $post['User']['username'] : $post['User']['id']), array('title' => $post['User']['full_name'], 'escape' => false, )) ?>
            <?php else: ?>
            <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $post['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($post['User']['username']) ? $post['User']['username'] : $post['User']['id']), array('escape' => false)) ?>
            <?php endif ?>
        </div>
        <div class="group_post">
            <div class="poster_name">
                <?php echo $this->Html->link($post['User']['full_name'],array('controller'=>'users','action'=>'view',!empty($post['User']['username']) ? $post['User']['username'] : $post['User']['id'])) ?>
                <?php if ($post['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                <div style="float: right"><sub><?php echo $this->Html->link('<span class="ui-icon ui-icon-close"></span>', '#remove_post', array('escape' => false, 'title' => 'Remove Post', 'class' => 'remove_post', 'rel' => 'post-' . $post['Post']['id'])) ?></sub></div>
                <?php endif ?>
            </div>
            <div class="content"><?php echo nl2br($post['Post']['content']) ?></div>
            <?php echo $this->element('likes',array('data' => $post,'type'=>'Post')) ?>
            <?php echo $this->element('comments',array('data' => $post,'type'=>'Post')) ?> 
        </div>
    </div>
    <?php endforeach ?>
    </div>
<?php endif ?>
    <div class="pageNav" style="display: none"><?php echo $this->Paginator->next(' >> ' . __('next'), array(), null, array('class' => 'next disabled')); ?></div>

</div>
