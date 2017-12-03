<?php
	namespace Core;

	//Libs
	use \Libs\Common\Functions as Functions;
	use \Libs\Common\Session as Session;

	//Models
	use \Models\Common\ControllerPermalink as ControllerPermalink;

	class App
	{	
		public $controller, $method = "index", $params = [], $app_data, $controller_name, $method_name = "index";

		public function __construct($app_area){
			$this->controller = "homepage";
			$this->controller_name = "homepage";

			$url = $this->parseUrl();
			if(isset($url[0])) $this->controller_name = $url[0];


			if(class_exists('\\Controllers\\'.ucfirst($app_area).'\\'. $url[0])){
				$this->controller = $url[0];
				unset($url[0]);
			}

			$class = '\\Controllers\\'.ucfirst($app_area).'\\' . $this->controller;
			$this->controller = new $class;



			//GET THE METHOD OF THE CONTROLLER
			if(isset($url[1])){
				if(method_exists($this->controller, $url[1])){
					$this->method = $url[1];
					$this->method_name = $url[1];
					unset($url[1]);
				}
			}
			//GET EXTRA PARAMS
			$this->params = $url ? array_values($url) : [];
			
			
			//CALLS THE CLASS AND IS METHOD AND PASSES PARAMS TO THE METHOD IF THEY EXIST
			call_user_func_array([$this->controller, $this->method], $this->params);
		}


		private function parseUrl(){
			if(isset($_GET['url']) && !empty($_GET['url'])){
				$url = explode("/", filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL));
				return $url;
			}
		}

		private function getAppData(){
			return \Models\Common\App_Data::getInfo();
		}
	}
?>