<?php
////////////////////////////////////////////////////////////
///////////////////// CONTROLLER CMS
///////////////////// CREATED BY MORTEZA BASIJ V 1.5
////////////////////////////////////////////////////////////
class CMSController
{	
	private $Router;
	private $pagecontoller;
	private $EventHandler;
	private $ThemeController;

	function run()
	{
		$this->Router 			= new Router();
		$this->ThemeController	= new ThemeController();
		
		//new Language();
		
		$this->pagecontoller 	= new PageController($this->Router , $this->ThemeController);
		$this->EventHandler		= new EventHandler();
		
		$this->pagecontoller->run();
		
		new BundleHandler();
		
		$this->ThemeController->Run();
	}
}

include(ABSPATH.'core/PageController.php');
include(ABSPATH.'core/Controller.php');
include(ABSPATH.'core/Backgrounds.php');
include(ABSPATH.'core/ThemeController.php');
include(ABSPATH.'core/Loger.php');
include(ABSPATH.'core/Database.php');
include(ABSPATH.'core/EventHandler.php');
include(ABSPATH.'core/Router.php');
include(ABSPATH.'core/HtmlHelper.php');
include(ABSPATH.'core/BundleHandler.php');
//include(ABSPATH.'core/Language.php');
?>