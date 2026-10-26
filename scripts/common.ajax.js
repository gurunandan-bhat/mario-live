// Enliven Process 
function EnlivenPage()
{
	// alert('EnlivenPage');
	timedinterval = setInterval("EnlivenProcess()",30000000);
}

function EnlivenProcess()
{
	var url_str = "./includes/_ajax_module.php?response=ENLIVEN";
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	http.open("GET", url_str+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if(http.readyState == 4)
		{
			if(document.getElementById('div_enliven'))
				document.getElementById('div_enliven').innerHTML = http.responseText;
		}
	};
	http.send(null);
}

function IsCodeUnique(id, obj, mode, prefix)
{
	var val = obj.value;
	if(!prefix || prefix == "undefined")
		prefix = '';
	
	var url_str = './includes/ajax.inc.php?response=UNIQUE_CODE&id='+id+'&val='+val+'&mode='+mode;
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	
	http.open("POST", url_str + "&rand=" + myRandom, true);
	http.onreadystatechange = function ()
	{
		if (http.readyState == 4)
		{
			//alert(http.responseText);
			
			var ctrl_obj = document.getElementById(prefix+'code_flag');
			
			if(ctrl_obj)
			{
				ctrl_obj.value = http.responseText;
								
				if(ctrl_obj.value=='0') // unavailable
				{
					obj.style.backgroundColor = "#ffcfcf";
				}
				else
				{
					obj.style.backgroundColor = "#cfffcf";
				}
			}
		}
	};
	http.send(null);
}

function GenerateUniqueCode(id, val, mode, txtcode_id)
{
	var code_obj = document.getElementById(txtcode_id);
	val = str_trim(val);
	
	if(val== '' || !code_obj) //  || code_obj.value!=''
		return false;

	var url_str = './includes/ajax.inc.php?response=GENERATE_UNIQUE_CODE&id='+id+'&val='+val+'&mode='+mode;
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	
	http.open("POST", url_str + "&rand=" + myRandom, true);
	http.onreadystatechange = function ()
	{
		if (http.readyState == 4)
		{
			if(http.responseText!='0')
				code_obj.value = http.responseText;
		}
	};
	http.send(null);
}

function ChangeCSSStatus(url, status, id, flag) // url = xyz.php?mode=
{
	var url_str = url+"&status="+status+"&id="+id+"&flag="+flag;
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	http.open("POST", url_str+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			// alert(http.responseText);
			if(http.responseText!='false') // only if successful...
			{
				data = http.responseText.split("~");
			
				if(data[0]==1)
				{	
					document.getElementById("css_0_status_"+id).innerHTML=data[1];
					document.getElementById("css_u_status_"+id).innerHTML=data[2];
					document.getElementById("css_v_status_"+id).innerHTML=data[3];
					// JQueryNotify(result_str,'warning',false);
				}
			}
		}
	};
	
	http.send(null);
}

function ShowData(a_obj, id, flag)
{
	var a_txt = a_obj.innerHTML;
	var td_obj = a_obj.parentNode;
	var td_css = td_obj.className;
	var tr_obj = td_obj.parentNode;
	var td_len = tr_obj.cells.length;
	var tbl_obj = tr_obj.parentNode;
	var j = tr_obj.rowIndex+1;
	ToggleElement(tbl_obj, 0);

	var url_str = "lead_dat_list.php?AJAX=1&hdr=1&lid="+id;
	var suffix = 'tasks';
		
	var myRandom=parseInt(Math.random()*99999999);  // cache buster

	http.open("POST", url_str+"&rand=" + myRandom, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4)
		{
			if(http.responseText!='false') // only if successful...
			{
				var tr_id = 'tr_'+id+'_'+suffix;

				tbl_obj.insertRow(j);
				tbl_obj.rows[j].id = 'tr_'+id+'_'+suffix;
				tbl_obj.rows[j].innerHTML = '<td class="'+td_css+'">&nbsp;</td><td class="'+td_css+'" colspan="'+(td_len-1)+'">'+str_trim(http.responseText)+'</td>'; // ;
				
				a_obj.setAttribute('onclick', 'ToggleElement(0, \''+tr_id+'\')'); 
			}
		}
	};
	http.send(null);
}

function ToggleElement(tbl, tr_id)
{	
	if(tbl==0 && tr_id==0)
		return false;
		
	if(tbl==0)
		tbl = document.getElementById(tr_id).parentNode;
	
	var row_len = tbl.rows.length;
	
	for(var i=0; i < row_len; i++)
	{
		if(tbl.rows[i].id.indexOf('tr_')!=-1 && tbl.rows[i].style.display!='none' && tbl.rows[i].id!=tr_id)
			tbl.rows[i].style.display='none';
	}
	
	ToggleVisibility(tr_id);	
}

function RefreshRow(mode, id)
{	
	var tr_id = 'tr'+mode.toLowerCase()+'_'+id;
	var tr_obj = parent.document.getElementById(tr_id);
	var is_srno = false;
	
	if(tr_obj)
	{
		var tr_srno = parent.document.getElementById(tr_id).cells[0].innerHTML;
		var tr_srno = tr_srno.replace('.', '');
		is_srno = (isNaN(tr_srno))? false: true;
	}
	
	var url_str = './includes/ajax.inc.php?response='+mode+'_REFRESH_ROW&id='+id;
	if(is_srno) url_str += '&i='+tr_srno;
	var myRandom=parseInt(Math.random()*99999999);  // cache buster
	
	http.open("POST", url_str + "&rand=" + myRandom, true);
	http.onreadystatechange = function ()
	{
		if (http.readyState == 4)
		{
			if(http.responseText!='false' && tr_obj)
			{
				// DumpProperties(parent.document.getElementById(tr_id).childNodes[0]);
				parent.document.getElementById(tr_id).innerHTML = http.responseText;
				parent.ReadifyFancyZoom();
			}
		}
	};
	
	http.send(null);	
}