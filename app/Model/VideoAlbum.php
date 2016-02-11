<?php

class VideoAlbum extends AppModel {

    public $belongsTo = array('User');
    public $hasMany = array('Video' => array('conditions' => array('Video.deleted' => 0), 'order' => array('Video.primary DESC')));
    
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