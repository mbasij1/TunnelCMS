<?php
class EventHandler
{
	private static $Events;
	
	public static function AddEvent($event, $func, $spacename = 'default')
	{
		self::$Events[$event][] = $func;
	}
	
	public static function Action($event, $parametrs)
	{
		foreach	(self::$Events[$event] as $func)
		{	
			return $func($parametrs);
		}
	}
}