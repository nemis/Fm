<?php

class Pagination
{
	static public function links($current, $all, $perPage=50)
	{
		$view = new View('pagination');
		$view->total_pages = ceil($all / $perPage);
		$view->current_page = $current;
		$view->per_page = $perPage;
		
		$view->previous_page = ($current > 0) ? $current-1 : false;
		$view->next_page = ($current + 1 < $all) ? $current+1 : false;
		
		$view->url = Router::createUrl(array('page' => '{page}'));
		
		return $view->render();
	}
}