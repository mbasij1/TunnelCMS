<?php
class Router
{
	private $Routes;
	private $RouteData;
	
	function __construct()
	{
		$this->RouteConfigs();
		$this->parseURL();
	}
	
	public function AddRoute($route)
	{
		$this->Routes[$route['name']] = $route; 
	}
	
	public function Action($action, $controll = null, $page = null, $AdditionalData = null)
	{
		if(!$controll)
			$controll = $this->RouteData['controller'];
		if(!$page)
			$page = $this->RouteData['page'];
		
		foreach ($this->Routes as $route)
		{
			if($route['defaults']['page'] != $page)
				continue;
			
			if($controll != $route['defaults']['controller'])
				continue;
			
			if($action != $route['defaults']['action'])
				continue;
			
			$url = str_replace('{page}', $page, $route['url']);
			$url = str_replace('{controller}', $controll, $url);
			$url = str_replace('{action}', $action, $url);

			foreach($AdditionalData as $key => $value)
			{
				if(strpos($url, $key) === false)
				{
					if($additonal)
						$additonal .= '&'.$key.'='.$value;
					else
						$additonal = '?'.$key.'='.$value;
				}
				else
					$url = str_replace('{'.$key.'}', $value, $url);
			}
			
			return SURL.$url.$additonal;
		}
		
		$url = str_replace('{page}', $page, $route['url']);
		$url = str_replace('{controller}', $controll, $url);
		$url = str_replace('{action}', $action, $url);
		
		foreach($AdditionalData as $key => $value)
		{
			if(strpos($url, $key) === false)
			{
				if($additonal)
					$additonal .= '&'.$key.'='.$value;
				else
					$additonal = '?'.$key.'='.$value;
			}
			else
				$url = str_replace('{'.$key.'}', $value, $url);
		}
			
		return SURL.$url.$additonal;
	}
	
	private function RouteConfigs()
	{
		require ABSPATH.'configs/RouteConfig.php';
		RouteConfig::RegisterRoutes($this);
	}
	
	private function CreateRouteInfo($route, $data)
	{
		$this->RouteData = $route['defaults'];
		$i = 0;
		foreach ($data as $part)
		{
			if($route['partsOfRoutes'][$i] == "")
				return;
			
			if($route['partsOfRoutes'][$i][0] == '{')
			{
				$key = substr($route['partsOfRoutes'][$i], 1, strlen($route['partsOfRoutes'][$i])-2);
				$this->RouteData[$key] = $part;
			}
			$i++;
		}
		//var_dump($this->RouteData);
	}
	
	private function parseURL()
	{
		// URL parts
		$parts = array();
		// Get url
		$url = urldecode($_SERVER["REQUEST_URI"]);
		$url = explode('?', $url)[0];
		// Omit first and last slash
		if(substr($url,0,1) == "/")
			$url = substr($url,1,strlen($url)-1);
	
		if(substr($url,strlen($url)-1,1) == "/")
			$url = substr($url,0,strlen($url)-1);

		// Separate parts
		if(strpos($url, "/") > -1)
			$parts = explode("/", $url);
		
		// TODO: When unset data from $parts should index back zero!  
		for($i = 0; $i < LNS; $i++)
		{
			unset($parts[0]);
			foreach ($parts as $p)
				$h[] = $p;
			
			$parts = $h;
		}

		// Decide Which Route Should Run And Fill IT
		foreach ($this->Routes as $route)
		{
			$partsOfRoutes = explode('/', $route['url']);
			$i = 0;
			foreach ($partsOfRoutes as $routepart)
			{
				if($routepart[0] != '{')
				{
					if($routepart != $parts[$i])
					{
						break;
					}
				}
				else {
					$route['partsOfRoutes'] = $partsOfRoutes;
					$this->CreateRouteInfo($route, $parts);
					return;
				}
					
				$i++;
			}
		}
	}
	
	public function GetRouteInfo()
	{
		return $this->RouteData;
	}
}