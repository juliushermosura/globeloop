<?php

class Message extends AppModel {
    
    public $belongsTo = array(
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        ),
        'Recipient' => array(
            'className' => 'User',
            'foreignKey' => 'recipient_id'
        ),
        'Author' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        ),
        'Parent' => array(
            'className' => 'Message',
            'foreignKey' => 'parent_id'
        )
    );
    
}

?>