<?php

class Application
{
	public $name;
	
	public $config;
	public $db;
	public $currentController = false;
	
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
		if ($this->currentController->template)
		{
			$this->currentController->template;
		}
	}
}