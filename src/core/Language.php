<?php
class Language
{
	public function __construct()
	{
		global $_;
		$_ = array();
	}
	
	public static function AddTranslate($TranslateArray)
	{
		global $_;
		$_ = array_merge($_, $TranslateArray);
	}
	
	public static function AddFile($file) {
		if(file_exists($file))
		{
			include_once $file;
			self::AddTranslate($translate);
		}
	}
}