<?php
	namespace Core;

	//Libs
	use PDO as PDO;
	
	class Database extends PDO
	{
		static protected $db = null;
		public static $statement = "";

		public static function config($hostname, $dbname, $username, $password){
			if(self::$db === null){			
				try{
		            # MySQL with PDO_MYSQL  
		            self::$db = new PDO("mysql:host=" . $hostname . ";dbname=" . $dbname, $username, $password);
		        }catch (PDOException $e){
		            self::$db = null;
		            die($e->getMessage());
		        }
	        }
		}

		public static function q($query, $parameters = []){
			try {
				self::$statement = self::$db->prepare($query);

				foreach ($parameters as $key => $parameter) {
					self::$statement->bindParam(':' . $key, $parameter[0], $parameter[1]);
				}

				self::$statement->execute();

				return self::$statement;
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}
?>