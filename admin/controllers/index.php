<?php

class Index_Controller extends Controller
{
	public $template = 'main';
	
	public function index()
	{

	}
	
	public function staticeditor()
	{
		$this->checksavestatic();
		
		$this->template->content = $this->view('staticeditor');
	}
	
	public function checksavestatic()
	{
		if (isset($_POST['body']) and isset($_POST['name']))
		{
			$staticpage = $this->model('staticpage');
			//$staticpage->where('name', $_POST['name']);
			$staticpage->load();
			
			$staticpage->name = $_POST['name'];
			$staticpage->body = $_POST['body'];
			$staticpage->save();
		}
	}
	
	public function crud($model)
	{
		if (!isset($_GET['id']))
			$this->template->content = Crud::table($model, $this->db);
		else
			$this->template->content = Crud::form($model, $this->db, (int)$_GET['id']);
	}
}