<?php
class RouteConfig
{
	public static function RegisterRoutes($router)
	{
		$router->AddRoute(array(
						'name'		=> "Default",
						'url'		=> "{page}/{controller}/{action}/{id}",
						'defaults'	=> array('page' => 'Home', 'controller' => 'Home', 'action' => "Index", 'id' => '')
				));
	}
}