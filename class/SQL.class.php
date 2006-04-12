<?php
error_reporting(E_ALL);
require_once("$Settings[MyDir]/class/Error.class.php");
	abstract class SQL
	{
		//$Settings['DB_User'];
		//$Settings['DB_Password'];
		//$Settings['DB_Name'];
		private static $link = NULL;
		private static function connect()
		{
			global $Settings;
			if(self::$link != NULL)
				return self::$link;
			self::$link = @mysqli_connect('localhost',$Settings['DB_User'],$Settings['DB_Password'], $Settings['DB_Name']);
			if (!self::$link || mysqli_connect_errno(self::$link))
			{
				$error = "Your database seems to be inaccassible! You might fix this by running the <a href=\"$Settings[MyServer]/install.php\">installation</a> again.";
				$debug = "";
				if(!self::$link)
					$debug = Error::getLastError();
				else
					$debug = self::getError();
				Error::assert($error, $debug);
				//echo "Failed to connect to MySQL: " . self::getError();
			}
			return self::$link;
		}
		private static function mysqliErrorCheck($mquery)
		{
			global $Settings;
			if(!$mquery)
			{
				$error = "Your database seems to have problems! You might fix this by running the <a href=\"$Settings[MyServer]/install.php\">installation</a> again.";
				Error::assert($error, "MySQLi tells: ".self::mysqliError());
			}
		}
		private static function mysqliError()
		{
			if(mysqli_error(self::$link) == "")
				return "No MySQL error!";
			return mysqli_error(self::$link);
		}
		private static function getTableName($name)
		{
			global $Settings;
			return $Settings["DB_Prefix"].$name;
		}
		public static function getError()
		{
			return mysqli_error(self::$link);
		}
		public static function escape($s)
		{
			self::connect();
			return mysqli_real_escape_string(self::$link, "$s");
		}
		public static function close()
		{
			mysqli_close(self::$link);
			self::$link = NULL;
		}
		public static function getTable()
		{
			self::connect();
			$args = func_get_args();
			$order = "";
			if(isset($args[1]) && strpos($args[1], "ORDER BY ")===0)
			{
				$order = $args[1];
				$args[1] = $args[count($args)-1];
				unset($args[count($args)-1]);
			}
			$counter = count($args);
			$condition = "";
			for($i = 1; $i < $counter; $i++)
			{
				
				if($i == 1)
					$condition .= "WHERE ";
				$condition .= $args[$i];
				if($i != $counter-1)
					$condition .= " AND ";
			}
			$tableName = self::getTableName($args[0]);
			$query="SELECT * FROM $tableName $condition $order";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			return $mquery;
		}
		public static function getRow($table)
		{
			return mysqli_fetch_array($table);
		}
		public static function getRowCount($table)
		{
			return mysqli_num_rows($table);
		}
		public static function insert($table, $args)
		{
			self::connect();
			$counter = count($args);
			$keys = "";
			$values = "";
			$args_keys = array_keys($args);
			for($i = 0; $i < $counter; $i++)
			{
				$values .= $args[$args_keys[$i]];
				$keys .= "`".$args_keys[$i]."`";
				if($i != $counter-1)
				{
					$values .= ", ";
					$keys .= ", ";
				}
			}
			
			$tableName = self::getTableName($table);
			$query="INSERT INTO $tableName ($keys) VAlUES ($values)";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			return $mquery;
		}
		public static function update($table, $set, $condition)
		{
			self::connect();
			$tableName = self::getTableName($table);
			$update = mysqli_query(self::$link, "UPDATE $tableName SET $set WHERE $condition");
			self::mysqliErrorCheck($update);
			return $update;
		}
		public static function delete($table, $condition)
		{
			self::connect();
			$tableName = self::getTableName($table);
			$update = mysqli_query(self::$link, "DELETE FROM $tableName WHERE $condition");
			self::mysqliErrorCheck($update);
			return $update;
		}
		public static function avg($table, $column, $condition='')
		{
			self::connect();
			$tableName = self::getTableName($table);
			$query="SELECT AVG($column) AS Average FROM $tableName WHERE $condition";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			$avg = self::getRow($mquery);
			return $avg['Average'];
		}
		public static function max($table, $column, $condition='')
		{
			self::connect();
			$tableName = self::getTableName($table);
			$query="SELECT MAX($column) AS Maximum FROM $tableName WHERE $condition";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			$max = self::getRow($mquery);
			return $max['Maximum'];
		}
		public static function min($table, $column, $condition='')
		{
			self::connect();
			$tableName = self::getTableName($table);
			$query="SELECT MIN($column) AS Minimum FROM $tableName WHERE $condition";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			$min = self::getRow($mquery);
			return $min['Minimum'];
		}
		public static function tableExists($table)
		{
			self::connect();
			$tableName = self::getTableName($table);
			$query="SHOW TABLES LIKE '$tableName'";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
			$out = self::getRow($mquery);
			return $out!=NULL;
		}
		public static function tableCheckScheme($table, $scheme)
		{
			self::connect();
			$tableName = self::getTableName($table);
			foreach($scheme as $column => $columnDetail)
			{
				$query="SHOW COLUMNS FROM $tableName WHERE Field='$column'";
				$mquery = mysqli_query(self::$link, $query);
				self::mysqliErrorCheck($mquery);
				if(self::getRowCount($mquery) < 1)
					return $column;
				$row = self::getRow($mquery);
				foreach($columnDetail as $prop => $val)
				{
					if(!isset($row[$prop]) || $row[$prop] != $val)
						return array($column, $prop);
				}
			}
			return NULL;
		}
		public static function createTable($table, $scheme)
		{
			self::connect();
			$tableName = self::getTableName($table);
			$query="CREATE TABLE `$tableName` (";
			foreach($scheme as $column => $columnDetail)
			{
				$query .= "`$column` $columnDetail[Type] $columnDetail[Extra]";
				if($columnDetail["Key"] == "PRI")
					$query .= " PRIMARY KEY";
				$query .= ", ";
			}
			$query = substr($query, 0, strlen($query)-2);
			$query .= ")";
			$mquery = mysqli_query(self::$link, $query);
			self::mysqliErrorCheck($mquery);
		}
	}
?>
