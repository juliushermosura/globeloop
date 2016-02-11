<?php

class Association extends AppModel {

    public $hasMany = array(
                            'AssociationMember' => array('conditions' => array('AssociationMember.deleted' => 0)),
                            'Post' => array('foreignKey' => 'parent_id', 'conditions' => array('Post.parent_model_name' => 'Association'), 'order' => array('Post.created DESC')),
                            );

    public $validate = array(
        'title' => array(
           'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'Association name should be 2 or more characters.'
            )
        )
    );
    
}

?>