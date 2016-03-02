<?php
class BundleHandler
{
	protected static $bundels;
	
	public function __construct()
	{
		if(file_exists(ABSPATH.'configs/BundleConfig.php'))
		{
			include ABSPATH.'configs/BundleConfig.php';
			BundleConfig::RegisterBundles();
		}
	}
	
	/**
	 * 
	 * @param $type 'script' || 'style'
	 * @param bundlename $name
	 * @param filename $files
	 */
	public static function Register($type, $name, $files)
	{
		self::$bundels[$type][$name] = $files;
	}
}

class Style extends BundleHandler
{
	public static function Render($name)
	{
		foreach (self::$bundels['style'][$name] as $file)
			echo str_replace('~', SURL,'<link rel="stylesheet" type="text/css" href="' . $file . '">');
	}
}

class Script extends BundleHandler
{
	public static function Render($name)
	{
		foreach (self::$bundels['script'][$name] as $file)
			echo str_replace('~', SURL, '<script type="text/javascript" src="' . $file . '"></script>');
	}
}