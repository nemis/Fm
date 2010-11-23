<?php

final class Fm
{
	static private $system_dirs = array(
		'core',
		'libraries',
		'vendor',
	);
	
	static private $path = '';
	
	static private $applicationName;
	
	/**
	 * Displaying errors
	 * 
	 * @param string $error error content
	 */
	public static function error($error)
	{
		die($error);
	}
	
	/**
	 * Initialize framework,
	 * load __autoloaders functions
	 * 
	 */
	public static function initialize($path='')
	{
		require_once('system/constants.php');
		
		self::$path = $path;
		
		spl_autoload_register(null, false);
		spl_autoload_register(array('Fm', 'autoLoader'));
	}

	/**
	 * Autoloader function
	 * 
	 * @param string $class class name
	 */
	public static function autoLoader($class)
	{
		$type = substr($class, strpos($class, '_'), strlen($class));
		$lower_name = strtolower(str_replace('_'.$type, '', $class));
		$type = str_replace(ucfirst($lower_name), '', $type);
		if (empty($type))
		{
			foreach (self::$system_dirs as $dir)
			{
				if (file_exists($f = Fm::relativePath().'system/'.$dir.'/'.$lower_name.'.php'))
				{
					require_once($f);
					break;
				}
			}
		}
	}
	
	/**
	 * Starting up aplication object
	 *  
	 * @param string $name aplication name - aplication folder
	 * 
	 */
	public static function startApplication($name='application')
	{
		$application = new Application($name);
		
		// initialize database
		if (isset($application->config['db']))
		{
			$application->db = new Db();
			$application->db->connect(
				$application->config['db']['user'], 
				$application->config['db']['host'],
				$application->config['db']['pass'],
				$application->config['db']['db']
			);
		}
		
		self::$applicationName = $name;
		
		spl_autoload_register(array($application, 'autoLoader'));
		$application->start();
	}
	
	public static function relativePath()
	{
		return self::$path.'/';
	}
	
	public static function applicationPath()
	{
		return self::$applicationName;
	}
	
	static public function config($name)
	{
		include(self::applicationPath().'/config.php');
		$name = explode('.', $name);
		$v = $config[array_shift($name)];
		foreach ($name as $n)
		{
			if (!isset($v[$n])) return false;
			$v = $v[$n];
		}
		return $v;
	}
}