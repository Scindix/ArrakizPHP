<?php
use \CodeHelper as CH;
class ModIntro extends Module
{
		function __construct() {
$this->title = "Home";
$this->titleTooltip = "Home";
$this->content =
$pc = (new CH\IntroContent(new CH\SlideView("10000",
	new CH\Slide("slide1",
		new CH\HTMLNode("Scindix is one of the best free environments and compilers for easy and fast Development.<br>Here are some impressions")),
	new CH\Slide("slide2",
		new CH\HTMLNode("Scindix is especially made for user interfaces and 3D-Programming")),
	new CH\Slide("slide3",
		new CH\HTMLNode("It comes with an integrated development environment, which is pack with of features. Even so it aims to be very easy to use. Most of the work is done with the GUI, not with programming.")),
	new CH\Slide("slide4",
		new CH\HTMLNode("You can create your own design or use the build-in examples to create your UI.")),
	new CH\Slide("slide5",
		new CH\HTMLNode("You have influence on every detail ...")),
	new CH\Slide("slide6",
		new CH\HTMLNode("... and action")),
	new CH\Slide("slide7",
		new CH\HTMLNode("Nearly every design-related programming is done in CSS, which is in fact the most intuitive but also elaborate way of implementation. The rest is done in XML-declarations")),
	new CH\Slide("slide8",
		new CH\HTMLNode("But your CSS-XML code is not necessarily bound to Graphical output. E.g. it can also represent a socket-communication app.<br> Do you think there is something missing, like javascript? You're right, this can't be done completely without programming. You can use a C++ like programming language named 'obvious', which is integrated directly in Your CSS-declarations.")),
	new CH\Slide("slide9",
		new CH\HTMLNode("Scindix comes with a large-scale and feature packed packagemanagement, which works very much like the debian packagemanagement. All your Apps are distributed through an build-in AppStore.")),
	new CH\Slide("slide10",
		new CH\HTMLNode("Scindix will (hopefully) be in the Ubuntu AppStore. But it will also be available for all common Linux- and Unix-distributions. In the near future also Windows will be supported.")))
	
	));
$this->content = $pc->printOut();
		}
}
?>
