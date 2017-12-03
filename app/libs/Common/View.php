<?php
	namespace Libs\Common;

	class View
	{	
		public static $file;
		public static $content;

		public static function set($view, $content = []){
			self::$content = $content; // This variable will be used in the view, so we can use the values of it passed in the controller

			$path = "../app/views/".$view.".tpl.php"; // Dont mind the extension .tpl.php, it's just a conception

			// Checks if the view file exists, if not it returns false, otherwise, it will store the path in the variable file wich will be used in the function render
			if(file_exists($path)) self::$file = $path; else return false; 
		}


		// This function is used in the layout view, which is in the following path: /app/views/site/main/index.tpl.php
		public static function render(){
			//If there is no file path, then it returns false
			if(empty(self::$file)) return false;

			$content = (object) self::$content; // Casting the variable into an object
			include self::$file; // including the view
		}
	}
?>