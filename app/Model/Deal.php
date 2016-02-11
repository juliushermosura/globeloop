<?php

class Deal extends AppModel {
    
    public $actsAs = array(
        'Upload.Upload' => array(
            'photo' => array(
                'fields' => array(
                    'dir' => 'photo_dir'
                ),
                'thumbnailSizes' => array(
                    'xvga' => '1024x768',
                    'vga' => '640x480',
                    'small' => '150x150',
                    'thumb' => '80x80'
                ),
                'thumbnailMethod' => 'php'
            )
        )
    );
    
    public $belongsTo = array('User', 'Place', 'Category');

    public $validate = array(
        'photo' => array(
            'rule' => array('isValidMimeType', array('image/jpg', 'image/jpeg', 'image/gif', 'image/png')),
            'message' => 'File is not allowed image type (jpg or jpeg, gif, png)'
        )
    );
    
}

?>