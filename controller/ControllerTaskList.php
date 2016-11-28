<?php

class ControllerTaskList extends MainController
{
	public function index()
    {
        
        $this->title = 'TaskList';
		$this->loadModel('TaskList');
        $this->loadView('TaskList');
        
	}
}