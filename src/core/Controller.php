<?php
class Controller
{
	protected	$ThemeController;
	protected	$Router;
	protected 	$RouteData;
	protected	$Backgrounds;
	private		$Position;
	
	public function __construct($position, $themeController, $router, $routeData, $backgrounds)
	{
		$this->Position			= $position;
		$this->ThemeController	= $themeController;
		$this->RouteData		= $routeData;
		$this->Backgrounds 		= $backgrounds;
		$this->Router			= $router;
	}
	
	protected function Background($name)
	{
		return $this->Backgrounds[$name];
	}
	
	protected function Redirect($address)
	{
		header("Location: " . $address);
		exit;
	}
	
	protected function RedirectToAction($action, $controll = null, $page = null, $AdditionalData = null)
	{
		if(!$controll)
			$controll = get_class($this);
		
		$this->Redirect(
				$this->Router->Action($action, $controll, $page, $AdditionalData));
	}
	
	protected function View($data, $name = '')
	{
		if($name == null || $name == '')
			$name = $this->RouteData['action'];
		
		$this->ThemeController->View($this->Position, $this->RouteData['controller'], $name, $data);
	}
}