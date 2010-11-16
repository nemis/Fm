<?php

class Test_Controller extends Controller
{
	public function foo()
	{
		// @TODO: zostawic tak czy zrobic $this->content()->view()-> ????
		// @TODO: cachowanie widokow wedlug zmian w db?
		
		$users = $this->db->users();
		$this->contents($this->view('test', array(
			'info' => $users[3]->username,
		)));
	}
	
	public function bar()
	{
		echo $this->view('test');
	}
}