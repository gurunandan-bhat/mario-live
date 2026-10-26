try 
{
	http = new XMLHttpRequest(); /* e.g. Firefox */
	http2 = new XMLHttpRequest(); /* e.g. Firefox */
} 
catch(e) 
{
	try 
	{
    	http = new ActiveXObject("Msxml2.XMLHTTP"); 
		http2 = new ActiveXObject("Msxml2.XMLHTTP"); 
  	}
	catch (e) 
	{
    	try 
		{
    		http = new ActiveXObject("Microsoft.XMLHTTP");  /* some versions IE */
    		http2 = new ActiveXObject("Microsoft.XMLHTTP");  /* some versions IE */
    	} 
		catch (E) 
		{
			http = false;
			http2 = false;
		} 
	} 
}
function ChangeStatus(obj, mode, status, id)
{
//		alert("./includes/ajax.inc.php?response=UPDATE_STATUS&mode="+mode+"&status="+status+'&id='+id);
	jQuery.get("../includes/ajax.inc.php", {response:'UPDATE_STATUS', mode:mode, status:status, id:id, rand:parseInt(Math.random()*99999999)}, function(results) {
		var result = results.split('~');
		obj.parentNode.innerHTML=result[0];		
		jQuery('#LBL_INFO').html(NotifyThis(result[1], 'success'));
		//InitNotifyClose();
	});
/*	.error(function() {
		jQuery('#LBL_INFO').html(NotifyThis('Error Occured When Making This Request', 'error'));
		//InitNotifyClose();
	});	// */
}
function ChangeFeatured(obj, mode, status, id)
{
//		alert("./includes/ajax.inc.php?response=UPDATE_STATUS&mode="+mode+"&status="+status+'&id='+id);
	jQuery.get("../includes/ajax.inc.php", {response:'UPDATE_FEATURED', mode:mode, status:status, id:id, rand:parseInt(Math.random()*99999999)}, function(results) {
		var result = results.split('~');
		obj.parentNode.innerHTML=result[0];		
		jQuery('#LBL_INFO').html(NotifyThis(result[1], 'success'));
		//InitNotifyClose();
	});
/*	.error(function() {
		jQuery('#LBL_INFO').html(NotifyThis('Error Occured When Making This Request', 'error'));
		//InitNotifyClose();
	});	// */
}
function ChangeFeatured2(obj, mode, status, id)
{
//		alert("./includes/ajax.inc.php?response=UPDATE_STATUS&mode="+mode+"&status="+status+'&id='+id);
	jQuery.get("../includes/ajax.inc.php", {response:'UPDATE_FEATURED2', mode:mode, status:status, id:id, rand:parseInt(Math.random()*99999999)}, function(results) {
		var result = results.split('~');
		obj.parentNode.innerHTML=result[0];		
		jQuery('#LBL_INFO').html(NotifyThis(result[1], 'success'));
		//InitNotifyClose();
	});
/*	.error(function() {
		jQuery('#LBL_INFO').html(NotifyThis('Error Occured When Making This Request', 'error'));
		//InitNotifyClose();
	});	// */
}
function ChangeTopSeller(url, topseller, id) // url = xyz.php?mode=
{
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	http.open("POST", url_str +"topseller="+topseller+"&id="+id+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			// alert(http.responseText);
			if(http.responseText!='false') // only if successful...
			{
				results = http.responseText.split("~");
				result_len = results.length;

				var img_str = results[1];
				//alert(img_str);
				var result_str = results[2];
				var mode = (result_len >= 4)? results[3]+"_": "";
				
				document.getElementById(mode+"topseller_"+id).innerHTML=img_str;
				JQueryNotify(result_str,'warning',false);
			}
		}
	};
	http.send(null);
}
function ChangeHome(url, home_status, id) // url = xyz.php?mode=
{
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	http.open("POST", url_str +"home_status="+home_status+"&id="+id+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			//alert(http.responseText);
			if(http.responseText!='false') // only if successful...
			{
				results = http.responseText.split("~");
				result_len = results.length;

				var img_str = results[1];
				//alert(img_str);
				var result_str = results[2];
				var mode = (result_len >= 4)? results[3]+"_": "";
				
				//window.location.reload(true);
				
				document.getElementById(mode+"home_"+id).innerHTML=img_str;
				JQueryNotify(result_str,'warning',false);
			}
		}
	};
	http.send(null);
}
function ChangeProductAttribStat(url, status, p_id, pp_id) // url = xyz.php?mode=
{
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	http.open("GET", url_str+"status="+status+"&p_id="+p_id+"&pp_id="+pp_id+"&rand=" + myRandom, true);
	// alert(url_str +"status="+status+"&id="+id);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			// alert(http.responseText);
			if(http.responseText!='false') // only if successful...
			{
				results = http.responseText.split("~");
				result_len = results.length;

				var img_str = results[1];
				//alert(img_str);
				var result_str = results[2];
				var mode = (result_len >= 4)? results[3]+"_": "";
				
				document.getElementById(mode+"status_"+pp_id).innerHTML=img_str;
				JQueryNotify(result_str,'warning',false);
			}
		}
	};
	http.send(null);
}
function ChangeDefault(url, d_val, p_id, pp_id) // url = xyz.php?mode=
{
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	http.open("GET", url_str+"d_val="+d_val+"&p_id="+p_id+"&pp_id="+pp_id+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			//alert(http.responseText);
			if(http.responseText!='false') // only if successful...
			{
				results = http.responseText.split("~");
				result_len = results.length;

				var img_str = results[1];
				//alert(img_str);
				var result_str = results[2];
				var mode = (result_len >= 4)? results[3]+"_": "";
				
				document.getElementById(mode+"d_val_"+id).innerHTML=img_str;
				JQueryNotify(result_str,'warning',false);
			}
		}
	};
	http.send(null);
}
function ChangeImgStat(url, status, pc_id, a_id) // url = xyz.php?mode=
{
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	http.open("GET", url_str+"status="+status+"&pc_id="+pc_id+"&a_id="+a_id+"&rand=" + myRandom, true);
	// alert(url_str +"status="+status+"&id="+id);
	http.onreadystatechange = handleHttpImgStatResponse;
	http.send(null);
}
function handleHttpImgStatResponse()	// return type flag~id~display string
{
	if (http.readyState == 4)
	{
		if(http.responseText!='false') // only if successful...
		{
			results = http.responseText.split("~");
			result_len = results.length;

			alert(http.responseText);
		
			var pc_id = results[1];
			var a_id = results[2];
			var img_str = results[3];

			alert(pc_id);
			alert(a_id);
			alert(img_str);

			document.getElementById("status_"+a_id).innerHTML=img_str;
			//JQueryNotify(result_str,'warning',false);
		}
  	}
}
function ChangeLeadStatus(url, status, id) // url = xyz.php?mode=
{ 
	//alert(url+', '+status+', '+id);
	var url_str = url+"&";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	http.open("GET", url_str +"status="+status+"&id="+id+"&rand=" + myRandom, true);
	 //alert(url_str +"status="+status+"&id="+id+"&rand=" + myRandom);
	http.onreadystatechange = handleHttpStatusResponse;
	http.send(null);
}

function handleHttpStatusResponse()	// return type flag~id~display string
{	
}

function handleHttpSetResponse() 
{
	if (http.readyState == 4) 
	{
		// alert(http.responseText);
		results = http.responseText.split("~");

		str = results[1];
		div_nm = results[2];
		
		if(results[0] && document.getElementById(div_nm))	//SUCCESFULL IN UPDATING
			document.getElementById(div_nm).innerHTML=str;
  	}
}

function handleHttpSetValueResponse() 
{
	if (http.readyState == 4) 
	{
		// alert(http.responseText);
		results = http.responseText.split('~');

		str = results[1];
		ctrl_id = results[2];

		if(results[0] && document.getElementById(ctrl_id))	//SUCCESFULL IN UPDATING
			document.getElementById(ctrl_id).value=str;
  	}
}
function serverData() {};

serverData.prototype.init = function() 
{
	try 
	{
		this._xh = new XMLHttpRequest(); // Mozilla / Safari
	} 
	catch (e) 
	{
		// Explorer
		var _ieversions = new Array('MSXML2.XMLHTTP.5.0','MSXML2.XMLHTTP.4.0','MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP','Microsoft.XMLHTTP');
		var success = false;
		
		for (var i=0;i < _ieversions.length && !success; i++) 
		{
			try 
			{
				this._xh = new ActiveXObject(_ieversions[i]);
				success = true;
			} 
			catch (e) {} // Implementar manejo de excepciones
		}
		
		if (!success) 
		{
			return false; // Implementar manejo de excepciones, mientras alerta.
		}
		
		return true;
	}
}

serverData.prototype.busy = function() 
{
	estadoActual = this._xh.readyState;
	return (estadoActual && (estadoActual < 4));
}

serverData.prototype.processes = function() 
{
	if (this._xh.readyState == 4 && this._xh.status == 200) 
	{
		this.processesdo = true;
	}
}

serverData.prototype.send = function(urlget,datos) 
{
	if (!this._xh) 
	{
		this.init();
	}
	
	if (!this.busy()) 
	{
		this._xh.open("POST",urlget,false);
		this._xh.send(datos);
		
		if (this._xh.readyState == 4 && this._xh.status == 200) 
		{
			return this._xh.responseText;
		}
	}

	return false;
}
function numbersonly(e)
{
	var unicode = e.charCode ? e.charCode : e.keyCode;
	
	if( unicode != 8 && unicode!=46 && unicode!=43)   //if the key isn't the backspace key (which we should allow)
	{
		if(unicode < 48 || unicode > 57)   //if not a number
				return false;  //disable key press
		else
			return true;   // enable keypress
	}
	else
	{
		return true;   // enable keypress
	}
}
function UpdateRank(str,rank, id)
{
	//var rank = obj.value;
	var url_str = '../includes/ajax.inc.php?response='+str+'_RANK&id='+id+'&rank='+rank;
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	//alert(url_str);
	http.open("POST", url_str+"&rand=" + myRandom, true);
	http.onreadystatechange = handleHttpSilentResponse;
	http.send(null);	// */
}
function handleHttpSilentResponse() // success! now don't do nething!
{
	if (http.readyState == 4) 
	{
		 //alert(http.responseText);
  	}
}

function NotifyThis(text, mode)
{
	var mode_str = 'msgalert';
	
	if(mode == 'success') mode_str = 'alert-success';
	else if(mode == 'error') mode_str = 'alert-danger';
	else if(mode == 'info') mode_str = 'alert-warning';
	
	text = str_trim(text);
	return (text!='')? ' <div id="bootstrap_alerts_demo"><div id="prefix_325378209810" class="custom-alerts alert '+mode_str+' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'+text+'</div></div>': '';
}

function InitNotifyClose()
{
	jQuery('.notification .close').click(function(){
		jQuery(this).parent().fadeOut();
	});
}