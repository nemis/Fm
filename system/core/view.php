<?php

class View
{
	private $vars;
	private $view_file;
	private $full_view_file;
	
	public $db;
	public $controller = false;
	public $application = false;
	
	public $baseUrl = false;
	
	public function __construct($view_file)
	{
		$this->view_file = $view_file;
		$this->baseUrl = Fm::applicationPath();
	}
	
	private function initialize_file()
	{
		if ($this->controller)
		{
			if (!file_exists($f =
				Fm::relativePath()
				.'/'
				.$this->controller->application->name.'/views/'
				.$this->view_file.'.php'
			))
			{
				$f = $this->systemTemplate($this->view_file);
			}
		} else {
			$f = $this->systemTemplate($this->view_file);
		}
		
		if (!file_exists($f)) {
			Fm::error(INVALID_VIEW_FILE.' ('.$this->view_file.')');
		} else {
			$this->full_view_file = $f;
		}
	}
	
	private function systemTemplate($name)
	{
		return dirname(__FILE__).'/../templates/'.$name.'.php';
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
	
	public function __toString()
	{
		return $this->render();
	}
	
	public function render()
	{
		// load styles
		if ($this->application)
			$this->application->loadStyles($this->view_file);
		
		// parse php file
		$this->initialize_file();
		
		if (is_array($this->vars)) extract($this->vars);
		ob_start();
		include $this->full_view_file;
		return ob_get_clean();
	}
}