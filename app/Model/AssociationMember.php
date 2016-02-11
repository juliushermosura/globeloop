<?php

class AssociationMember extends AppModel {

    public $belongsTo = array('User', 'Association' => array('conditions' => array('Association.deleted' => 0)));

}

?>