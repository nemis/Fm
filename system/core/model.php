<?php

class Model
{
	protected $table_name;
	
	public $bean;
	
	protected $iterations;
	
	private $db;
	
	protected $fields;
	
	protected $direction = 'asc';
	protected $orderby = 'id';
	
	protected $limit = 100000;
	protected $offset = 0;
	
	public function __construct($table_name, $id=0, & $db = false)
	{
		if ($id > 0)
		{
			$this->bean = R::load($table_name, $id);
		} else {
			$this->bean = R::dispense($table_name);
		}
		
		$this->table_name = $table_name;
		$this->db = $db;
		if ($id > 0) $this->load($id);
		
		$this->fields = Fm::config('models.'.$table_name);
	}
	
	public function load($id=0)
	{
		$this->bean = R::load($this->table_name, $id);
		return $this->bean;
	}
	
	public function loadMany()
	{
		$this->iterations = (array)R::find($this->table_name, $q = ' 1 order by '.$this->orderby.' '.$this->direction.' limit '.$this->offset.', '.$this->limit);
		return $this->iterations;
	}
	
	public function orderby($orderby, $direction='asc')
	{
		$this->orderby = $orderby;
		$this->direction = $direction;
		return $this;
	}
	
	public function limit($limit, $offset=0)
	{
		$this->limit = $limit;
		$this->offset = $offset;
		return $this;
	}
	
	public function countAll()
	{
		$row = R::getRow('select count(*) as count_all from `'.$this->table_name.'`');
		return (int)$row['count_all'];
	}
	
	public function findAll()
	{
		return $this->loadMany();
	}
	
	public function __get($name)
	{
		return $this->bean->$name;
	}
	
	public function __set($name, $value)
	{
		return $this->bean->$name = $value;
	}
	
	public function tableColumns()
	{
		return array_keys(R::$writer->getColumns($this->table_name));
	}
	
	public function fieldName($column)
	{
		if (isset($this->fields[$column]))
			return $this->fields[$column];
		else
			return $column;
	}
	
	public function save()
	{
		R::store($this->bean);
	}
	
	public function delete()
	{
		R::trash($this->bean);
	}
	
	public function fields()
	{
		if ($this->fields)
		{
			return $this->fields;
		} else {
			return array_combine($this->tableColumns(), $this->tableColumns());
		}
	}
}