<?php

class Model
{
	private $table_name;
	
	private $bean;
	private $iterations;
	
	public function __construct($table_name)
	{
		$this->table_name = $table_name;
	}
	
	public function load($id)
	{
		$this->bean = R::load($this->table_name, $id);
		return $this->bean;
	}
	
	public function loadMany()
	{
		$this->iterations = (array)R::find($this->table_name);
		return $this->iterations;
	}
	
	public function __get($name)
	{
		return $this->bean->$name;
	}
}