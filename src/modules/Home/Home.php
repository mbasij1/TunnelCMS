<?php
class Home extends Controller
{
	public function Index()
	{
		return $this->View(array("Hello Word"));
	}
}