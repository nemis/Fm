<?php

class Controller
{
	public $db;
	public $application;
	
	public $template = false;
	
	public function __loadView()
	{
		if ($this->template)
		{
			$this->template = $this->view($this->template, array(), false);
		}
	}
	
	public function view($viewFile=false, $vars=array(), $autoRender=true)
	{
		$view = new View($viewFile);
		$view->db =& $this->db;
		$view->vars = $vars;
		$view->controller =& $this;
		$view->template =& $this->template;
		
		if ($autoRender)
		{
			return $view->render();
		} else {
			return $view;
		}
	}
}