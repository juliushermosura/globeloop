<?php

class Post extends AppModel {
    
    public $belongsTo = array('User');
    public $hasMany = array(
                            'Comment' => array('foreignKey' => 'parent_id', 'conditions' => array('Comment.deleted' => 0, 'Comment.parent_model_name' => 'Post'), 'order' => array('Comment.created ASC')),
                            'Like' => array('foreignKey' => 'parent_id', 'conditions' => array('Like.parent_model_name' => 'Post'))
                            );

}

?>