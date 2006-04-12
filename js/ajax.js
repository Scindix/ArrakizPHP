var ajax = (function () {
	var instance = {};

	instance.getHTML = function (page, func, args, data) {
		args = args || "";
		data = data || "";
        var request = ajax.makeHttpObject();
		request.open("PUT", Settings.MyServer+'/ajax.php', true);
		request.onreadystatechange = function() {
			if(this.readyState == this.DONE) 
			{
				if(this.onreadystatechange)
				{
					request.onreadystatechange = null;
					func(request.responseText);
				}
			}
		}
		request.send('src=' + page + "&" + args + "data://"+data);
	};
	instance.getFrame = function (page, func, args, data) {
		args = args || "";
		data = data || "";
		instance.getHTML('frames/' + page, func, 'get=frame&' + args, data);
	}
	instance.getFrameScript = function (page, func, args, data) {
		args = args || "";
		data = data || "";
		instance.getHTML('frames/' + page, func, 'get=script&' + args, data);
	}
	instance.getDialogue = function (page, func, args, data) {
		args = args || "";
		data = data || "";
		instance.getHTML('dialog/' + page, func, 'get=dialog&' + args, data);
	}
	instance.getDialogueScript = function (page, func, args, data) {
		args = args || "";
		data = data || "";
		instance.getHTML('dialog/' + page, func, 'get=script&' + args, data);
	}
	
	/*instance.getDialogue = function (page, func, args="", data="") {
        var request = ajax.makeHttpObject();
		request.open("PUT", Settings.MyServer+'/ajax.php', true);
		request.onreadystatechange = function() {
			if(this.readyState == this.DONE) 
			{
				if(this.onreadystatechange)
				{
					request.onreadystatechange = null;
					func(request.responseText);
				}
			}
		}
		request.send('get=dialog&src=dialog/' + page + "&" + args + "data://"+data);
	};

	instance.getDialogueScript = function (page, func, args="", data="") {
        var request = ajax.makeHttpObject();
		request.open("PUT", Settings.MyServer+'/ajax.php', true);
		request.onreadystatechange = function() {
			if(this.readyState == this.DONE) 
			{
				if(this.onreadystatechange)
				{
					request.onreadystatechange = null;
					func(request.responseText);
				}
			}
		}
		request.send('get=script&src=dialog/' + page + "&" + args + "data://"+data);
	};*/
	
	instance.addComment = function (title, comment, rating, streamID, postBlock, func) {
        var request = ajax.makeHttpObject();
		request.open("GET", Settings.MyServer+'/addComment.php?title='+ title +'&comment=' + comment +'&rating=' + rating +'&streamID=' + streamID +'&postBlock=' + postBlock, true);
		request.onreadystatechange = function() {
			func(request.responseText);
		}
		request.send(null);
	};
	
	instance.makeHttpObject = function (s) {
		try {return new XMLHttpRequest();}
			catch (error) {}
		try {return new ActiveXObject("Msxml2.XMLHTTP");}
			catch (error) {}
		try {return new ActiveXObject("Microsoft.XMLHTTP");}
			catch (error) {}

	  throw new Error("Could not create HTTP request object.");
	};

	return instance;
})();
