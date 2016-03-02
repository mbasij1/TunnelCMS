<?php
class Backgrounds
{
	private $Router;
	
	public function __construct($router)
	{
		$this->Router = $router;
	}
	
	protected function Redirect($address)
	{
		header("Location: " . $address);
		exit;
	}
	
	protected function RedirectToAction($action, $controll = null, $page = null, $AdditionalData = null)
	{
		$this->Redirect(
				$this->Router->Action($action, $controll, $page, $AdditionalData));
	}
}