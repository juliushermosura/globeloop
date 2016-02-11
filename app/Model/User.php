<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    public $actsAs = array('Containable');
    
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['full_name'] = sprintf('CONCAT(%s.first_name, " ", %s.last_name)', $this->alias, $this->alias);
        $this->virtualFields['gl_email'] = sprintf('CONCAT(%s.username, "@", %s.domain_name)', $this->alias, $this->alias);
    }
    
    public $hasMany = array(
        'FriendFrom' => array(
           'className' => 'Friendship',
           'foreignKey' => 'user_from'
        ),
        'FriendTo' => array(
            'className' => 'Friendship',
            'foreignKey' => 'user_to'
        ),
        'GroupMember' => array(
            'conditions' => array('GroupMember.deleted' => 0)
        ),
        'AssociationMember' => array(
            'conditions' => array('AssociationMember.deleted' => 0)
        ),
        'Inbox' => array(
            'className' => 'Message',
            'foreignKey' => 'recipient_id',
            'conditions' => array('Inbox.deleted' => 0, 'Inbox.draft' => 0, 'Inbox.sent' => 0)
        ),
        'Sent' => array(
            'className' => 'Message',
            'foreignKey' => 'sender_id',
            'conditions' => array('Sent.sent' => 1, 'Sent.deleted' => 0, 'Sent.draft' => 0)
        ),
        'Draft' => array(
            'className' => 'Message',
            'foreignKey' => 'sender_id',
            'conditions' => array('Draft.sent' => 0, 'Draft.deleted' => 0, 'Draft.draft' => 1)
        ),
        'PhotoAlbum' => array(
            'conditions' => array('PhotoAlbum.primary' => 1, 'PhotoAlbum.deleted' => 0)
        ),
        'NewsFeed' => array(
            'conditions' => array('DATE_SUB(CURDATE(),INTERVAL 5 DAY) <=' => 'NewsFeed.modified'),
            'limit' => 5
        ),
        'VideoAlbum', 'Comment', //'Deal'
    ); 
    
    public $hasAndBelongsToMany = array(
        'UserFriendship' => array(
            'className' => 'User',
            'joinTable' => 'friendships',
            'foreignKey' => 'user_from',
            'associationForeignKey' => 'user_to'
        )
    );
   
    public $displayField = array('gl_email', 'full_name');

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
   
    public $validate = array(
        'username' => array(
           'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'A username is required.'
            ),
            'username_alphanumeric' => array(
                 'rule' => 'alphaNumeric',
                 'message' => 'Alphabets and numbers only.'
            ),
            'username_unique' => array(
                'rule' => 'isUnique',
                'message' => 'That username is already in use.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength', '6'),
                'message' => 'A password must be 6 characters or more.'
            )
        ),
        'current_password' => array(
            'required' => array(
                'rule' => array('minLength', '6'),
                'on' => 'update',
                'message' => 'A password must be 6 characters or more.'
            ),
            'passwordMatch' => array(
                'rule' => array('passwordMatch', 'current_password'),
                'on' => 'update',
                'message' => 'Your current password did not match.'
            )
        ),
        'new_password' => array(
            'required' => array(
                'rule' => array('minLength', '6'),
                'on' => 'update',
                'message' => 'A password must be 6 characters or more.'
            )
        ),
        'confirm_password' => array(
            'identicalFieldValues' => array(
                'rule' => array('identicalFieldValues', 'new_password'),
                'on' => 'update',
                'message' => 'Please re-enter your password twice so that the values match.'
            )
        ),
        'email_address' => array(
            'required' => array(
                'rule' => 'email',
                'message' => 'A valid email address is required.'
            )
        ),
        'first_name' => array(
            'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'A first name must be 2 characters or more.'
            )
        ),
        'last_name' => array(
            'required' => array(
                'rule' => array('minLength', '2'),
                'message' => 'A last name must be 2 characters or more.'
            )
        ),
        'birthdate' => array(
            'required' => array(
                'rule' => 'date',
                'message' => 'A valid date is required.'
            )
        ),
        'gender' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A gender is required.'
            )
        )
    );
    
    function passwordMatch($field = null) {
        $old_password = $this->find('first', array('conditions' => array('id' => AuthComponent::user('id')), 'recursive' => -1, 'fields' => 'password'));
        $password = $old_password['User']['password'];
        $current_password = AuthComponent::password($field['current_password']);
        if ($password !== $current_password) {
            return FALSE;
        }
        return TRUE;
    }
    
    function identicalFieldValues( $field=array(), $compare_field=null ) { 
        foreach( $field as $key => $value ){ 
            $v1 = $value; 
            $v2 = $this->data[$this->name][ $compare_field ];                  
            if($v1 !== $v2) { 
                return FALSE; 
            } else { 
                continue; 
            } 
        }
        return TRUE; 
    } 
}

?>