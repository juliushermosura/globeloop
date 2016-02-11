<?php

class Category extends AppModel {
    
    public $hasMany = array('Deal' => array('conditions' => array('deleted' => 0)));
    public $actsAs = array('Tree');
    
}

?>