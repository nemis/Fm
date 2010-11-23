<?php

class Crud
{
	static public $modelName = false;
	static public $perPage = 50;
	
	static public function table($modelName, & $db, $columns=false)
	{
		self::checkSave($modelName, $db);
		self::checkDelete($modelName, $db);
		
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$orderby = (isset($_GET['orderby'])) ? $_GET['orderby'] : 'id';
		
		$model = $db->model($modelName);
		$iterations = $model->orderby($orderby)->limit(self::$perPage, ($page-1)*(self::$perPage))->findAll();

		if (isset($_GET['search']) and is_arary($_GET['search']))
		{
			foreach ($_GET['search'] as $k => $v)
			{
				$model->like($k, $v);
			}
		}
		
		$tableView = new View('crud_table');
		$tableView->iterations = $iterations;
		$tableView->columns = $columns ? $columns : $model->fields();
		$tableView->page = $page;
		$tableView->pagination = Pagination::links($page, $tableView->countAll = $model->countAll(), self::$perPage);
		
		return $tableView->render();
	}
	
	static public function form($modelName, & $db, $id)
	{
		self::checkSave($modelName, $db);
		
		$model = $db->model($modelName, $id);
		$formView = new View('crud_form');
		$formView->model = $model;
		
		return $formView->render();
	}
	
	static public function checkSave($modelName, & $db)
	{
		if (!isset($_POST['data']) or !isset($_POST['id']))
			return false;
			
		$model = $db->model($modelName, (int)$_POST['id']);
		$model->bean->import($_POST['data']);
		$model->save();
		
		return true;
	}
	
	static public function checkDelete($modelName, & $db)
	{
		if (isset($_GET['ids']) and isset($_GET['delete']))
		{
			foreach ($_POST['ids'] as $id => $v)
			{
				if ($v == 'on')
				{
					$model = $db->model($modelName, (int)$id);
					$model->delete();
				}
			}
		}
	}
}