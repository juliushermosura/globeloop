<?php

class GroupMember extends AppModel {

    public $belongsTo = array('User', 'Group' => array('conditions' => array('Group.deleted' => 0)));

}

?>