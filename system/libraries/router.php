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
	
	static public function createUrl($params=array(),$url=false,$use_existing_arguments=false) 
	{
		if (!$url)
		{
			$url = explode('?', $_SERVER['REQUEST_URI']);
			$url = $url[0];
		}
		
		$link = $url;
		
	    if($use_existing_arguments) $params = $params + $_GET;
	    if(!$params) return $url;
	    
	    if(strpos($link,'?') === false) $link .= '?'; //If there is no '?' add one at the end
	    elseif(!preg_match('/(\?|\&(amp;)?)$/',$link)) $link .= '&amp;'; //If there is no '&' at the END, add one.
	    
	    $params_arr = array();
	    foreach($params as $key=>$value) {
	        if(gettype($value) == 'array') { //Handle array data properly
	            foreach($value as $val) {
	                $params_arr[] = $key . '[]=' . ($val);
	            }
	        } else {
	            $params_arr[] = $key . '=' . ($value);
	        }
	    }
	    $link .= implode('&amp;',$params_arr);
	    return $link;
	}
	
	static public function baseUrl()
	{
		static $base_url;
		
		if ($base_url) return $base_url;
		
		$url = self::createUrl(array(), false, false);
		$urla = explode('/', $url);
		$url = array_shift($urla);
		if (empty($url))
			$url = array_shift($urla);
		
		$base_url = ((empty($_SERVER['HTTPS']) OR $_SERVER['HTTPS'] === 'off') ? 'http' : 'https').'://';
		$base_url .= $_SERVER['HTTP_HOST'];
		
		$base_url = $base_url.'/'.$url.'/'.Fm::applicationPath().'/';
		
		return $base_url;
	}
}