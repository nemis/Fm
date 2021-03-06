<?php

class Db
{
	public $queryWriter;
	
	public function __construct()
	{
		require_once("system/vendor/rb.php");
	}
	
	public function connect($user, $host, $pass, $db, $type='mysql')
	{
		R::setup("$type:host=$host;dbname=$db",$user,$pass);
		//R::freeze();
	}
	
	public function __call($name, $vars)
	{
		if (isset($vars[0]))
			return $this->loadModel($name, $vars[0]);
		else
			return $this->loadIterations($name);
	}
	
	private function loadIterations($name)
	{
		$model = new Model($name);
		$iterations = $model->loadMany($name);
		return $iterations;		
	}
	
	private function loadModel($name, $id=0)
	{
		$model = new Model($name, $id);
		$model->load($id);
		return $model;
	}
	
	public function model($name, $id=0)
	{
		return $this->loadModel($name, $id);
	}
}