<?php
class BundleConfig
{
	// For more information on bundling, visit http://go.microsoft.com/fwlink/?LinkId=301862
	public static function RegisterBundles()
	{
		BundleHandler::Register('script', 'Jquery', array('~/scripts/jquery-1.10.2.min.js'));
	}
}