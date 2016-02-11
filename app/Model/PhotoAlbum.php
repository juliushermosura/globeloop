<?php

class PhotoAlbum extends AppModel {

    public $belongsTo = array('User');
    public $hasMany = array(
                            'Photo' => array('conditions' => array('Photo.deleted' => 0), 'order' => array('Photo.primary DESC')),
                            'Like' => array('foreignKey' => 'parent_id', 'conditions' => array('Like.parent_model_name' => 'PhotoAlbum'))
                            );

    public $validate = array(
        'title' => array(
           'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'Album name should be 2 or more characters.'
            )
        )
    );
    

}

?>