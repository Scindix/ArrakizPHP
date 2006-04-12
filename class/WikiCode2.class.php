<?php
use \CodeHelper as CH;
class WikiCode2
{
	private $pCode;
	private $index = 0;
	private $languageArray = array();
	private $magicWords = array();
	private $unorderedState = 0;
	private $orderedState = 0;
	private $tableState = 0;
	private $splitState = false;
	private $breakListing = true;
	private	$count = 0;
	function __construct($code)
	{
		$this->pCode = "\n\n$code\n\n@EOF@";
		$this->languageArray = array(			
			"Header"        => array("\n=", "=\n",       function(){return $this->parse_Header();},            "h1"),
			"Indent"        => array("\n:", "\n",        function(){return $this->parse_Indent();},            "span"),
			"Definition"    => array("\n;", "\n",        function(){return $this->parse_Def();},               "dl"),
			"Paragraphs"    => array("\n\n","\n\n",      function(){return $this->parse_Paragraphs();},        "p"),
			"Comment"       => array("!!","\n",          function(){return $this->parse_Comment();},           "!--"),
			"Template"      => array("<:",":>",          function(){return $this->parse_Comment();},           "!--"),
			"Link"          => array("[[","]]",          function(){return $this->parse_Link();},              "a"),
			"InlineLink"    => array("http://"," ",      function(){return $this->parse_InlineLink();},        "a"),
			
			"Bold"          => array("**", "**",         function(){return $this->parseTag("Bold");},          "b"),
			"Bolder"        => array("***", "***",       function(){return $this->parseTag("Bolder");},        "span class=\"font-bolder\""),
			"Light"         => array("..", "..",         function(){return $this->parseTag("Light");},         "span class=\"font-lighter\""),
			"Underline"     => array("__", "__",         function(){return $this->parseTag("Underline");},     "u"),
			"Italics"       => array("//", "//",         function(){return $this->parseTag("Italics");},       "i"),
			"Strikethrough" => array("--", "--",         function(){return $this->parseTag("Strikethrough");}, "del"),
			"InlineSuper"   => array("^", " ",           function(){return $this->parse_InlineSuper();},       "sup"),
			"Superscript"   => array("^^", "^^",         function(){return $this->parseTag("Superscript");},   "sup"),
			"Subscript"     => array(",,", ",,",         function(){return $this->parseTag("Subscript");},     "sub"),
			"Monospace"     => array("##", "##",         function(){return $this->parseTag("Monospace");},     "code"),
			
			"Label"         => array("[(", ")]",         function(){return $this->parseClass("Label", "label");},     "span"),
			"Badge"         => array("(&", "&)",         function(){return $this->parseTag("Badge");},     "span"),
			
			"Ldash"         => array("---", "",          function(){return $this->parseSimple("Ldash");},      "&mdash;"),
			"Horizontal"    => array("----", "",         function(){return $this->parseSimple("Horizontal");}, "<hr>"),
			"Break"         => array("\\\\", "",         function(){return $this->parseSimple("Break");},      "<br>"),
			"Hellipse"      => array("...", "",          function(){return $this->parseSimple("Hellipse");},   "&hellip;"),
			
			"Explanation"   => array('??', '??',         function(){return $this->parseInlineDesc("Explanation", "explanation-text");},    "span class=\"explanation\""),
			"Cite"          => array('""', '""',         function(){return $this->parseInlineDesc("Cite", "cite-author", "&quot;");},      "cite"),
			"Quote"         => array('"""', '"""',       function(){return $this->parseInlineDesc("Quote", "quote-author", "&quot;");},    "blockquote"),
			
			"Ordered"       => array("\n#" , "\n\n",     function(){return $this->parse_Ordered();},           "ol"),
			"Unordered"     => array("\n*" , "\n\n",     function(){return $this->parse_Unordered();},         "ul"),
			"Table"         => array("\n|" , "\n\n",     function(){return $this->parse_Table();},             "table"),
			
			"Plugin"        => array("<<"  , ">>",       function(){return $this->parse_Plugin();},            "div"),
			"Img"           => array("{{"  , "}}",       function(){return $this->parse_Img();},               "img"),
			"Pre"           => array("{{{" , "}}}",      function(){return $this->parse_Pre();},               "pre"),
			"Nothing"       => array("({" , "})",        function(){return $this->parseNothing("Nothing");},   "span"),
			"Special"       => array("%" , " ",          function(){return $this->parse_Special();},           "code"),
			"Magic"         => array("@@" , "@@",        function(){return $this->parse_Magic();},             "code"),
			
			"MathML"        => array("$$", "$$",         function(){return $this->parseTag("MathML");},        "math")
		);
		$this->magicWords = array(
			"Date" =>	function(){return date('Y-m-d');},
			"Server" =>	function(){return $GLOBALS["Settings"]["MyServer"];}
		);
	}
	public function parse()
	{
		$this->pCode = $this->replace("\r", "\n", $this->pCode);
		$this->index = 0;
		return $this->parseR("@EOF@");
	}
	private function parseR($escapeSeq)
	{
		echo "<br>parseR:".$escapeSeq.":<br>";
		$retVal = "";
		$posEscape = strpos($this->pCode, $escapeSeq, $this->index);
		$next = $this->findNextTag($this->index);
		while($next[0] < $posEscape)
		{
			echo $posEscape."->".substr($this->pCode,$posEscape-1,10)."->".$this->index."<br>";
			$retVal .= $this->parseLimited(substr($this->pCode, $this->index, $next[0]-$this->index));
			$this->index = $next[0]+1;
			echo "<pre>";
			print_r($next[1]);
			echo "</pre>";
			$retVal .= $next[1][2]();
			if($this->index > strlen($this->pCode))	break;
			$posEscape = strpos($this->pCode, $escapeSeq, $this->index);
			$next = $this->findNextTag($this->index);
			if($next[0] === -1)
				break;
			if($this->count++ > 50)
				break;
		}
		$retVal .= $this->parseLimited(substr($this->pCode, $this->index, $posEscape-$this->index));
		$this->index = $posEscape+strlen($escapeSeq);
		return $retVal;
	}
	private function findNextTag($begin)
	{
		$posOut = -1;
		$tagOut = NULL;
		foreach($this->languageArray as $value)
		{
			echo "[".$value[0]."]<br>";
			$pos = strpos($this->pCode, $value[0], $begin);
			if($pos === False)
				continue;
			if($posOut == -1)
				$posOut = $pos;
			$posOut = min($posOut, $pos);
			if($pos == $posOut)
				$tagOut = $value;
		}
		return array($posOut, $tagOut);
	}
	private function parseLimited($string)
	{
		$ret = $string;		
		$ret = $this->replace("----", "<hr>",     $ret);
		$ret = $this->replace("---",  "&mdash;",  $ret);
		$ret = $this->replace("--",   "&ndash;",  $ret);
		$ret = $this->replace("\\\\", "<br>",     $ret);
		$ret = $this->replace("...",  "&hellip;", $ret);
		$ret = $this->replace("(c)",  "&copy;",   $ret);
		$ret = $this->replace("(C)",  "&copy;",   $ret);
		$ret = $this->replace("(r)",  "&reg;",    $ret);
		$ret = $this->replace("(R)",  "&reg;",    $ret);
		$ret = $this->replace("(tm)", "&trade;",  $ret);
		$ret = $this->replace("(TM)", "&trade;",  $ret);
		$ret = $this->replace("1/2",  "&frac12;", $ret);
		$ret = $this->replace("1/3",  "&frac13;", $ret);
		$ret = $this->replace("1/4",  "&frac14;", $ret);
		$ret = $this->replace("1/5",  "&frac15;", $ret);
		$ret = $this->replace("1/6",  "&frac16;", $ret);
		$ret = $this->replace("1/8",  "&frac18;", $ret);
		$ret = $this->replace("2/3",  "&frac23;", $ret);
		$ret = $this->replace("2/5",  "&frac25;", $ret);
		$ret = $this->replace("3/4",  "&frac34;", $ret);
		$ret = $this->replace("3/5",  "&frac35;", $ret);
		$ret = $this->replace("3/8",  "&frac38;", $ret);
		$ret = $this->replace("4/5",  "&frac45;", $ret);
		$ret = $this->replace("5/6",  "&frac56;", $ret);
		$ret = $this->replace("5/8",  "&frac58;", $ret);
		$ret = $this->replace("7/8",  "&frac78;", $ret);
		$ret = $this->replace(":-)", "<div class=\"sm sm-0-0\"></div>",  $ret);
		$ret = $this->replace(";-)", "<div class=\"sm sm-1-0\"></div>",  $ret);
		$ret = $this->replace("8-)", "<div class=\"sm sm-2-0\"></div>",  $ret);
		$ret = $this->replace("X-)", "<div class=\"sm sm-3-0\"></div>",  $ret);
		
		$ret = $this->replace(":-(", "<div class=\"sm sm-0-1\"></div>",  $ret);
		$ret = $this->replace(";-(", "<div class=\"sm sm-1-1\"></div>",  $ret);
		$ret = $this->replace("8-(", "<div class=\"sm sm-2-1\"></div>",  $ret);
		$ret = $this->replace("X-(", "<div class=\"sm sm-3-1\"></div>",  $ret);
		
		$ret = $this->replace(":-/", "<div class=\"sm sm-0-2\"></div>",  $ret);
		$ret = $this->replace(";-/", "<div class=\"sm sm-1-2\"></div>",  $ret);
		$ret = $this->replace("8-/", "<div class=\"sm sm-2-2\"></div>",  $ret);
		$ret = $this->replace("X-/", "<div class=\"sm sm-3-2\"></div>",  $ret);
		
		$ret = $this->replace(":-|", "<div class=\"sm sm-0-3\"></div>",  $ret);
		$ret = $this->replace(";-|", "<div class=\"sm sm-1-3\"></div>",  $ret);
		$ret = $this->replace("8-|", "<div class=\"sm sm-2-3\"></div>",  $ret);
		$ret = $this->replace("X-|", "<div class=\"sm sm-3-3\"></div>",  $ret);
		
		$ret = $this->replace(":-P", "<div class=\"sm sm-0-4\"></div>",  $ret);
		$ret = $this->replace(";-P", "<div class=\"sm sm-1-4\"></div>",  $ret);
		$ret = $this->replace("8-P", "<div class=\"sm sm-2-4\"></div>",  $ret);
		$ret = $this->replace("X-P", "<div class=\"sm sm-3-4\"></div>",  $ret);
		
		$ret = $this->replace(":-O", "<div class=\"sm sm-0-5\"></div>",  $ret);
		$ret = $this->replace(";-O", "<div class=\"sm sm-1-5\"></div>",  $ret);
		$ret = $this->replace("8-O", "<div class=\"sm sm-2-5\"></div>",  $ret);
		$ret = $this->replace("X-O", "<div class=\"sm sm-3-5\"></div>",  $ret);
		
		$ret = $this->replace(":-D", "<div class=\"sm sm-0-6\"></div>",  $ret);
		$ret = $this->replace(";-D", "<div class=\"sm sm-1-6\"></div>",  $ret);
		$ret = $this->replace("8-D", "<div class=\"sm sm-2-6\"></div>",  $ret);
		$ret = $this->replace("X-D", "<div class=\"sm sm-3-6\"></div>",  $ret);
		return $ret;
	}
	private function parseTag($key)
	{
		$this->index+=strlen($this->languageArray[$key][0])-1;
		$s = $this->parseR($this->languageArray[$key][1]);
		$tag = $this->languageArray[$key][3];
		$tags = explode(" ", $tag);
		$firstTag = $tags[0];
		return "<$tag>$s</$firstTag>";
	}
	private function parseClass($key, $base)
	{
		$this->index+=strlen($this->languageArray[$key][0])-1;
		$className = "";
		if(strpos($this->pCode, $this->languageArray[$key][1], $this->index) > strpos($this->pCode, "|", $this->index))
		{
			$className = " ".substr($this->pCode, $this->index, strpos($this->pCode, "|", $this->index)-$this->index);
			$this->index+=strlen($className);
		}
		$s = $this->parseR(")");
		$tag = $this->languageArray[$key][3];
		$tags = explode(" ", $tag);
		$firstTag = $tags[0];
		return "<$tag class=\"$base$className\">$s</$firstTag>";
	}
	private function parseSimple($key)
	{
		$this->index+=strlen($this->languageArray[$key][0])-1;
		$tag = $this->languageArray[$key][3];
		return "$tag";
	}
	private function parse_InlineSuper()
	{
		$s = substr($this->pCode, $this->index, strpos($this->pCode, " ", $this->index)-$this->index);
		$this->index+=strlen($s);
		return "<sup>$s</sup>";
	}
	private function parse_Magic()
	{
		$this->index++;
		$s = substr($this->pCode, $this->index, strpos($this->pCode, "@@", $this->index)-$this->index);
		$this->index+=strlen($s)+2;
		if(isset($this->magicWords[$s]))
			return $this->magicWords[$s]();
		else
			return "@@$s@@";
	}
	private function parse_Special()
	{
		$space = strpos($this->pCode, " ", $this->index);
		$perc  = strpos($this->pCode, "%", $this->index);
		$offset = (($space>$perc)?($perc):($space))-$this->index;
		if($perc===False)
			$offset = $space-$this->index;
		$s = substr($this->pCode, $this->index, $offset);
		$this->index+=strlen($s);
		if($space<$perc)
			$this->index++;
		if($s=="")
			return "%";
		elseif(is_numeric($s{0}))
			return "&#$s;";
		else
			return "&$s;";
	}
	private function parse_Plugin()
	{
		$this->index++;
		$s = substr($this->pCode, $this->index, strpos($this->pCode, ">>", $this->index)-$this->index);
		$this->index+=strlen($s)+2;
		//$args = explode("|", $s);
		//$o = new CH\AlbumView(1);
		//return $o->printOut();
				//$str = "CH\\".$args[0];
				//$obj = new $str($args[1]);
				//return $obj->printOut();
		return CH\parse($s);
	}
	private function parse_Header()
	{
		echo "<br>".$this->index;
		$this->index++;
		echo "<br>".$this->index;
		$s = substr($this->pCode, $this->index, strpos($this->pCode, "\n", $this->index)-$this->index);
		echo "<br>".$this->index;
		$n = 1;
		echo "<br>".$this->index;
		$this->index+=strlen($s);
		echo "<br>".$this->index;
		while($s{0}=="=")
		{
		echo "<br>".$this->index;
			$n++;
		echo "<br>".$this->index;
			$s = substr($s, 1);
		echo "<br>".$this->index;
		}
		echo "<br>".$this->index;
		$s .= "\n";
		echo "<br>".$this->index;
		$s = $this->replace("=\n", "\n",$s);
		echo "<br>".$this->index;
		return "<h$n>$s</h$n>";
	}
	private function parse_Indent()
	{
		$this->index++;
		$s = $this->parseR("\n");
		$this->index--;
		$n = 1;
		while($s{0}==":")
		{
			$n++;
			$s = substr($s, 1);
		}
		$s .= "\n";
		$n *=20;
		$n .="px";
		return "<br><span style=\"margin-left: $n\">$s</span>";
	}
	private function parse_Def()
	{
		$this->index++;
		$s = $this->parseR("\n:");
		$def = $this->parseR("\n");
		$this->index--;
		return "<br><dl><dt>$s</dt><dd>$def</dd></dl>";
	}
	private function parse_Link()
	{
		$s = substr($this->pCode, $this->index+1, strpos($this->pCode, "]]", $this->index)-$this->index-1);
		$this->index+=strlen($s)+3;
		$a = explode("|", $s);
		if(count($a)==1)
		{
			$a = $a[0];
			return $this->genLink("$a", "$a");
		} else
		{
			$a0 = $a[0];
			$a1 = $a[1];
			return $this->genLink("$a0", "$a1");
		}
	}
	private function parse_InlineLink()
	{
		$s = substr($this->pCode, $this->index-1, strpos($this->pCode, " ", $this->index)-$this->index+1);
		$this->index+=strlen($s)-1;
		return $this->genLink("$s", "$s");
	}
	private function genLink($link, $text)
	{
		if(strpos($link, "://")===False)
		{
			return "<a href=\"".\Util::genURI(array(),array("page"=>$link))."\">$text</a>";
		} else
		{
			return "<a href=\"$link\">$text</a>";
		}
	}
	private function genImage($link)
	{
		if(strpos($link, "://")===False)
		{
			global $Settings;
			$file = "$Settings[MyServer]/".getFile($link);
			return "<img src=\"$file\">";
		} else
		{
			return "<img src=\"$link\">";
		}
	}
	private function parse_Comment()
	{
		$this->index = strpos($this->pCode, "\n", $this->index);
		return "";
	}
	private function parseNothing($key)
	{
		$this->index+=strlen($this->languageArray[$key][0])-1;
		$this->breakListing = false;
		$s = $this->parseR($this->languageArray[$key][1]);
		$this->breakListing = true;;
		$this->index+=1;
		return $s;
	}
	private function parse_Pre()
	{
		$s = substr($this->pCode, $this->index+2, strpos($this->pCode, "}}}", $this->index)-$this->index-2);
		$this->index = strpos($this->pCode, "}}}", $this->index)+3;
		return "<pre>$s</pre>";
	}
	private function parse_Img()
	{
		$s = substr($this->pCode, $this->index+1, strpos($this->pCode, "}}", $this->index)-$this->index-1);
		$this->index = strpos($this->pCode, "}}", $this->index)+2;
		return $this->genImage($s);
	}
	private function parseInlineDesc($key, $inlineClass, $surround = "")
	{
		$tag = $this->languageArray[$key][3];
		$tags = explode(" ", $tag);
		$firstTag = $tags[0];
		$s = substr($this->pCode, $this->index-1+strlen($this->languageArray[$key][1]), strpos($this->pCode, $this->languageArray[$key][1], $this->index)-$this->index+1-strlen($this->languageArray[$key][1]));
		$this->index+=strlen($s)-1+2*strlen($this->languageArray[$key][1]);
		$a = explode("|", $s);
		if(count($a)==1)
		{
			$a0 = $a[0];
			return "<$tag>$surround$a0$surround</$firstTag>";
		} else
		{
			$a0 = $a[0];
			$a1 = $a[1];
			return "<$tag><span class=\"$inlineClass\">$a1</span>$surround$a0$surround</$firstTag>";
		}
	}
	private function parse_Cite()
	{
		$s = substr($this->pCode, $this->index+1, strpos($this->pCode, '""', $this->index)-$this->index-1);
		$this->index+=strlen($s)+3;
		$a = explode("|", $s);
		if(count($a)==1)
		{
			$a0 = $a[0];
			return "<cite>&quot;$a0&quot;</cite>";
		} else
		{
			$a0 = $a[0];
			$a1 = $a[1];
			return "<cite><span class=\"cite-author\">$a1</span>&quot;$a0&quot;</cite>";
		}
	}
	private function parse_Ordered()
	{
		$num = 0;
		while($this->pCode{$this->index+$num}=="#")
			$num++;
		$this->index+=$num;
		$s = $this->parseR("\n");
		$begin = "";
		$end = "";
		if($num > $this->orderedState)
		{
			for($i=$num; $i!=$this->orderedState; $i--)
				$begin .= "<ol>";
		} else
		{
			for($i=$num; $i!=$this->orderedState; $i++)
				$end .= "</ol>";
		}
		$this->index--;
		$this->orderedState = $num;
		return "$begin$end<li>$s</li>";
	}
	private function parse_Unordered()
	{
		$num = 0;
		while($this->pCode{$this->index+$num}=="*")
			$num++;
		$this->index+=$num;
		$s = $this->parseR("\n");
		$begin = "";
		$end = "";
		if($num > $this->unorderedState)
		{
			for($i=$num; $i!=$this->unorderedState; $i--)
				$begin .= "<ul>";
		} else
		{
			for($i=$num; $i!=$this->unorderedState; $i++)
				$end .= "</ul>";
		}
		$this->index--;
		$this->unorderedState = $num;
		return "$begin$end<li>$s</li>";
	}
	private function parse_Split()
	{
		$this->index++;
		$s = $this->parseR("||");
		$this->index--;
		if($this->splitState)
			return "<div class=\"split\">$s</div>";
		$this->splitState = true;
		return "<div class=\"split-container\"><div class=\"split\">$s</div>";
	}
	private function parse_Table()
	{
		$num = 0;
		while($this->pCode{$this->index+$num}=="|")
			$num++;
		$this->index+=$num;
		$class="";
		if($num==1)
			$class = "table-border";
		if($num==2)
			$class = "table-split";
		$s = $this->parseR("\n");
		$begin = "";
		$end = "";
		if($this->tableState==0)
			$begin .= "<table class=\"$class\">";
		
		$this->index--;
		$this->tableState = $num;
		$col = explode("|", $s);
		$td = "";
		foreach($col as $c)
		{
			if($c=="") $td .= "<td></td>";
			else
			{
				for($i=0;$c[$i]=='=';$i++);
				$c=substr($c,$i);
				if($i==0) $td .= "<td>$c</td>";
				else      $td .= "<th>$c</th>";
			}
		}
		return "$begin<tr>$td</tr>";
	}
	private function parse_Paragraphs()
	{
		$end = "";
		if($this->breakListing)
		{
			if($this->unorderedState > 0)
			{
				for($i=0; $i < $this->unorderedState; $i++)
					$end .= "</ul>";
				$this->unorderedState = 0;
			}
			if($this->orderedState > 0)
			{
				for($i=0; $i < $this->orderedState; $i++)
					$end .= "</ol>";
				$this->orderedState = 0;
			}
			if($this->tableState > 0)
			{
				for($i=0; $i < $this->tableState; $i++)
					$end .= "</table>";
				$this->tableState = 0;
			}
			if($this->splitState)
			{
				$end .= "</div>";
				$this->splitState = false;
			}
		}
		$this->index++;
		$s = $this->parseR("\n\n");
		$this->index-=1;	
		return "$end<p>\n$s\n</p>";
	}
	private function replace($find, $replace, $string)
	{
		$retVal = $string;
		$count = 1;
		while($count!=0)
		{
			$retVal = str_replace($find, $replace, $retVal, $count);
		}
		return $retVal;
	}
}
?>
