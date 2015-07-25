<?php
namespace component;

class Router
{
	private $routerSet;
	
	public function __construct(){
		$this->serverPathInfo = $_SERVER['PATH_INFO'];
	}
	
	public function add($router,$callback)
	{
		$this->routerSet[]=array('router'=>$router,'callback'=>$callback);
	}
	
	public function run()
	{
		$matcher = false;
		foreach($this->routerSet as $routerRow){
			if(preg_match($routerRow['router'],$this->serverPathInfo)){
				$routerRow['callback']();
				$matcher = true;
			}
			
		}
		if(false === $matcher){
			echo 'default';
		}
	}

}