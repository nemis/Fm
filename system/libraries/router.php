<?php

class Router
{
	static public $params = array();
	static public $controller;
	static public $action;
	
	static public $dir;
	
	static function route_controller($applicationName)
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		$path = explode('/', trim($url['path'],'/'));
		
		if (!isset($path[1]))
		{
			self::$controller = 'index';
			self::$action = 'index';
		} else {
			array_shift($path);
			
			$dir = $applicationName.'/controllers/';
			foreach ($path as $p)
			{
				if (!(is_dir($dir.$p.'/')))
				{
					break;
				} else {
					$dir .= $p.'/';
					array_shift($path);
				}
			}

			self::$dir = $dir;
			//if (isset($path[0]) and $path[0] == 'index.php')
			
			self::$controller = array_shift($path);
			self::$action = array_shift($path);
			if (empty(self::$action))
				self::$action = 'index';
		}
		
		foreach ($path as $k => $v)
			self::$params[$k] = $v;
			
		return array(self::$controller, self::$action, self::$params);
	}
}