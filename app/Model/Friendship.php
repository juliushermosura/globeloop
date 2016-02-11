<?php

class Friendship extends AppModel {

    public $belongsTo = array(
        'UserFrom' => array(
            'className' => 'User',
            'foreignKey' => 'user_from'
        ),
        'UserTo' => array(
            'className' => 'User',
            'foreignKey' => 'user_to'
        )
    );
    
}

?>