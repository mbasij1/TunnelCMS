<?php
class PostEmail extends TCU
{
	private $AdressEmail;
	private $Content;
	private $title;
	
	function SendMail()
	{
		return mail($this->AdressEmail, $this->title, $this->Content);
	}
	
	function SetEmailAdress($address)
	{
		$this->AdressEmail = $address;
	}
	
	function SetCntent($data)
	{
		$this->Content = $data;
	}
	
	function SetTitle($title)
	{
		$this->title = $title;
	}
}
?>