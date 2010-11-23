<?php

class Controller
{
	public $db;
	public $application;
	
	public $template = false;
	public $headers = false;
	
	public function __initialize_controller()
	{
		$this->headers = new Headers();
	}
	
	public function __loadView()
	{
		if ($this->template)
		{
			$this->template = $this->view($this->template, array(), false);
		}
	}
	
	public function view($viewFile=false, $vars=array(), $autoRender=false)
	{
		$view = new View($viewFile);
		$view->db =& $this->db;
		$view->vars = $vars;
		$view->controller =& $this;
		$view->application =& $this->application;
		
		if ($autoRender)
		{
			return $view->render();
		} else {
			return $view;
		}
	}
	
	public function __toString()
	{
		$body = $this->template->render();
		
		$header = $this->view('xhtml_head');
		$header->title = $this->headers->title;
		$header->description = $this->headers->description;
		$header->keywords = $this->headers->keywords;
		
		$footer = $this->view('xhtml_end');
		
		return $header."\n".$body."\n".$footer;
	}
	
	public function model($table_name, $id=0)
	{
		return $this->db->model($table_name, $id);
		
		/*
		$model = new Model($table_name, $id=0, & $this->db);
		return $model;
		*/
	}
}