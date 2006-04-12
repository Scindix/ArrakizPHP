<?php
namespace CodeHelper
{
//require_once("$Settings[MyDir]/class/util.class.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once("$Settings[MyDir]/class/file.class.php");
require_once("$Settings[MyDir]/class/WikiCode.class.php");
require_once("$Settings[MyDir]/class/WikiCode2.class.php");
require_once("$Settings[MyDir]/signin.php");
	class TagContainer extends Container
	{
		function __construct()
		{
			$arr = func_get_args();
			$arr2 = array();
			for($i = 1; $i < count($arr); $i++)
				array_push($arr2, $arr[$i]);
			parent::addByArray($arr2);
			$this->beginTag = $arr[0];
			$explode = explode(" ", $arr[0]);
			$this->endTag = $explode[0];
		}
	}
	class TabbedContainer extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$tabs = new TagContainer("div class=\"tabs\"");
			$tabNames = "";
			for($i=3; $i<$counter; $i+=2)
			{
				$tabID = str_replace(" ", "-", $args[$i]);
				$tab = new TagContainer("div id=\"tab-$tabID\" class=\"tab\"", new TextNode($args[$i]));
				$tabs->add($tab);
				$tabNames .= "$tabID";
				if($i<($counter-2)) $tabNames .= " ";
			}
			$class = "";
			if($args[2])
				$class .= " single-form";
			$this->beginTag = "div id=\"$args[0]\" data-re-align=\"$args[1]\" class=\"tabbed$class\" data-tabs=\"$tabNames\"";
			$this->endTag = "div";
			$tabContents=new TagContainer("div class=\"tabContent\"");
			for($i=4; $i<$counter; $i+=2)
			{
				$tabContentID = str_replace(" ", "-", $args[$i-1]);
				$tabContent = new TagContainer("div id=\"tabContent-$tabContentID\"", $args[$i]);
				$tabContents->add($tabContent);
			}
			$this->add($tabs);
			$this->add($tabContents);
		}
	}
	class TabbedFrame extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$tabs = new TagContainer("div class=\"tabs\"");
			$tabNames = "";
			for($i=2; $i<$counter; $i+=2)
			{
				$tabID = str_replace(" ", "-", $args[$i]);
				$tab = new TagContainer("div id=\"tab-$tabID\" class=\"tab\"", new TextNode($args[$i]));
				$tabs->add($tab);
				$tabNames .= "$tabID";
				if($i<($counter-2)) $tabNames .= " ";
			}
			$this->beginTag = "div id=\"$args[0]\" data-re-align=\"$args[1]\" class=\"tabbed\" data-tabs=\"$tabNames\"";
			$this->endTag = "div";
			$tabContents=new TagContainer("div class=\"tabContent\"");
			for($i=3; $i<$counter; $i+=2)
			{
				$tabContentID = str_replace(" ", "-", $args[$i-1]);
				$frameArgs = $args[$i];
				$tabContent = new TagContainer("div id=\"tabContent-$tabContentID frameContent\"", new Frame($frameArgs[0], $frameArgs[1], $frameArgs[2]));
				$tabContents->add($tabContent);
			}
			$this->add($tabs);
			$this->add($tabContents);
		}
	}
	class Frame extends TagContainer
	{
		function __construct($fclass, $fname, $fargs) 
		{
			parent::__construct("div class=\"frame\" frameClass=\"$fclass\" id=\"$fname\" frameArgs=\"$fargs\"");
		}
	}
	class Table extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$i = 1;
			$this->beginTag = 'table class="table"';
			while($i<$counter)
			{
				$trow = new TagContainer("tr");
				if($args[$i] == "hidden")
				{
					$i++;
					$trow->beginTag .= " style=\"display: none;\"";
				}
				for($j = 0; $j<$args[0]; $j++)
				{
					$trow->add(new TagContainer("td", $args[$i++]));
				}
				$this->add($trow);
			}
			$this->endTag = "table";
		}
		public function addRowsByArray($numColoumbs, $arr)
		{
			$i = 0;
			while($i< count($arr))
			{
				$trow = new TagContainer("tr");
				if($arr[$i] == "hidden")
				{
					$i++;
					$trow->beginTag .= " style=\"display: none;\"";
				}
				for($j = 0; $j<$numColoumbs; $j++)
				{
					$trow->add(new TagContainer("td", $arr[$i++]));
				}
				$this->add($trow);
			}
		}
	}
	class HeadedTable extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$i = 3;
			$this->beginTag = 'table class="table"';
			while($i<$counter)
			{
				$trow = new TagContainer("tr");
				if($i == 3) $trow = new TagContainer("tr class=\"$args[1]\"");
				for($j = 0; $j<$args[0]; $j++)
				{
					$tcell = new TagContainer("td", $args[$i++]);
					if($j == 0) $tcell = new TagContainer("td class=\"$args[2]\"", $args[$i++]);
					$trow->add($tcell);
				}
				$this->add($trow);
			}
			$this->endTag = "table";
		}
		public function addRowsByArray($numColoumbs, $arr)
		{
			$i = 2;
			while($i< count($arr))
			{
				$trow = new TagContainer("tr");
				if($i == 2) $trow = new TagContainer("tr class=\"$arr[0]\"");
				for($j = 0; $j<$numColoumbs; $j++)
				{
					$tcell = new TagContainer("td", $arr[$i]);
					if($j == 0) $tcell = new TagContainer("td class=\"$arr[1]\"", $arr[$i]);
					$trow->add($tcell);
					$i++;
				}
				$this->add($trow);
			}
		}
	}
	class Listing extends Table
	{
		function __construct() 
		{
			$this->beginTag = 'table class="listing"';
			$this->endTag = "table";
			$this->addRowsByArray(2, func_get_args());
		}
	}
	class HeadedListing extends HeadedTable
	{
		function __construct() 
		{
			$this->beginTag = 'table class="listing"';
			$this->endTag = "table";
			$this->addRowsByArray(2, func_get_args());
		}
	}
	class Btn extends Container
	{
		function __construct($id, $content, $onclick = "", $type = "standard", $start=-1, $count=-1, $delay=-1, $row=-1) 
		{
			$add2class = "";
			$typeArr = explode(" ", $type);
			$iconsub=false;
			if(in_array("icon-anim", $typeArr))
			{
				$iconsub=true;
				$add2class .= " btn-icon-animation";
			}
			
			if(in_array("stop-animation", $typeArr))
				$add2class .= " stop-animation";
			
			if(!$iconsub&&in_array("icon", $typeArr))
				$add2class .= " btn-icon";
				
			if(in_array("icon-only", $typeArr))
				$add2class .= " btn-icon-only";
				
			if(in_array("dialog", $typeArr))
				$add2class .= " btn-dialogue";
				
			if(in_array("important", $typeArr))
				$add2class .= " btn-important";
			$additional = "";
			
			if($start!==-1)
				$additional .= " data-anim-start=\"$start\" data-anim-count=\"$count\" data-anim-delay=\"$delay\"";
			
			$this->beginTag = "div id=\"$id\" class=\"gradient btn$add2class\" onclick=\"$onclick\"";
			if($iconsub)
				$this->add(new TagContainer("div class=\"icon-anim\" data-anim-start=\"$start\" data-anim-count=\"$count\" data-anim-delay=\"$delay\" data-anim-row=\"$row\""));
			$this->add(new TextNode($content));
		}
	}
	class Submit extends Btn
	{
		function __construct($id, $label, $type = "important")
		{
			$onclick = "document.getElementById('$id').submit()";
			parent::__construct("submit-$id", $label, $onclick, $type);
		}
	}
	class Group extends Container
	{
		function __construct() 
		{
			$this->addByArray(func_get_args());
		}
		function addByArray($arr)
		{
			$args = $arr;
			$counter = count($args);
			if($counter < 1)
				return;
			$args[0]->beginTag = str_replace('class="', 'class="group-left ', $args[0]->beginTag);
			for($i=1; $i<$counter-1; $i++)
				$args[$i]->beginTag = str_replace('class="', 'class="group-middle ', $args[$i]->beginTag);
			$args[$counter-1]->beginTag = str_replace('class="', 'class="group-right ', $args[$counter-1]->beginTag);
			
			parent::addByArray($args);
		}
	}
	class Label extends TagContainer
	{
		function __construct($label, $for="")
		{
			parent::__construct("label for=\"$for\"", new TextNode($label));
		}
	}
	class OptionBtn extends Btn
	{
		function __construct($id, $optionGroup, $type, $fallback = false, $content = "") 
		{
			$URI = \Util::genURI(array($optionGroup => $id));
			$onclick = "self.location='$URI'";
			parent::__construct("btn-$id", $content, $onclick, $type);
			if((isset($_GET[$optionGroup]) && $_GET[$optionGroup] == $id) || (!isset($_GET[$optionGroup]) && $fallback))
				$this->beginTag = str_replace('class="', 'class="btn-option-active ', $this->beginTag);
			#...
			//*$args = func_get_args();
			//$counter = count($args);
			
			//$args[0]->beginTag = str_replace('class="', 'class="group-left ', $args[0]->beginTag);
			//$args[$counter-1]->beginTag = str_replace('class="', 'class="group-right ', $args[$counter-1]->beginTag);
			
			//$this->addByArray($args);
		}
	}
	class IFrame extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			
			$arr = array();
			for($i = 3; $i < $counter; $i++)
				array_push($arr, $args[$i]);
				
			$this->addByArray($arr);
			$this->beginTag = "iframe src=\"$args[0]\" width=\"$args[1]\" height=\"$args[2]\"";
			$this->endTag = 'iframe';
		}
	}
	class TextArea extends Container
	{
		function __construct($id, $value="", $cols="40", $rows="8", $type="") 
		{
			$inputType= "text";
			$cssclass = "";
			$typeArr = explode(" ", $type);
			
			if(in_array("fill", $typeArr))
				$cssclass .= " fill";
				
			$this->beginTag = "textarea class=\"$cssclass\" id=\"in$id\" name=\"$id\"";
			$this->add(new TextNode($value));
			$this->endTag = 'textarea';
		}
	}
	class BreadCrumbs extends TagContainer
	{
		function __construct()
		{
			parent::__construct("div class=\"breadCrumbs\"");
		}
	}
	class BreadCrumb extends TagContainer
	{
		function __construct($title, $onclick, $mode = "")
		{
			$cssclass = "btn btn-option";
			$typeArr = explode(" ", $mode);
			
			if(in_array("active", $typeArr))
				$cssclass .= " btn-option-active";		
		
			parent::__construct("a class=\"breadCrumb $cssclass\" onclick=\"$onclick\" href=\"#\"");
			parent::add(new TextNode($title));
		}
	}
	class AdvancedList extends TagContainer
	{
		function __construct($mode = "")
		{
			parent::__construct("div class=\"list $mode\"");
			
			$args = func_get_args();
			$counter = count($args);
			
			$arr = array();
			for($i = 1; $i < $counter; $i++)
				array_push($arr, $args[$i]);
			parent::addByArray($arr);
		}
	}
	class ListItem extends TagContainer
	{
		function __construct($title, $description = "", $logo = "", $rightGroup = array(), $special = "", $onclick="")
		{
			$cls = $special;
			if($onclick != "")
				$cls .= "\" onclick=\"$onclick\"";
			else
				$cls .= "\"";
			parent::__construct("div class=\"list-item $cls");
			
			$logo = new Img($logo, "list-item-logo");
			
			$listTitle = new TagContainer("div class=\"list-item-title\"", new TextNode($title));
			$listDescription = new TagContainer("div class=\"list-item-description\"", new TextNode($description));
			
			$listLeftGroup = new TagContainer("div class=\"list-item-left\"", $listTitle, $listDescription);
			$listRightGroup = new TagContainer("div class=\"list-item-right\"");
			$listRightGroup->addByArray($rightGroup);
			
			
			parent::add($logo, $listLeftGroup, $listRightGroup);
		}
	}
	class Stream extends TagContainer
	{
		function __construct($stream) 
		{
			$currentSession = getSession();
			$postCount = \SQL::max("stream", "PostBlock",  "StreamID='$stream'")+1;
			global $Settings;
			$newPost = new TagContainer("div id=\"comment\"", new Anchor("#", "Sign In", "loadDialogue('signUp');"),new HTMLNode("to post!"));
			if($currentSession["Status"]>0)
			{
				$entryu = $currentSession;
				$username = $entryu["Name"];
				$useravatar = getFile($entryu["Avatar"]);
				$newPost = new TagContainer("div id=\"comment\"",
				new Listing(
					new HTMLNode("<img id=\"comment-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new TagContainer("div",
						new Text("new-comment-title", "", "title", "edit"),
						new Btn("btnAddReview", "post", "addComment(document.getElementById('innew-comment-title').value, document.getElementById('innew-comment-content').value, parseInt(parseInt(document.getElementById('btnAddReview').parentNode.getElementsByClassName('rating-fore-new')[0].style.width,10)/7.5,10),'$stream', '-1', loopUpTo(document.getElementById('btnAddReview'),'comment'))", "icon-anim stop-animation", "0", "7", "500", "23"),
						new HTMLNode("<br>"),
						new HTMLNode("<div class=\"comment-rating comment-rating-new\">
											<div class=\"rating-fore-new\" style=\"0px;\"  data-rating=\"0px;\"></div>
											<div class=\"rating-back\"></div>
										</div>"),
						new HTMLNode("<br>"),
						new TextArea("new-comment-content"))));
			}
			$post = new TagContainer("div class=\"post\"", $newPost);
			$posts = array(0 => $post);
			for($i=0; $i<$postCount; $i++)
			{
				$comment = array();
				$j=0;
				$table = \SQL::getTable("stream", "StreamID='$stream'", "PostBlock=$i");
				while ($entryc = \SQL::getRow($table)){
					$userTable = \SQL::getTable("user", "ID=$entryc[UserID]");
					$entryu = \SQL::getRow($userTable);
					if($entryu)
					{
						$username = $entryu["Name"];
						$useravatar = getFile($entryu["Avatar"]);
					}
					else
					{
						$username = "user deleted";
						$useravatar = getFile(1);;
					}
					$addClass = ($j==0)?(" class=\"first-comment\""):("");
					$comment[$j++] = new TagContainer("div$addClass id=\"comment\"",
					new Listing(
						new HTMLNode("<img id=\"comment-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new TagContainer("div",
							new HTMLNode("<div id=\"comment-header\">$entryc[Title]</div>"),
							new HTMLNode("<div id=\"comment-time\">$entryc[Time]</div>"),
							new HTMLNode("<br>"),
							new HTMLNode("<div class=\"comment-rating\">
												<div class=\"rating-fore\" style=\"width: ".($entryc["Rating"]*7.5)."px;\"></div>
												<div class=\"rating-back\"></div>
											</div>"),
							new HTMLNode("<div id=\"comment-author\">by $username</div>"),
							new HTMLNode("<br>"),
							new HTMLNode("<div id=\"comment-content\">$entryc[Content]</div>"))));
				}
				if(isset($getLastCommentOnly)&&$getLastCommentOnly==true)
				{
					echo $comment[count($comment)-1]->printOut();
					die();
				}
				if($currentSession["Status"]>0)
				{
					$entryu = $currentSession;
					$username = $entryu["Name"];
					$useravatar = getFile($entryu["Avatar"]);
					$comment[$j++] = new TagContainer("div id=\"comment\"",
					new Listing(
						new HTMLNode("<img id=\"comment-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new TagContainer("div",
							new Text("new-comment-title", "", "title", "edit"),
							new Btn("btnAddReview", "post", "addComment(document.getElementById('innew-comment-title').value, document.getElementById('innew-comment-content').value, parseInt(parseInt(document.getElementById('btnAddReview').parentNode.getElementsByClassName('rating-fore-new')[0].style.width,10)/7.5,10),'$entryc[StreamID]', '$entryc[PostBlock]', loopUpTo(document.getElementById('btnAddReview'),'comment'))", "icon-anim stop-animation", "0", "7", "500", "23"),
							new HTMLNode("<br>"),
							new HTMLNode("<div class=\"comment-rating comment-rating-new\">
												<div class=\"rating-fore-new\" style=\"0px;\"  data-rating=\"0px;\"></div>
												<div class=\"rating-back\"></div>
											</div>"),
							new HTMLNode("<br>"),
							new TextArea("new-comment-content"))));
				} else
				{
					$comment[$j++] = new TagContainer("div id=\"comment\"", new Anchor("#", "Sign In", "loadDialogue('signUp');"),new HTMLNode("to post reviews!"));
				}
				$comments = new TagContainer("div id=\"comments\"");
				$post = $comment[0];
				unset($comment[0]);
				$comments->addByArray($comment);
				$post = new TagContainer("div class=\"post\"", $post, $comments);
				$posts[$i+1] = $post;
			}
			$postContainer = new TagContainer("div class=\"post-container\"");
			$postContainer->addByArray($posts);
			parent::__construct("div class=\"comment-container\"", $postContainer);
			
		}
	}
	class BasicText extends Container
	{
		function __construct($id, $value="", $defaultValue="", $type="text") 
		{
			$inputType= "text";
			$cssclass = "input-text";
			$typeArr = explode(" ", $type);
			if(in_array("text", $typeArr))
				$inputType= "text";
			
			if(in_array("password", $typeArr))
				$inputType= "password";
				
			if(in_array("hidden", $typeArr))
				$inputType= "hidden";
			
			if(in_array("file", $typeArr))
				$inputType= "file";
			
			if(in_array("fill", $typeArr))
				$cssclass .= " fill";
			
			if(in_array("edit", $typeArr))
				$cssclass .= " edit";
				
			$this->beginTag = "input type=\"$inputType\" class=\"$cssclass\" id=\"in$id\" name=\"$id\" value=\"$value\" data-defaultValue=\"$defaultValue\"";
			$this->endTag = '';
			if(!in_array("hidden", $typeArr)) $this->before = new HTMLNode("<div class=\"input-default-text\">&nbsp;$defaultValue</div>");
		}
	}
	class BasicCheck extends Container
	{
		function __construct($id, $defaultValue=false) 
		{
			$checked = "";			
			if($defaultValue)
				$checked = ' checked';
			$this->beginTag = "input type=\"checkbox\" class=\"input-check\" id=\"in$id\" name=\"$id\"$checked value=\"true\"";
			$this->endTag = '';
		}
	}
	class Text extends TagContainer
	{
		function __construct($id, $value="", $defaultValue="", $type="text") 
		{
			parent::__construct("div class=\"input-container\"", new BasicText($id, $value, $defaultValue, $type));
		}
	}
	class Check extends TagContainer
	{
		function __construct($id, $description, $defaultValue=false) 
		{
			parent::__construct("div class=\"check-container\"", new BasicText($id, "false", "", "hidden"), new BasicCheck($id, $defaultValue), new TagContainer("label for=\"in$id\"", $description));
		}
	}
	class Option extends TagContainer
	{
		function __construct($value, $description) 
		{
			parent::__construct("option class=\"input-option\" value=\"$value\"", $description);
		}
	}
	class Select extends Container
	{
		function __construct($name) 
		{
			$args = func_get_args();
			$arr = array();
			for($i = 1; $i < count($args); $i++)
				array_push($arr, $args[$i]);
			$this->beginTag = "select class=\"input-select\" name=\"$name\"";
			$this->endTag = "select";
			$this->addByArray($arr);
		}
	}
	class Anchor extends TagContainer
	{
		function __construct($href, $text="", $onclick="") 
		{
			if($text=="")
				$text=$href;
			if($onclick!="")
				$onclick=" onclick=\"$onclick\"";
			parent::__construct("a href=\"$href\"$onclick", new TextNode($text));
		}
	}
	class SlideView extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			
			$arr = array();
			for($i = 1; $i < $counter; $i++)
				array_push($arr, $args[$i]);
			self::addSlidesByArray($args[0], $arr);
		}
		function addSlidesByArray($delay, $arr)
		{
			$this->add(new TagContainer('div class="slide-rightNav"', new TagContainer("div", new TextNode(">")), new TagContainer("div class=\"ie-hidden\"", new TextNode(">")), new TagContainer("span class=\"posSpan\"")));
			$this->add(new TagContainer('div class="slide-leftNav"', new TagContainer("div", new TextNode("<")), new TagContainer("div class=\"ie-hidden\"", new TextNode("<")), new TagContainer("span class=\"posSpan\"")));
			$this->add(new TagContainer('div class="slide-shadow"'));
			$innerSlide = new TagContainer('div class="inner-slide"');
			$innerSlide->addByArray($arr);			
			$this->add($innerSlide);
			$this->beginTag = "div class=\"slideView\" data-delay=\"$delay\"";
		}
	}
	class Slide extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$id = $args[0];
			$title = new TextNode("");
			$description = $args[1];
			if($counter > 2)
			{
				$title = $args[1];
				$description = $args[2];
			}
			$this->beginTag = "div id=\"$id\" class=\"slide\"";
			if($counter > 3)
			{
				global $Settings;
				$ms = $Settings["MyServer"];
				$this->beginTag = "div id=\"$id\" class=\"slide\" style=\"background-image: url('$ms/".$args[3]."');\"";
			}
			$this->add(new TagContainer('div class="slide-content"', new TagContainer('div class="slide-title"', $title), new TagContainer('div class="slide-description"', $description)));
		}
	}
	class AlbumView extends SlideView
	{
		function __construct($album, $delay=10000) 
		{
			$slides = array();
			$slideTable = \SQL::getTable("album_data", "Album=$album");
			for($i = 0; $i < \SQL::getRowCount($slideTable); $i++)
			{
				$entry = \SQL::getRow($slideTable);
				$slides[$i] = new Slide("slide-$i", new HTMLNode($entry['Title']), new HTMLNode($entry['Description']), \getFile($entry['Image']));
			}
			parent::addSlidesByArray($delay, $slides);
			
		}
	}
	class DialogContent extends TagContainer
	{
		function __construct()
		{
			parent::__construct("div class=\"dialogueContent\"");
			parent::addByArray(func_get_args());
		}
	}
	class UnborderedDialogContent extends TagContainer
	{
		function __construct()
		{
			parent::__construct("div class=\"unbordered dialogueContent\"");
			parent::addByArray(func_get_args());
		}
	}
	class TabbedDialogContent extends TagContainer
	{
		function __construct()
		{
			parent::__construct("div class=\"tabbedDialogueContent\"");
			parent::addByArray(func_get_args());
		}
	}
	class ToolBar extends TagContainer
	{
		function __construct() 
		{
			parent::__construct('div class="tool-bar"'); 
			$this->addByArray(func_get_args());
		}
	}
	class PageContent extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$this->beginTag = 'div id="pageContent"';
			$pcl = new PageContentLayer();
			$pcl->addByArray($args);
			$this->add($pcl);
		}
	}
	class IntroContent extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$this->beginTag = 'div id="introContent"';
			$this->addByArray($args);
		}
	}
	class PageContentLayer extends Container
	{
		function __construct()
		{
			parent::addByArray(func_get_args());
			$this->beginTag = 'div id="pageContentLayer"';
		}
	}
	class SplitContainer extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$conClass = "split-$counter";
			$this->beginTag = "div class=\"$conClass\"";
			for($i=0; $i<$counter; $i++)
				$this->add(new Split(new PaddingContainer($args[$i])));
		}
	}
	class SplitContainer23 extends Container
	{
		function __construct() 
		{
			$args = func_get_args();
			$counter = count($args);
			$conClass = "split-2-3";
			$this->beginTag = "div class=\"$conClass\"";
			for($i=0; $i<$counter; $i++)
				$this->add(new Split(new PaddingContainer($args[$i])));
		}
	}
	class FooterSpacer extends Container
	{
		function __construct()
		{
			parent::addByArray(func_get_args());
			$this->beginTag = 'div class="footer-spacer"';
		}
	}
	class Split extends Container
	{
		function __construct()
		{
			parent::addByArray(func_get_args());
			$this->beginTag = 'div class="split"';
		}
	}
	class Img extends Container
	{
		function __construct($src, $cssClass="")
		{
			$this->beginTag = "img class=\"$cssClass\" src=\"$src\"";
			$this->endTag = "img";
		}
	}
	class PaddingContainer extends Container
	{
		function __construct()
		{
			parent::addByArray(func_get_args());
			$this->beginTag = 'div class="padding-container"';
		}
	}
	class HTMLNode extends Container
	{
		protected $text = "";
		function __construct($t)
		{
			$this->text = $t;
		}
		public function printOut()
		{
			return $this->text;
		}
	}
	class TextNode extends HTMLNode
	{
		public function printOut()
		{
			return htmlspecialchars($this->text, ENT_COMPAT|ENT_SUBSTITUTE, "UTF-8");
		}
	}
	class WikiNode extends HTMLNode
	{
		public function printOut()
		{
			$wc = new \WikiCode($this->text);
			return ($wc->parse());//htmlspecialchars
		}
	}
	class WikiNode2 extends HTMLNode
	{
		public function printOut()
		{
			$wc = new \WikiCode2($this->text);
			return ($wc->parse());//htmlspecialchars
		}
	}
	class H extends Container
	{
		function __construct()
		{
			$arr = array();
			//for($i = 1; $i < count(func_get_args()); $i++)
			//	$arr[$i-1] = func_get_args()[$i];
			$number = func_get_args()[0];
			//parent::addByArray($arr);
			parent::add(new TextNode(func_get_args()[1]));
			$this->beginTag = "h$number";
			$this->endTag = "h$number";
		}
	}
	class Container
	{
		protected $beginTag = "div";
		protected $endTag = "div";
		public $before = null;
		public $child = array();
		public $after = null;
		function __construct()
		{
			$this->child = func_get_args();
		}
		public function add()
		{
			//array_push($this->child, $a);
			//return $this;
			return $this->addByArray(func_get_args());
		}
		public function addFirst($a)
		{
			array_unshift($this->child, $a);
			return $this;
		}
		public function addByArray($a)
		{
			foreach($a as $value)
				array_push($this->child, $value);
			return $this;
		}
		public function printOut()
		{
			$out = "";
			if($this->before!=null)
				$out .= $this->before->printOut();
			$out .= "<$this->beginTag>";
			for($i = 0; $i < count($this->child); $i++)
			{
				$arr = $this->child[$i];
				$out .= $arr->printOut();
			}
			if($this->endTag!='')$out .= "</$this->endTag>";
			if($this->after!=null)
				$out .= $this->after->printOut();
			return $out;
		}
	}
	function parse($sin)
	{
		$s = "\\CodeHelper\\$sin";
		$args = explode("|", $s);
		switch(count($args))
		{
			case 0:
				return "";
			case 1:
				$str = $args[0];
				$obj = new $str();
				return $obj->printOut();
			case 2:
				$str = $args[0];
				$obj = new $str($args[1]);
				return $obj->printOut();
			case 3:
				$str = $args[0];
				$obj = new $str($args[1], $args[2]);
				return $obj->printOut();
			case 4:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3]);
				return $obj->printOut();
			case 5:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4]);
				return $obj->printOut();
			case 6:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5]);
				return $obj->printOut();
			case 7:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
				return $obj->printOut();
			case 8:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
				return $obj->printOut();
			case 9:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
				return $obj->printOut();
			case 10:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
				return $obj->printOut();
			case 11:
				$str = $args[0];
				$obj = new $str($args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9], $args[10]);
				return $obj->printOut();
			default:
				return "Failed loading plugin: ($s)";
		}
	}
}
?>
