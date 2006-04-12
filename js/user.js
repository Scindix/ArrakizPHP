var intro = false;
<?php global $Settings; if($Settings['page']=="Overview") echo "var intro = true;";?>
window.onresize = function(event) {
    resizeSlides();
<?php global $Settings; if($Settings['page']=="Overview") echo "introSlide();";?>
};
function initUser()
{
	if (typeof(initUI) != "undefined")
		initUI();
	else
		window.setTimeout(initUser, 10);
<?php global $Settings; if($Settings['page']=="Overview") echo "
	introSlide();
";?>
	resizeSlides();
	<?php if(isset($_GET['prompt']) && $_GET['prompt']!="")
	{
		echo "loadDialogue('$_GET[prompt]');";
	}?>
}
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString())+"; path="+escape("/");
	document.cookie=c_name + "=" + c_value;
}
function introSlide()
{
	document.getElementsByTagName('body')[0].style.marginTop = (getHeight()-53)+'px';
	document.getElementsByTagName('body')[0].className = 'intro';
	document.getElementById('introContent').style.top = (-getHeight()+53)+'px';
	document.getElementsByClassName('slideView')[0].style.height = (getHeight()-53)+'px';
	
	var slides = document.getElementsByClassName('slide');
	for (var i=0; i<slides.length; i++)
	{
		slides[i].style.marginLeft = 150/*(getWidth()-500)/2*/+'px';
		slides[i].style.marginRight = (getWidth()-650)+'px';
	}
}
function addScript(src)
{
	var script=document.createElement('script');
	script.src='../'+src;
	script.type='text/javascript';

	document.getElementsByTagName('head')[0].appendChild(script);
}
function addComment(title, content, rating, streamID, postBlock, updateElement)
{
	var btn = updateElement.getElementsByClassName("btn")[0];
	btn.className = btn.className.replace(' stop-animation','');
	btn.className = 'btn-inactive ' + btn.className;
	ajax.addComment(title, content, rating, streamID, postBlock,
	function(toAdd)
	{
		var div = document.createElement('div');
		div.innerHTML = toAdd;
		for(i=0; i < div.childNodes.length; i++)
			updateElement.parentNode.insertBefore(div.childNodes[i], updateElement);
		window.setTimeout(function()
		{
			for(i=0; i < document.getElementsByClassName('comment-new').length; i++)
				document.getElementsByClassName('comment-new')[i].style.maxHeight='1000px';
		},10);
		btn.className += ' stop-animation';
		btn.className = btn.className.replace('btn-inactive ','');
	});
}
function newThread(func) {
    setTimeout(func, 0);
}
function loopUpTo(element, id)
{
	while(element.id!==id&&element.tagName!='body')
	{
		element = element.parentNode;
	}
	return element;
}
