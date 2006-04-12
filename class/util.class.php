<?php
	class Util
	{
		public static function includeAll($path)
		{
			global $Settings;
			$includePath = "$Settings[MyDir]/$path/";
			$files = scandir($includePath);
			foreach ($files as $file)
			{
				if($file!="." && $file!=".." && is_file($includePath.$file))
    				require_once($includePath.$file);
    		}
		}
		public static function includeAllCls($path)
		{
			global $Settings;
			$includePath = "$Settings[MyDir]/$path/";
			$files = scandir($includePath);
			$arr = array();
			foreach ($files as $file)
			{
				if($file!="." && $file!=".." && is_file($includePath.$file) && substr(strrev($file), 0, 1) != "~" && $file[0] != ".")
				{	
    				require_once($includePath.$file);
    				$explode = explode(".", $file);
    				$explode2 = $explode[0];
    				$classFromFile = "Mod".$explode2;
    				//echo $classFromFile;
    				$obj = new $classFromFile();
    				$arr[$explode2] = $obj;
    				//array_push($arr, $obj);
    			}
    		}
    		return $arr;
		}
		public static function genURI($repArr, $origArr = NULL)
		{
			$GET = ($origArr===NULL||!is_array($origArr))?($_GET):($origArr);
			if(!isset($GET["page"]))
				$GET["page"] = "Overview";
			$out = "";
			for($i=0; $i<count($GET); $i++)
			{
				$allarrkeys = array_keys($GET);
				$key = $allarrkeys[$i];
				if(!($key == "page" || $key == "prompt"))
				{
					$out .= "$key=";
					if(array_key_exists($key, $repArr))
						$out .= $repArr[$key];
					else
						$out .= $GET[$key];
					if($i != count($GET)-1)
						$out .= "&";
				}
			}
			for($i=0; $i<count($repArr); $i++)
			{
				$out .= "&";
				$allarrkeys = array_keys($repArr);
				$key = $allarrkeys[$i];
				if(!array_key_exists($key, $GET))
				{
					$out .= "$key=$repArr[$key]";
					if($i != count($repArr)-1)
						$out .= "&";
				}
			}/*$GET[page]/*/
			while(strlen($out)>0 && $out{0}=="&")
				$out = substr($out, 1);
			
			while(substr($out, -1)=="&")
				$out = substr($out, 0, -1);
			global $Settings;
			//return "$Settings[MyServer]/!$out/$GET[page]";
			return "$Settings[MyServer]/index.php?page=$GET[page]&$out";
		}
	}
?>
