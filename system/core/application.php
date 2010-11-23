<?php

class Application
{
	public $name;
	
	public $config;
	public $db;
	public $currentController = false;
	
	private $styles = array();
	private $stylesFiles = array();
	
	public function __construct($name='application')
	{
		// load config file
		if (file_exists($f = $name.'/config.php'))
		{
			include($f);
			if (isset($config))
				$this->config =& $config;
		}
		$this->name = $name;
	}

	public function start()
	{
		header('Content-Type: text/html; charset=UTF-8');
		
		Router::route_controller($this->name);
		
		if (Router::$dir)
			require_once(Router::$dir.Router::$controller.'.php');
			
		$controller_classname = ucfirst(Router::$controller).'_Controller';
		$controller = new $controller_classname;
		$controller->__initialize_controller();
		$controller->db =& $this->db;
		$controller->application =& $this;
		$controller->__loadView();
		$this->currentController = $controller;
		
		if (!is_callable(array($controller, Router::$action)))
		{
			Fm::error(ACTION_NOT_FOUND);
		} else {
			call_user_func_array(array($controller, Router::$action), Router::$params);
		}
		
		// check CSS files
		$dir = opendir(Fm::relativePath().'/'.$this->name.'/public/css');
		if ($dir) while ($file = readdir($dir)) if ($file != '.' and $file != '..')
		{
			$this->stylesFiles[] = substr($file, 0, strpos($file, '.'));
		}
	}
	
	public function autoLoader($class)
	{
		$type = substr($class, strpos($class, '_'), strlen($class));
		$lower_name = strtolower(str_replace($type, '', $class));
		$type = trim(str_replace('_', '', str_replace(ucfirst($lower_name), '', $type)));
		if ($type == 'Controller')
		{
			if (file_exists($f = $this->name.'/controllers/'.$lower_name.'.php'))
			{
				require_once($f);
			}
		}
	}
	
	public function __destruct()
	{
		echo $this->currentController;
	}
	
	public function styles()
	{
		return $this->styles; 
	}
	
	public function loadStyles($name)
	{
		if (in_array($name, ($this->stylesFiles)))
		{
			$this->styles[$name] = $name;
		}
	}
}