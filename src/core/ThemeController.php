<?php
////////////////////////////////////////////////////////////
///////////////////// THEMPLETE CONTROLLER
///////////////////// CREATED BY MORTEZA BASIJ V 1.2
////////////////////////////////////////////////////////////
class ThemeController
{
	private $themename;
	private $themepage;
	private $namepage;
	private $content;
	private $blockread;
	
	public function __construct()
	{
		$this->themename = 'default';
		$this->namepage = '';
	}
	
	public function SetTheme($themename , $page)
	{
		// TODO: Check Theme Exist if not exist set default again or throw exception
		$this->themename = $themename;
		$this->themepage = $page;
	}
	
	public function Namepage($name)
	{
		$this->namepage .= $name;
	}
	
	public function SetReNamepage($name)
	{
		$this->namepage = $name;
	}
	
	public function View($position, $ControllName, $ViewName, $model)
	{
		// TODO: I Don't know what want do!
		$this->content[$position][] = array('ControllName' => $ControllName, 'ViewName' => $ViewName, 'model' => $model);
	}
	
	private function DisplayView($view)
	{
		// TODO: Decide Which use view plugin!
		$model = $view['model'];
		
		if(file_exists(ABSPATH.'themplete/' . $this->themename . '/Views/' . $view['ControllName'] . '/' . $view['ViewName'] . '.php'))
			include ABSPATH.'themplete/' . $this->themename . '/Views/' . $view['ControllName'] . '/'.$view['ViewName'].'.php';
		else if(file_exists(ABSPATH.'themplete/' . $this->themename . '/Views/Shared/' . $view['ViewName'] . '.php'))
			include ABSPATH.'themplete/' . $this->themename . '/Views/Shared/'.$view['ViewName'].'.php';
		else if(file_exists(ABSPATH . 'themplete/default/Views/' . $view['ControllName'] . '/' .$view['ViewName'] . '.php'))
			include ABSPATH . 'themplete/default/Views/' . $view['ControllName'] . '/' . $view['ViewName'] . '.php';
		else if(file_exists(ABSPATH . 'themplete/default/Views/Shared/' .$view['ViewName'] . '.php'))
			include ABSPATH . 'themplete/default/Views/Shared/' . $view['ViewName'] . '.php';
		else
			$this->ThrowErrorPage();
	}
	
	function GetNamePage()
	{
		return $this->namepage;
	}
	
	public function GetContent($position)
	{
		if($this->blockread[$position] == NULL)
			$this->blockread[$position] = 0;
		
		if(($view = $this->content[$position][$this->blockread[$position]]) != NULL)
		{
			$this->blockread[$position]++;
			
			$this->DisplayView($view);
			return true;
		}
		return false;
	}
	
	public function ResetContent($position)
	{
		$this->blockread[$position] = 0;
	}
	
	public function Run()
	{
		if($this->themepage != "" and file_exists(ABSPATH.'themplete/'.$this->themename.'/'.$this->themepage.'.php') )
			include(ABSPATH.'themplete/'.$this->themename.'/'.$this->themepage.'.php');
		else if(file_exists(ABSPATH.'themplete/'.$this->themename.'/index.php'))
			include(ABSPATH.'themplete/'.$this->themename.'/index.php');
		else
			$this->ThrowErrorPage(); // Theme Not Found
	}
	
	public function ThrowErrorPage($errornumber = '404')
	{
		include(ABSPATH.'themplete/system/error'.$errornumber.'.php');
		exit();
	}
}
?>