<?php

class Testd_Controller extends Controller
{
	public $template = 'test';
	
	public function foo()
	{
		// @TODO: zostawic tak czy zrobic $this->content()->view()-> ????
		// @TODO: cachowanie widokow wedlug zmian w db?
		
		$users = $this->db->users();
	}
	
	public function bar()
	{
		echo $this->view('test');
	}
}