var dia = document.createElement('div');
var lId = '';
var transitionProp = getsupportedprop(['transition', 'MozTransition', 'WebkitTransition', 'OTransition', 'MsTransition']); //get appropriate CSS3 properties
var transformProp = getsupportedprop(['transform', 'MozTransform', 'WebkitTransform', 'OTransform', 'MsTransform']);
var eventFuncIcons = new Array(0);
var eventDismissAnim;
var eventDismiss;
function initUI()
{
	addTabCallbacks(document);
	addSlideCallbacks(document);
	addPaddings(document);
	addRatings(document);
	addInputDefaults(document);
	addIconAnimations(document);
	addDismiss(document);
	//addDropdownCallbacks();
}
function showDialogue(dialogue)
{
	dia = document.getElementById(dialogue);
	dia.style.display = 'inline-block';
	var resource = window.setTimeout("fadeOne(dia)", 10);
}
function closeDialogue(dialogue2Close)
{
	dia = document.getElementById(dialogue2Close);
	dia.style.opacity = '0';
	dia.style[transformProp] = 'scale(0.9)';
	var resource = window.setTimeout("fadeZero(dia)", 200);
}
function fadeOne(toFade)
{
	toFade.style.opacity = '1';
	toFade.style[transformProp] = 'scale(1.0)';
}
function fadeZero(toFade)
{
	toFade.parentNode.removeChild(toFade);
}
function Goto(location)
{
	self.location=location;
}
function formGoto(location)
{
	self.location=location;
	return false;	
}
function loadFrame(id, args, additional)
{
	args = args || "";
	additional = additional || "";
	var frame = document.getElementById(id);
	if(frame==null)
		pushNotification("Error", "Cannot find frame!");
	ajax.getFrame(frame.getAttribute("frameClass"), function(toAdd)
	{
		frame.innerHTML = toAdd;
		var s = document.createElement('script');
		var f = frame;
		ajax.getFrameScript(location, function(toAdd2)
		{
			s.text = toAdd2;
			f.appendChild(s);
		}, "redirect="+Settings.Page+"&"+args, additional);
	}, "redirect="+Settings.Page+"&"+args, additional);
}
function loadDialogue(location, args, additional)
{
	args = args || "";
	additional = additional || "";
	var element = document.getElementById('pageContentLayer');
	if(element==null)
		element = document.getElementById('introContent');
	page = element.innerHTML;
	ajax.getDialogue(location, function(toAdd)
	{
		element.innerHTML = page + toAdd;
		var g = document.createElement('script');
		var s = element;
		ajax.getDialogueScript(location, function(toAdd2)
		{
			g.text = toAdd2;
			s.appendChild(g);
		}, "redirect="+Settings.Page+"&"+args, additional);
	}, "redirect="+Settings.Page+"&"+args, additional);
	//var resource = window.setTimeout("centerElement(lId)", 10);
}
function loadDialogueById(Id)
{
	var element = document.getElementById(Id);
	var saveTransition = element.style[transitionProp];
	element.style.transition = 'none';
	element.style.display = 'inline-block';
	addTabCallbacks(document);
	addSlideCallbacks(document);
	addTitleBarCallbacks(document);
	addRatings(document);
	addInputDefaults(document);
	addIconAnimations(document);
	addDismiss(document);
	resizeSlides();
	centerElement(Id);
	element.style[transitionProp] = saveTransition;
	showDialogue(Id);
}
function load(Id, location)
{
	page = document.getElementById('pageContentLayer').innerHTML;
	var toAdd = ajax.get(location, function(toAdd)
	{		
		document.getElementById('pageContentLayer').innerHTML = page + toAdd;
		var element = document.getElementById(Id);
		var saveTransition = element.style[transitionProp];
		element.style.transition = 'none';
		element.style.display = 'inline-block';
		centerElement(Id);
		element.style[transitionProp] = saveTransition;
		showDialogue(Id);
	});
	//var resource = window.setTimeout("centerElement(lId)", 10);
}
function centerElement(Id)
{
	var element = document.getElementById(Id);
	if(element)
	{
		element.style.left = '0';
		element.style.top = '0';
		element.style.marginLeft = (-element.offsetWidth/2) + 'px';
		element.style.marginTop = (-element.offsetHeight/2) + 'px';
		element.style.left = '50%';
		element.style.top = '50%';
	}
}
function getsupportedprop(proparray){
    var root=document.documentElement //reference root element of document
    for (var i=0; i<proparray.length; i++){ //loop through possible properties
        if (typeof root.style[proparray[i]]=="string"){ //if the property value is a string (versus undefined)
            return proparray[i] //return that string
        }
    }
}
function addTabCallbacks(e)
{
	var tabbed = e.getElementsByClassName('tabbed');
	var eventFunc = new Array(tabbed.length);
	for(var i = 0; i < tabbed.length; i++)
	{
		var tabs = tabbed[i].getElementsByClassName('tab');
		eventFunc[i] = new Array(tabs.length);
		for (var j=0; j<tabs.length; j++)
		{
			var _this = eventFunc[i][j];
			eventFunc[i][j] = function()
			{
				setTab(arguments.callee.elemTabbed, arguments.callee.elemTab);
				if(arguments.callee.elemForm != '') centerElement(arguments.callee.elemForm);
				var eTabbed = document.getElementById(arguments.callee.elemTabbed);
				//alert(eTabbed.getElementsByClassName('tabContent')[0].offSetHeight + 'px');
				eTabbed.getElementsByClassName('tabs')[0].style.height = 'auto';
				document.getElementById('tabContent-'+arguments.callee.elemTab).style.height = 'auto';
				var offsetContent = document.getElementById('tabContent-'+arguments.callee.elemTab).offsetHeight;
				var offsetTab = eTabbed.getElementsByClassName('tabs')[0].offsetHeight;
				//alert(offsetContent+'|'+offsetTab);
				/*if(offsetContent < offsetTab)
				{
					eTabbed.getElementsByClassName('tabs')[0].style.height = '' + (offsetContent+31) + 'px';
				}
				else
				{
					document.getElementById('tabContent-'+arguments.callee.elemTab).style.height = '' + offsetTab+5 + 'px';
				}*/
			};
			eventFunc[i][j].elemTabbed = tabbed[i].id;
			eventFunc[i][j].elemTab = tabs[j].id.substr(4);
			eventFunc[i][j].elemForm = tabbed[i].getAttribute('data-re-align');
			tabs[j].onclick = eventFunc[i][j];
		}
		if(tabs.length>0) eventFunc[i][0]();
	}
}
function addDropdownCallbacks(e)
{
	var dropdown = e.getElementsByClassName('dropdown');
	for(var i = 0; i < dropdown.length; i++)
	{
		dropdown[i].onclick = function(e)
		{
			var caller = e.target || e.srcElement;
			if(caller.className.indexOf('dropdow-active')==-1)
				caller.className += 'dropdow-active';
			else
				caller.className = caller.className.replace('dropdow-active', '');
		};
	}
}
function setTab(tabbed, tab)
{
	var tabbedObj = document.getElementById(tabbed);
	var tabsString = tabbedObj.getAttribute('data-tabs');
	var tabs = tabsString.split(' ');
	for (var i=0; i<tabs.length; i++)
	{
		if(tabs[i]==tab)
		{
			var tabContent = document.getElementById('tabContent-'+tabs[i]);
			tabContent.style.display = 'block';
			var inputs = Array.prototype.slice.call(tabContent.getElementsByTagName('input'));
			Array.prototype.push.apply(inputs, Array.prototype.slice.call(tabContent.getElementsByTagName('select')));
			for(var j = 0; j<inputs.length; j++)
				inputs[j].disabled = false;
			document.getElementById('tab-'+tabs[i]).className = 'tab tab-active';
		} else
		{
			var tabContent = document.getElementById('tabContent-'+tabs[i]);
			tabContent.style.display = 'none';
			if(tabbedObj.getAttribute("class").split(' ').indexOf("single-form") == -1)
			{
				var inputs = Array.prototype.slice.call(tabContent.getElementsByTagName('input'));
				Array.prototype.push.apply(inputs, Array.prototype.slice.call(tabContent.getElementsByTagName('select')));
				for(var j = 0; j<inputs.length; j++)
				{
					inputs[j].disabled = true;
				}
			}
			document.getElementById('tab-'+tabs[i]).className = 'tab';		
		}
	}
}
function addSlideCallbacks(e)
{
	var slides = document.getElementsByClassName('slideView');
	var slideEventFunc = new Array(slides.length);
	var slideEventFuncNext = new Array(slides.length);
	var slideEventFuncPrev = new Array(slides.length);
	for (var i=0; i<slides.length; i++)
	{
		var delay = slides[i].getAttribute('data-delay');
		var firstSlide = slides[i].getElementsByClassName('slide')[0];
		firstSlide.className += " slide-active";
		var innerSlide = slides[i].getElementsByClassName('inner-slide')[0];
		slideEventFunc[i] = function()
		{
			var slideOffset = 10*parseInt(parseInt(arguments.callee.slide.style.marginLeft.replace("%", "").replace("px", "").replace("-", "")|0)/10);
			slideOffset += 100;
			if(slideOffset > ((arguments.callee.slideMax-1)*100))
				slideOffset = 0;
			if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(0).Apply();
			}
			arguments.callee.slide.style.marginLeft = (-slideOffset) + '%';
			if(slideOffset == 0)
			{
				arguments.callee.slide.style.marginLeft = '-1%';
				arguments.callee.slide.style.paddingLeft = '1%';
			} else
			{
				arguments.callee.slide.style.paddingLeft = '0%';
			}
			if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(0).Play();
			}
			var allSlides = arguments.callee.slide.getElementsByClassName('slide');
			var editSlide = allSlides[0];
			if(slideOffset/100-1 < 0)
				editSlide = allSlides[arguments.callee.slideMax-1];
			else
				editSlide = allSlides[slideOffset/100-1];
			
			editSlide.className = editSlide.className.replace(" slide-active", "").replace(" slide-active", "");
			arguments.callee.slide.parentNode.getElementsByClassName('slide')[slideOffset/100].className += " slide-active";
			var delay = arguments.callee.slide.parentNode.getAttribute('data-delay');
			window.setTimeout(arguments.callee, parseInt(delay));
		};
		slideEventFunc[i].slideMax = slides[i].getElementsByClassName('slide').length;
		slideEventFunc[i].slide = innerSlide;
		slideEventFuncNext[i] = function()
		{
			var slideOffset = 10*parseInt(parseInt(arguments.callee.slide.style.marginLeft.replace("%", "").replace("px", "").replace("-", "")|0)/10);
			slideOffset += 100;
			if(slideOffset > ((arguments.callee.slideMax-1)*100))
				slideOffset = 0;
			if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(0).Apply();
			}
			arguments.callee.slide.style.marginLeft = (-slideOffset) + '%';
			if(slideOffset == 0)
			{
				arguments.callee.slide.style.marginLeft = '-1%';
				arguments.callee.slide.style.paddingLeft = '1%';
			} else
			{
				arguments.callee.slide.style.paddingLeft = '0%';
			}
			if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(0).Play();
			}
			var allSlides = arguments.callee.slide.getElementsByClassName('slide');
			var editSlide = allSlides[0];
			if(slideOffset/100-1 < 0)
				editSlide = allSlides[arguments.callee.slideMax-1];
			else
				editSlide = allSlides[slideOffset/100-1];
				
			editSlide.className = editSlide.className.replace(" slide-active", "").replace(" slide-active", "");
			
			arguments.callee.slide.parentNode.getElementsByClassName('slide')[slideOffset/100].className += " slide-active";
		};
		slideEventFuncNext[i].slideMax = slides[i].getElementsByClassName('slide').length;
		slideEventFuncNext[i].slide = innerSlide;
		slideEventFuncPrev[i] = function()
		{
			var slideOffset = 10*parseInt(parseInt(arguments.callee.slide.style.marginLeft.replace("%", "").replace("px", "").replace("-", "")|0)/10);
			slideOffset -= 100;
			if(slideOffset < 0)
				slideOffset = (arguments.callee.slideMax-1)*100;
			arguments.callee.slide.style.marginLeft = (-slideOffset) + '%';if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(1).Apply();
			}
			if(slideOffset == 0)
			{
				arguments.callee.slide.style.marginLeft = '-1%';
				arguments.callee.slide.style.paddingLeft = '1%';
			} else
			{
				arguments.callee.slide.style.paddingLeft = '0%';
			}
			if(arguments.callee.slide.filters)
			{
				arguments.callee.slide.parentNode.filters.item(1).Play();
			}
			var allSlides = arguments.callee.slide.getElementsByClassName('slide');
			if(slideOffset/100+1 > arguments.callee.slideMax-1)
				allSlides[0].className = allSlides[0].className.replace(" slide-active", "").replace(" slide-active", "");
			else
				allSlides[slideOffset/100+1].className = allSlides[slideOffset/100+1].className.replace(" slide-active", "").replace(" slide-active", "");
			arguments.callee.slide.parentNode.getElementsByClassName('slide')[slideOffset/100].className += " slide-active";
		};
		slideEventFuncPrev[i].slideMax = slides[i].getElementsByClassName('slide').length;
		slideEventFuncPrev[i].slide = innerSlide;
		
		window.setTimeout(slideEventFunc[i], parseInt(delay));
		var ileftNav = slides[i].getElementsByClassName('slide-leftNav')[0];
		var irightNav = slides[i].getElementsByClassName('slide-rightNav')[0];
		ileftNav.onclick = slideEventFuncPrev[i];
		irightNav.onclick = slideEventFuncNext[i];		
	}
}
function resizeSlides()
{
	var slides = document.getElementsByClassName('slideView');
	for(var i=0; i<slides.length; i++)
	{
		var allSlides = slides[i].getElementsByClassName('slide');
		for(var j=0; j<allSlides.length; j++)
			allSlides[j].style.width = slides[i].offsetWidth + 'px';
		slides[i].getElementsByClassName('slide-rightNav')[0].style.left = (slides[i].offsetWidth-40)+'px';
	}
}
function addPaddings()
{
	var box = document.getElementsByClassName('inner-padding');
	for (var i=0; i<box.length; i++)
	{
		box[i].innerHTML = '<div class="padding-box">' + box[i].innerHTML + '</div>'
	}
}
eventFuncDocumentMouseDrag = function(e)
{
	if(arguments.callee.elemMousePressed)
	{
		e = e || window.event;
		fixPageXY(e);
		
		arguments.callee.elemTitleBar.parentNode.style.marginLeft  = (parseInt(arguments.callee.elemTitleBar.parentNode.style.marginLeft.replace("px", ""))+(e.pageX-arguments.callee.elemLastX))+'px';
		arguments.callee.elemTitleBar.parentNode.style.marginTop = (parseInt(arguments.callee.elemTitleBar.parentNode.style.marginTop.replace("px", ""))+(e.pageY-arguments.callee.elemLastY))+'px';
		arguments.callee.elemLastX = e.pageX;
		arguments.callee.elemLastY = e.pageY;
	}			
};
function addTitleBarCallbacks(e)
{
	var titleBars = e.getElementsByClassName('titleBar');
	var eventFuncTitleMouseDown = new Array(titleBars.length);
	var eventFuncTitleMouseUp = new Array(titleBars.length);
	for(var i = 0; i < titleBars.length; i++)
	{
		
		eventFuncTitleMouseDown[i] = function(e)
		{
			//alert("down");
			e = e || window.event;
			fixPageXY(e);
			arguments.callee.elemFunc.elemLastX = e.pageX;
			arguments.callee.elemFunc.elemLastY = e.pageY;
			arguments.callee.elemFunc.elemMousePressed = true;
			arguments.callee.elemFunc.elemTitleBar = arguments.callee.elemTitleBar;
			//
		};
		eventFuncTitleMouseUp[i] = function(e)
		{
			arguments.callee.elemFunc.elemMousePressed = false;
		};
		eventFuncDocumentMouseDrag.elemLastX = 0;
		eventFuncDocumentMouseDrag.elemLastY = 0;
		eventFuncDocumentMouseDrag.elemMousePressed = false;
		eventFuncTitleMouseDown[i].elemFunc = eventFuncDocumentMouseDrag;
		eventFuncTitleMouseUp[i].elemFunc = eventFuncDocumentMouseDrag;
		eventFuncTitleMouseDown[i].elemTitleBar = titleBars[i];
		eventFuncTitleMouseUp[i].elemTitleBar = titleBars[i];
		document.onmousemove = eventFuncDocumentMouseDrag;
		titleBars[i].onmousedown = eventFuncTitleMouseDown[i];
		titleBars[i].onmouseup   = eventFuncTitleMouseUp[i];
	}
}
function addRatings(e)
{
	var newRatings = e.getElementsByClassName('comment-rating-new');
	var eventFuncRatingMouseMove = new Array(newRatings.length);
	var eventFuncRatingMouseClick = new Array(newRatings.length);
	var eventFuncRatingMouseOut = new Array(newRatings.length);
	for(var i = 0; i < newRatings.length; i++)
	{
		
		eventFuncRatingMouseMove[i] = function(e)
		{
			e = e || window.event;
			arguments.callee.elemRating.style.width = parseInt((e.pageX-cumulativeOffset(arguments.callee.elemRating).left)/15+0.5,10)*15+'px';
		};
		eventFuncRatingMouseClick[i] = function(e)
		{
			e = e || window.event;
			arguments.callee.elemRating.setAttribute('data-rating', parseInt((e.pageX-cumulativeOffset(arguments.callee.elemRating).left)/15+0.5,10)*15+'px');
			arguments.callee.elemRating.style.width = arguments.callee.elemRating.getAttribute('data-rating');
			
		};
		eventFuncRatingMouseOut[i] = function(e)
		{
			e = e || window.event;
			var element = e.toElement || e.relatedTarget
			if(element.className.indexOf('rating-fore-new')!==-1||element.className.indexOf('rating-back')!==-1)
				return;
			arguments.callee.elemRating.style.width = arguments.callee.elemRating.getAttribute('data-rating');
			//alert(element.className);
		};
		eventFuncRatingMouseMove[i].elemRating  = newRatings[i].getElementsByClassName('rating-fore-new')[0];
		eventFuncRatingMouseClick[i].elemRating = newRatings[i].getElementsByClassName('rating-fore-new')[0];
		eventFuncRatingMouseOut[i].elemRating   = newRatings[i].getElementsByClassName('rating-fore-new')[0];
		
		newRatings[i].onmousemove  = eventFuncRatingMouseMove[i];
		newRatings[i].onclick = eventFuncRatingMouseClick[i];
		newRatings[i].onmouseout   = eventFuncRatingMouseOut[i];
	}
}
function addInputDefaults(e)
{
	var Inputs = e.getElementsByTagName('input');
	var eventFuncInputKey = new Array(Inputs.length);
	for(var i = 0; i < Inputs.length; i++)
	{
		eventFuncInputKey[i] = function()
		{
			if(arguments.callee.elemInput.value != '')
			{
				if(arguments.callee.elemInput.parentNode.className.indexOf('no-input-default')==-1)
					arguments.callee.elemInput.parentNode.className += ' no-input-default';
			}
			else
				arguments.callee.elemInput.parentNode.className = arguments.callee.elemInput.parentNode.className.replace(' no-input-default','');
		};
		
		eventFuncInputKey[i].elemInput  = Inputs[i];
		
		Inputs[i].onkeyup     = eventFuncInputKey[i];
		Inputs[i].onmousedown = eventFuncInputKey[i];
		Inputs[i].onmouseup   = eventFuncInputKey[i];
		Inputs[i].onchange    = eventFuncInputKey[i];
		Inputs[i].onfocus     = eventFuncInputKey[i];
		Inputs[i].onblur      = eventFuncInputKey[i];
	}
}
function addIconAnimations(e)
{
	var Icons = e.getElementsByClassName('icon-anim');
	var eventFuncIcons = new Array(Icons.length);
	for(var i = 0; i < Icons.length; i++)
	{
		eventFuncIcons[i] = function()
		{
			//alert("|"+arguments.callee.elemIcon.style.backgroundPosition+"|");
			if(	arguments.callee.elemIcon.style.backgroundPosition==''||
				-parseInt(arguments.callee.elemIcon.style.backgroundPosition)>=(parseInt(arguments.callee.elemIcon.getAttribute('data-anim-count'))*23+parseInt(arguments.callee.elemIcon.getAttribute('data-anim-start'))))
				arguments.callee.elemIcon.style.backgroundPosition=arguments.callee.elemIcon.getAttribute('data-anim-start')+'px 23px';
			else
				arguments.callee.elemIcon.style.backgroundPosition=parseInt(arguments.callee.elemIcon.style.backgroundPosition)-23+'px '+arguments.callee.elemIcon.getAttribute('data-anim-row')+'px';
			//window.setTimeout(arguments.callee(),8000);//,arguments.callee.elemIcon.getAttribute('data-anim-delay'));
		};
		eventFuncIcons[i].elemIcon  = Icons[i];
		window.setInterval(eventFuncIcons[i],parseInt(Icons[i].getAttribute('data-anim-delay')));
		/*
		arguments.callee.elemIcon.getAttribute('data-anim-start');
		arguments.callee.elemIcon.getAttribute('data-anim-end');
		
		Inputs[i].onkeyup     = eventFuncInputKey[i];
		Inputs[i].onmousedown = eventFuncInputKey[i];
		Inputs[i].onmouseup   = eventFuncInputKey[i];
		Inputs[i].onchange    = eventFuncInputKey[i];
		Inputs[i].onfocus     = eventFuncInputKey[i];
		Inputs[i].onblur      = eventFuncInputKey[i];*/
	}
}
function addDismiss(e)
{
	for(var time=0; time < 21; time+=5)
	{
		var Dismiss = e.getElementsByClassName('auto-dismiss-'+time);
		var eventDismissAnim = new Array(Dismiss.length);
		var eventDismiss = new Array(Dismiss.length);
		for(var i = 0; i < Dismiss.length; i++)
		{
			eventDismissAnim[i] = function()
			{
				arguments.callee.elemDismiss.style.opacity='0';
			};
			eventDismiss[i] = function()
			{
				arguments.callee.elemDismiss.style.display='none';
			};
			eventDismissAnim[i].elemDismiss = Dismiss[i];
			eventDismiss[i].elemDismiss = Dismiss[i];
			window.setTimeout(eventDismissAnim[i], time*1000);
			window.setTimeout(eventDismiss[i], time*1000+200);
		}
	}
}
function addUnclickable(e)
{
	var Unc = e.getElementsByClassName('unclickable');
	var eventUncMove = new Array(Unc.length);
	for(var i = 0; i < Unc.length; i++)
	{
		eventUncMove[i] = function(event)
		{
			var cN = arguments.callee.elemUnc.className;
			cN = cN.replace(" hover", "");
			if(event.clientY > arguments.callee.elemUnc.offsetTop && event.clientX > arguments.callee.elemUnc.offsetLeft &&
				event.clientY < arguments.callee.elemUnc.offsetTop + arguments.callee.elemUnc.offsetHeight && 
				event.clientX < arguments.callee.elemUnc.offsetLeft + arguments.callee.elemUnc.offsetWidth)
				cN += ' hover';
			arguments.callee.elemUnc.className = cN;
		};		
		eventUncMove[i].elemUnc = Unc[i];
		document.body.onmousemove = eventUncMove[i];
	}
}
function pushNotification(header, body, dismiss)
{
	dismiss = dismiss || "10";
	var div = document.createElement("div");
	div.className = 'notification unclickable auto-dismiss-'+dismiss;
	div.innerHTML = '<div class="notification-header">'+header+'</div>'+body;
	document.getElementById('header').appendChild(div);
	addDismiss(document.getElementById('header'));
	addUnclickable(document.getElementById('header'));
}
function child_of(parent, child)
{
	if(child != null)
	{			
		while(child.parentNode)
		{
			if((child = child.parentNode) == parent)
				return true;
		}
	}
	return false;
}
function fixOnMouseOut(element, event, JavaScript_code)
{
	var current_mouse_target = null;
	if(event.toElement)
		current_mouse_target = event.toElement;
	else if(event.relatedTarget)
		current_mouse_target = event.relatedTarget;
	
	if(!child_of(element, current_mouse_target) && element != current_mouse_target)
		return false
	return true;
}
var cumulativeOffset = function(element) {
    var top = 0, left = 0;
    do {
        top += element.offsetTop  || 0;
        left += element.offsetLeft || 0;
        element = element.offsetParent;
    } while(element);

    return {
        top: top,
        left: left
    };
};
function fixPageXY(e)
{
	if (e.pageX == null && e.clientX != null )
	{
		var html = document.documentElement;
		var body = document.body;
		
		e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
		e.pageX -= html.clientLeft || 0;
		
		e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0);
		e.pageY -= html.clientTop || 0;
	}
}

function getHeight()
{
	var winW = 630, winH = 460;
	if (document.body && document.body.offsetWidth) {
		winH = document.body.offsetHeight;
	}
	if (document.compatMode=='CSS1Compat' &&
		document.documentElement &&
		document.documentElement.offsetWidth ) {
		winH = document.documentElement.offsetHeight;
	}
	if (window.innerWidth && window.innerHeight) {
		winH = window.innerHeight;
	}
	return winH;
}
function getWidth()
{
	var winW = 630, winH = 460;
	if (document.body && document.body.offsetWidth) {
		winW = document.body.offsetWidth;
	}
	if (document.compatMode=='CSS1Compat' &&
		document.documentElement &&
		document.documentElement.offsetWidth ) {
		winW = document.documentElement.offsetWidth;
	}
	if (window.innerWidth && window.innerHeight) {
		winW = window.innerWidth;
	}
	return winW;
}
function loadPreview(id)
{
	var val = document.getElementById(id).value;
	document.getElementById(id).innerHTML = val;
	loadDialogue('previewWiki', '', val);
}
