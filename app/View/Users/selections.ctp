<?php

$hasPhoto = $this->Session->check('Essentials.Photo.Photo.0');
$full_name = $this->Session->read('Auth.User.full_name');
$id = $this->Session->check('Auth.User.username') ? $this->Session->read('Auth.User.username') : $this->Session->read('Auth.User.id');
$photo = $this->Session->read('Essentials.Photo.Photo.0.photo');
$photo_dir = $this->Session->read('Essentials.Photo.Photo.0.photo_dir');
$img = $hasPhoto ? "$('.newsfeed_canvas').prepend('<div class=\"newsfeed_entry\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/files/photo/photo/" . $photo_dir . "/thumb_" . $photo . "\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" border=\"0\" /></a></div><div class=\"newsfeed_details\"><a href=\"/users/view/" .$id. "\">" . $full_name . "</a><div style=\"float: right\"><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div><div style=\"margin-top: 5px; width: 580px\">' + $('#postContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"' +msg+ '\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"HorizonPost\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div>');" : "$('.newsfeed_canvas').prepend('<div class=\"newsfeed_entry\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/img/photoplaceholder.png\" border=\"0\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" /></a></div><div class=\"newsfeed_details\"><a href\"/users/view/" . $id . "\">" . $full_name . "</a><div style=\"float: right\"><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div><div style=\"margin-top: 5px; width: 580px\">' + $('#postContent').val() +'</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"' +msg+ '\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"HorizonPost\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div>');";

$img2 = $hasPhoto ? "$('.newsfeed_canvas').prepend('<div class=\"newsfeed_entry\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/files/photo/photo/" . $photo_dir . "/thumb_" . $photo . "\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" border=\"0\" /></a></div><div class=\"newsfeed_details\"><a href=\"/users/view/" .$id. "\">" . $full_name . "</a> shared a link.<div style=\"float: right\"><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div><div style=\"margin-top: 5px;\">' + content + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"' +msg+ '\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"HorizonPost\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div>');" : "$('.newsfeed_canvas').prepend('<div class=\"newsfeed_entry\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/img/photoplaceholder.png\" border=\"0\" alt=\"" . $full_name . "\" width=\"80\" height=\"80\" /></a></div><div class=\"newsfeed_details\"><a href\"/users/view/" . $id . "\">" . $full_name . "</a> shared a link.<div style=\"float: right\"><a href=\"#remove_post\" title=\"Remove Post\" class=\"remove_post\" rel=\"post-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div><div style=\"margin-top: 5px;\">' + content +'</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-'+ msg +'\">Like</a></sub><div class=\"likers\"><sub></sub></div></div><form><input type=\"hidden\" name=\"data[Comment][parent_id]\" class=\"comment_parent_id\" value=\"' +msg+ '\"><input type=\"hidden\" name=\"data[Comment][parent_model_name]\" class=\"comment_parent_name\" value=\"HorizonPost\"><textarea name=\"data[Comment][content]\" class=\"commentContent\" div=\"false\"></textarea><input type=\"submit\" class=\"postComment\" value=\"Post comment\"></form></div>');";

$comment = $hasPhoto ? "$('<div class=\"comment_block\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/files/photo/photo/" . $photo_dir . "/thumb_" . $photo . "\" alt=\"" . $full_name . "\" width=\"50\" height=\"50\" border=\"0\" /></a></div><div class=\"commentPost\"><div class=\"poster_name\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\">" .$full_name. "</a><div style=\"float: right\"><a href=\"#remove_comment\" title=\"Remove Comment\" class=\"remove_comment\" rel=\"comment-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div></div><div class=\"content\">' + parent.children('.commentContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-' + msg + '\">Like</a></sub><div class=\"likers\"><sub></sub></div></div></div>').insertBefore(parent);" : "$('<div class=\"comment_block\"><div class=\"user_thumb_pic\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\"><img src=\"/img/photoplaceholder.png\" alt=\"" . $full_name . "\" width=\"50\" height=\"50\" border=\"0\" /></a></div><div class=\"commentPost\"><div class=\"poster_name\"><a href=\"/users/view/" . $id . "\" title=\"" . $full_name . "\">" .$full_name. "</a><div style=\"float: right\"><a href=\"#remove_comment\" title=\"Remove Comment\" class=\"remove_comment\" rel=\"comment-' + msg + '\"><span class=\"ui-icon ui-icon-close\"></span></a></div></div><div class=\"content\">' + parent.children('.commentContent').val() + '</div><div class=\"like_canvas\"><sub><a href=\"#like\" title=\"Like\" class=\"like Post\" rel=\"like-' + msg + '\">Like</a></sub><div class=\"likers\"><sub></sub></div></div></div>').insertBefore(parent);";

?>

<?php echo $this->Html->css('colorbox') ?>

<?php echo $this->Html->script('jquery.colorbox-min') ?>
<?php echo $this->Html->script("jquery.infinitescroll.min") ?>
<?php echo $this->Html->script('facedetection/ccv') ?>
<?php echo $this->Html->script('facedetection/face') ?>
<?php echo $this->Html->script('jquery.facedetection') ?>

<?php echo $this->Html->scriptBlock("
    var parseLink = true;
    var share = false;
    
    $(document).ready(function() {
        
        $('a.gallery').colorbox({rel: 'gal'});
        
        $('#postForm').click(function(e) {
            e.preventDefault();
            var content = '';
            var url = '';
            if ($('#postContent').val().length > 0) {
                if (share == true) {
                    url = '/users/horizon_share/';
                    if (parseLink == true) {
                        var attach_content = $('#extracthere').html();
                        content = '<div class=\"post_content\">' + urlify($('#postContent').val()) + '</div><hr />' + attach_content + '<hr class=\"clear-both\" />';
                    } else {
                        content = urlify($('#postContent').val());
                    }
                } else {
                    url = '/users/horizon_post/';
                    content = urlify($('#postContent').val());
                }
                $.ajax({
                    url: url,
                    data: { parent_id: $('#parent_id').val(), content: content },
                    type: 'POST'
                }).done(function(msg) {
                    if (msg == 'failed') {
                        alert('Oops! Something went wrong during your posting. You may try it again later.');
                    } else {
                        if (share == true && parseLink) {
                            " . $img2 . "
                        } else {
                            " . $img . "
                        }
                        $('#postContent').val('');
                        $('#attach_content').hide();
                        parseLink = true;
                        share = false;
                    }
                }).fail(function() {
                    alert('Oops! Something went wrong during your posting. You may try it again later.');
                });
            }
            return false;
        });
        
        $('#body').on('click', '.postComment', function(e) {
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
        
        $('#body').on('click', '.remove_post', function(e) {
            e.preventDefault();
            var ans = confirm('This will remove this post. Do you want to continue?');
            if (ans) {
            var parent = $(this).parents('.newsfeed_entry');
                $.ajax({
                    url: '/users/remove_newsfeed/',
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
        
        $('#body').on('click', '.remove_comment', function(e) {
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
        
        $('#body').on('click', '.like', function(e) {
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
            if ($(this).hasClass('Photo')) {
                model = 'Photo';
            }
            if ($(this).hasClass('PhotoAlbum')) {
                model = 'PhotoAlbum';
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
                            parent.parent().next('.likers').children('sub').prepend('You likes this.');
                        } else {
                            parent.parent().next('.likers').children('sub').prepend('You, ');
                        }
                    } else {
                        parent.text('Like');
                        if (parent.parent().next('.likers').children('sub').text() == 'You likes this.') {
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
        
        $('#postContent').focusout(function() {
            if (parseLink == true) {
                parse_link();
            }
        });
        
        function parse_link () {
            if(!containValidURL($('#postContent').val())) {
                //alert('Please enter a valid url.');
                //return false;
            } else {
                share = true;
                $('#atc_loading').show();
                var urlRegex = /(https?:\/\/[^\s]+)/g;
                var postUrl = '';
                var post = $('#postContent').val().replace(urlRegex, function(url) {
                    postUrl = url;
                    return url;
                });
                $('#loader .atc_url').html(postUrl);
                $.post(\"/fetch.php?url=\"+escape(postUrl), {}, function(response){
                    var classType = '';
                    if (postUrl.indexOf('http://youtube.com') !== -1 || postUrl.indexOf('http://www.youtube.com') !== -1 || postUrl.indexOf('http://youtu.be') !== -1) {
                        classType = 'youtube';
                    }
                   //Set Content
                   $('#loader .atc_title').html('<a target=\"_blank\" href=\"' + post + '\">' + response.title + '</a>');
                   $('#loader .atc_desc').html(response.description);
                   $('#atc_price').html(response.price);
     
                   $('#atc_total_images').html(response.total_images);
     
                   $('#loader .atc_images').html(' ');
                   $.each(response.images, function (a, b)
                   {
                      $('#loader .atc_images').append('<a class=\"'+classType+'\" href=\"' + post + '\"><span></span><img src=\"'+b.img+'\" width=\"100\" id=\"'+(a+1)+'\"></a>');
                   });
                   $('#loader .atc_images img').hide();
     
                   //Flip Viewable Content
                   $('#attach_content').fadeIn('slow');
                   $('#atc_loading').hide();
     
                   //Show first image
                   $('img#1').fadeIn();
                   $('#cur_image').val(1);
                   $('#cur_image_num').html(1);
     
                   // next image
                   //$('#next').unbind('click');
                   $('#next').click(function(){
     
                      var total_images = parseInt($('#atc_total_images').html());
                      if (total_images > 0)
                      {
                         var index = $('#cur_image').val();
                         $('img#'+index).hide();
                         if(index < total_images)
                         {
                            new_index = parseInt(index)+parseInt(1);
                         }
                         else
                         {
                            new_index = 1;
                         }
     
                         $('#cur_image').val(new_index);
                         $('#cur_image_num').html(new_index);
                         $('img#'+new_index).show();
                      }
                      return false;
                   });
     
                   // prev image
                   //$('#prev').unbind('click');
                   $('#prev').click(function(){
     
                      var total_images = parseInt($('#atc_total_images').html());
                      if (total_images > 0)
                      {
                         var index = $('#cur_image').val();
                         $('img#'+index).hide();
                         if(index > 1)
                         {
                            new_index = parseInt(index)-parseInt(1);;
                         }
                         else
                         {
                            new_index = total_images;
                         }
     
                         $('#cur_image').val(new_index);
                         $('#cur_image_num').html(new_index);
                         $('img#'+new_index).show();
                      }
                      return false;
                   });
                });
            }
        }
        
    });
    
    $('#body').on('click', '.close_shared_link', function(e) {
        e.preventDefault();
        $('#attach_content').hide();
        parseLink = false;
        share = false;
        return false;
    });
    
    $('#body').on('click', 'a.youtube', function(){
        var videoURL = jQuery(this).prop('href');
        var regExp_YT = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var youtubeurl = videoURL.match(regExp_YT);
        var videoID = youtubeurl[7];
        var videoWidth = parseInt(jQuery(this).parent().parent().css('width'));
        var videoHeight = Math.ceil(videoWidth*(0.56)+1);
        if (jQuery(this).parent().parent().prop('id') != 'extracthere') {
            jQuery(this).parent().hide();
            jQuery(this).parent().next().css('margin-left', '0');
            jQuery(this).parent().parent().prepend('<iframe width=\"'+videoWidth+'\" height=\"'+videoHeight+'\" src=\"http://www.youtube.com/embed/'+(videoID)+'?rel=0&autoplay=0\" frameborder=\"0\" allowfullscreen></iframe>');
        }
        return false;
    });
    
    function containValidURL(url) {
        if (new RegExp(/(https?:\/\/[^\s]+)/g).test(url)) {
            return true;
        } else {
            return false;
        }
    }
    
    function urlify(text) {
        var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function(url) {
            return '<a href=\"' + url + '\">' + url + '</a>';
        })
    }

");

$ctr = 0;
$break = false;
$skip = false;
$sameAlbum = false;

?>

<?php //pr($data) ?>

<div class="graybar" style="margin-bottom: 30px;">
    <form>
        <?php
        echo $this->Form->input('parent_id', array('id' => 'parent_id', 'type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
        echo $this->Form->input('parent_model_name', array('type'=>'hidden','value'=>'Horizon'));
        echo $this->Form->textarea('content',array('id'=>'postContent','div'=>'false','class'=>'small','label'=>false, 'placeholder' => 'Post something here'));
        ?>
        <input type="hidden" name="cur_image" id="cur_image" />
    <div id="loader">
        <div align="center" id="atc_loading" style="display:none"><img src="/img/ajax-loader.gif" alt="Loading" /></div>
        <div id="attach_content" style="display:none">
            <div class="close_shared_link"><a href="#"><span class="ui-icon ui-icon-close"></span></a></div>
            <div id="extracthere">
                <div class="atc_images"></div>
                <div class="atc_info">
     
                    <label class="atc_title"></label>
                    <label class="atc_url"></label>
                    <br clear="all" />
                    <label class="atc_desc"></label>
                    <br clear="all" />
                </div>
            </div>
            <div id="atc_total_image_nav" >
                <a href="#" id="prev"><img src="/img/prev.png"  alt="Prev" border="0" /></a><a href="#" id="next"><img src="/img/next.png" alt="Next" border="0" /></a>
            </div>
 
            <div id="atc_total_images_info" >
                Showing <span id="cur_image_num">1</span> of <span id="atc_total_images">1</span> images
            </div>
            <br clear="all" />
        </div>
    </div>
    
        <div class="submit"><input type="submit" id="postForm" value="Post" /></div>
    </form>
</div>

<div class="newsfeed_canvas" id="newsfeed_canvas">

<?php foreach ($data as $feed): ?>

<?php

switch ($feed['NewsFeed']['parent_model_name']) {
    case 'HorizonShare':
        ?>
        <div class="newsfeed_entry">
            <div class="user_thumb_pic">
                <?php if (!empty($feed['User']['PhotoAlbum']['0']['Photo'])): ?>
                    <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $feed['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('title' => $feed['User']['full_name'], 'escape' => false)) ?>
                <?php else: ?>
                <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '80', 'height' => '80')), array('controller' => 'users', 'action' => 'view', !empty($feed['User']['username']) ? $feed['User']['username'] : $feed['User']['id']), array('escape' => false)) ?>
                <?php endif ?>
            </div>
            <div class="newsfeed_details">
                <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a> shared a link.
                <?php if ($feed['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                <div style="float: right"><?php echo $this->Html->link('<span class="ui-icon ui-icon-close"></span>', '#remove_post', array('escape' => false, 'title' => 'Remove Post', 'class' => 'remove_post', 'rel' => 'post-' . $feed['NewsFeed']['id'])) ?></div>
                <?php endif ?>
                <div class="post_content"><?php echo $feed['HorizonShare']['content'] ?></div>
                <?php echo $this->element('likes',array('data' => $feed['HorizonShare'],'type'=>'Post')) ?>
                <?php echo $this->element('comments',array('data' => $feed,'type'=>'HorizonShare')) ?> 
            </div>
        </div>
        <?php
        break;
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
                <div style="float: right"><?php echo $this->Html->link('<span class="ui-icon ui-icon-close"></span>', '#remove_post', array('escape' => false, 'title' => 'Remove Post', 'class' => 'remove_post', 'rel' => 'post-' . $feed['NewsFeed']['id'])) ?></div>
                <?php endif ?>
                <div style="margin-top: 5px;"><?php echo nl2br($feed['HorizonPost']['content']) ?></div>
                <?php echo $this->element('likes',array('data' => $feed['HorizonPost'],'type'=>'Post')) ?>
                <?php echo $this->element('comments',array('data' => $feed,'type'=>'HorizonPost')) ?> 
            </div>
        </div>
        <?php
        break;
    case 'Friendship':
        ?>
        <?php if (isset($feed[$feed['NewsFeed']['parent_model_name']]['UserTo']['id'])): ?>
            <div class="newsfeed_entry">
            <?php if ($feed[$feed['NewsFeed']['parent_model_name']]['UserTo']['id'] == $this->Session->read('Auth.User.id')):?>
                    You and <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a> are now friends.
            <?php else: ?>
                    <?php if ($feed['User']['id'] != $this->Session->read('Auth.User.id')): ?>
                    <div class="newsfeed_entry">Your friend <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a> and <a rel="/users/quicklook/<?php echo $feed[$feed['NewsFeed']['parent_model_name']]['UserTo']['id'] ?>" href="/users/view/<?php echo $feed[$feed['NewsFeed']['parent_model_name']]['UserTo']['id'] ?>"><?php echo $feed[$feed['NewsFeed']['parent_model_name']]['UserTo']['full_name'] ?></a> are now friends.</div>
                    <?php endif ?>
            <?php endif ?>
            </div>
        <?php endif ?>
        <?php
        break;
    case 'PrimaryPhoto':
        if ($skip == false) {
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
                    <a href="/users/view/<?php echo $feed['User']['id'] ?>"><?php echo $feed['User']['full_name'] ?></a> changed <?php echo ($feed['User']['gender'] == 'M') ? 'his' : 'her' ?> primary photo.
                    <div style="margin-top: 5px;"><?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $feed['PrimaryPhoto']['photo_dir'] . '/vga_' . $feed['PrimaryPhoto']['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '585')), array('controller' => 'users', 'action' => 'photoviewer', $feed['PrimaryPhoto']['id']), array('escape' => false, 'class' => 'gallery')) ?></div>
                    <?php echo $this->element('likes',array('data' => $feed['PrimaryPhoto'],'type'=>'Photo')) ?>
                </div>
            </div>
            <?php
                $skip = true;
            }
        break;
        
    case 'OtherPhoto':
    ?>
        <?php if ($sameAlbum != $feed['OtherPhoto']['PhotoAlbum2']['id']): ?>
            <?php $sameAlbum = $feed['OtherPhoto']['PhotoAlbum2']['id'] ?>
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
                        <?php if (($ctr) == 6) break; ?>
                            <?php if (count($feed['OtherPhoto']['PhotoAlbum2']['Photo']) == 1): ?>
                    <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $p['photo_dir'] . '/vga_' . $p['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, 'width' => '585')), array('controller' => 'users', 'action' => 'photoviewer', $p['id']), array('escape' => false, 'class' => 'gallery')) ?>
                                <?php break ?>
                            <?php endif ?>
                    <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $p['photo_dir'] . '/small_' . $p['photo'], array('alt' => $feed['User']['full_name'], 'border' => 0, )), array('controller' => 'users', 'action' => 'photoviewer', $p['id']), array('escape' => false, 'class' => 'gallery')) ?>
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
        <?php else: ?>
            <?php $ctr = 0 ?>
        <?php endif ?>
        <?php
        break;
        
    default:
}

?>

<?php endforeach ?>


</div>