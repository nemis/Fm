<?php

class View
{
	private $vars;
	private $view_file;
	private $full_view_file;
	
	public $db;
	public $controller;
	
	public function __construct($view_file)
	{
		$this->view_file = $view_file;
	}
	
	private function initialize_file()
	{
		if (!file_exists($f = $this->controller->application->name.'/views/'.$this->view_file.'.php'))
		{
			Fm::error(INVALID_VIEW_FILE);
		} else {
			$this->full_view_file = $f;
		}
	}
	
	public function __set($name, $var)
	{
		if (!isset($this->$name))
			$this->vars[$name] = $var;
	}
	
	public function __get($name)
	{
		if (!isset($this->$name))
			return $this->vars[$name];
	}
	
	public function render()
	{
		$this->initialize_file();
		
		extract($this->vars);
		ob_start();
		include $this->full_view_file;
		return ob_get_clean();
	}
}