<?php

class Comment extends AppModel {
    
    public $belongsTo = array('User');
    public $hasMany = array('Like' => array('foreignKey' => 'parent_id', 'conditions' => array('Like.parent_model_name' => 'Comment')));

}

?>