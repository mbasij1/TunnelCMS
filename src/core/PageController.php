<?php
class PageController
{
	private $Router;
	private $RouteInfo;
	private $PageControlls;
	private $BackgroundControlls;
	private $ThemeController;
	private $Modules;
	private $Backgrounds;
	
	function __construct($router, $themecontroll)
	{
		$this->Router = $router;
		$this->RouteInfo = $this->Router->GetRouteInfo();
		$this->ThemeController = $themecontroll;
		$this->setpage();
	}
	
	function setpage()
	{
		//TODO: Read This Data From XML File And Set Them
		if(!$this->RouteInfo['page'])
			$this->page = 'Home';
		else
			$this->page = $this->RouteInfo['page'];

		if(!file_exists(ABSPATH.'page/'.$this->page.'.ps.php'))
			$this->ThemeController->ThrowErrorPage();
		
		if(file_exists(ABSPATH.'page/Shared.ps.php'))
			include(ABSPATH.'page/Shared.ps.php');
		
		include(ABSPATH.'page/'.$this->page.'.ps.php');
	}
	
	function run()
	{
		foreach ($this->BackgroundControlls as $controller)
		{
			require_once ABSPATH . 'modules/' . $controller['controller'] . '/' . $controller['controller'] . '.bg.php';
			$classname = $controller['controller'] . '_BG';
			$this->Backgrounds[$controller['controller']] = new $classname($this->Router);
			$this->Backgrounds[$controller['controller']]->$controller['controller']();
		}
		
		foreach ($this->PageControlls as $position => $controlls)
		{
			foreach ($controlls as $controll)
			{
				require_once ABSPATH . 'modules/' . $controll['controller'] . '/' . $controll['controller'] . '.php';
				
				if(strtolower($controll['controller']) == strtolower($this->RouteInfo['controller']) )
				{
					$this->Modules[$controll['controller']] = new $controll['controller']($position, $this->ThemeController, $this->Router, $this->RouteInfo, $this->Backgrounds);
					$actionname = $this->RouteInfo['action'];
					$this->Modules[$controll['controller']]->$actionname();
				}
				else
				{
					$this->Modules[$controll['controller']] = new $controll['controller']($position, $this->ThemeController, $this->Router, $controll, $this->Backgrounds);
					$this->Modules[$controll['controller']]->$controll['action']();
				}
			}
		}
	}
	
	function SetThemeplete($name, $page = "")
	{
		$this->ThemeController->SetTheme($name,$page);
	}
	
	function SetController($position, $Controller)
	{
		$this->PageControlls[$position][] = $Controller;
	}
	
	function BackgroundLoader($Controller)
	{
		$this->BackgroundControlls[] = $Controller;
	}
	
	function namepage($name)
	{
		$this->ThemeController->namepage($name);
	}

}
?>