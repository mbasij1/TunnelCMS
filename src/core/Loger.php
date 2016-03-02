<?php
class loger
{
	function Add($class , $function , $content)
	{
		$fp = fopen('log.xml','a');
		fwrite($fp,'<log class="'.$class.'" function="'.$function.'"  date="'.date('Y - m - d').'">'.$content.'</log>');
		fclose($fp);
	}
	
	function timetracker($time)
	{
		$fp = fopen('executetimes.html','a');
		fwrite($fp,$time.'" D&T is = "'.date('Y - m - d').'" <br />');
		fclose($fp);
	}
}
?>