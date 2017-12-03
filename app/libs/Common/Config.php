<?php
	namespace Libs\Common;

	class Config
	{
		protected static $file;
		protected static $default;
		public static $data;

		public static function load($file){
			$file = require $file;
			self::$data = $file;
		}

		public static function get($key, $default = null){
			self::$default = $default;

			$segments = explode(".", $key);

			$data = self::$data;

			foreach ($segments as $segment) {
				if(isset($data[$segment])){
					$data = $data[$segment];
				}else{
					$data = self::$default;
					break;
				}
			}

			return $data;
		}
	}
?>