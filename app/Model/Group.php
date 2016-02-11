<?php

class Group extends AppModel {

    public $hasMany = array(
                            'GroupMember' => array('conditions' => array('GroupMember.deleted' => 0)),
                            'Post' => array('foreignKey' => 'parent_id', 'conditions' => array('Post.parent_model_name' => 'Group'), 'order' => array('Post.created DESC')),
                            );

    public $validate = array(
        'title' => array(
           'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'Group name should be 2 or more characters.'
            )
        )
    );
    
}

?>