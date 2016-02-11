<div class="comment_canvas">
    <?php
    
    //pr($data);
    $commentData = isset($data['Comment']) ? $data['Comment'] : $data[$type]['Comment'];
    
    ?>
<?php if (!empty($commentData)): ?>
    <?php foreach($commentData as $comment): ?>
    <div class="comment_block">
        <hr />
        <div class="user_thumb_pic">
            <?php if (!empty($comment['User']['PhotoAlbum']['0']['Photo'])): ?>
                <?php if ($comment['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $comment['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $comment['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $comment['User']['full_name'], 'border' => 0, 'width' => '50', 'height' => '50')), array('controller' => 'users', 'action' => 'view', !empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('title' => $comment['User']['full_name'], 'escape' => false)) ?>
                <?php else: ?>
                <?php echo $this->Html->link($this->Html->image('/files/photo/photo/' . $comment['User']['PhotoAlbum']['0']['Photo']['0']['photo_dir'] . '/thumb_' . $comment['User']['PhotoAlbum']['0']['Photo']['0']['photo'], array('alt' => $comment['User']['full_name'], 'border' => 0, 'width' => '50', 'height' => '50')), array('controller' => 'users', 'action' => 'view', !empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('title' => $comment['User']['full_name'], 'escape' => false, 'rel' => '/users/quicklook/' . $comment['User']['id'])) ?>
                <?php endif ?>
            <?php else: ?>
                <?php if ($comment['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                    <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $comment['User']['full_name'], 'border' => 0, 'width' => '50', 'height' => '50')), array('controller' => 'users', 'action' => 'view', !empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('escape' => false)) ?>
                <?php else: ?>
                    <?php echo $this->Html->link($this->Html->image('photoplaceholder.png', array('alt' => $comment['User']['full_name'], 'border' => 0, 'width' => '50', 'height' => '50')), array('controller' => 'users', 'action' => 'view', !empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('escape' => false,  'rel' => '/users/quicklook/' . $comment['User']['id'])) ?>
                <?php endif ?>
            <?php endif ?>
        </div>
        <div class="commentPost">
            <div class="poster_name">
                <?php if ($comment['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                    <?php echo $this->Html->link($comment['User']['full_name'],array('controller'=>'users','action'=>'view',!empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('escape' => false)) ?>
                <?php else: ?>
                    <?php echo $this->Html->link($comment['User']['full_name'],array('controller'=>'users','action'=>'view',!empty($comment['User']['username']) ? $comment['User']['username'] : $comment['User']['id']), array('escape' => false, 'rel' => '/users/quicklook/' . $comment['User']['id'])) ?>
                <?php endif ?>
                <?php if ($comment['User']['id'] == $this->Session->read('Auth.User.id')): ?>
                    <div style="float: right"><?php echo $this->Html->link('<span class="ui-icon ui-icon-close"></span>', '#remove_comment', array('escape' => false, 'class' => 'remove_comment', 'title' => 'Remove Comment', 'rel' => 'comment-' . $comment['id'])) ?></div>
                <?php endif ?>
            </div>
            <div class="content"><?php echo nl2br($comment['content']) ?></div>
            <?php echo $this->element('likes',array('data' => $comment,'type'=>'Comment')) ?>
        </div>
    </div>
    <?php endforeach ?>
<?php endif ?>
    <form>
    <?php
    echo $this->Form->input('Comment.parent_id', array('id' => false, 'class' => 'comment_parent_id', 'type'=>'hidden','value'=>$data[$type]['id']));
    echo $this->Form->input('Comment.parent_model_name', array('id' => false, 'class' => 'comment_parent_name', 'type'=>'hidden','value'=>$type));
    echo $this->Form->textarea('Comment.content',array('id' => false, 'class' => 'commentContent', 'div'=>'false', 'label'=>false));
    ?>
        <input type="submit" class="postComment" value="Post comment" />
    </form>
</div>