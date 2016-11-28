<?php

class ModelTaskList extends MainModel {

    public function __construct() {
        $aList = $this->db->get('todo_list');
        var_dump($aList);
    }
    
}
