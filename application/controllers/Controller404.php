<?php

namespace application\controllers;
use application\core\Controller;

class Controller404 extends Controller
{
	
	function action_index()
	{
		$this->view->render('404_view.php', 'template_view.php');
	}

}
