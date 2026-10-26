function validate_email(email_txt) // validates a string as a email id
{
	var emailReg = "^[\\w-_\.]*[\\w-_\.]\@([\\w].+)\.[\\w]$";
	var regex = new RegExp(emailReg);
	return regex.test(email_txt);
}

function validate_integer(int_str) // validates a string as an integer (i.e. no decimal points)
{
	regExpr = new RegExp(/^\d*$/);
	var regex = new RegExp(regExpr);
	return regex.test(int_str);
}

function validate_real_nos(real_nos_str) // validates a string as a Real Number (i.e. with decimal points)
{
	regExpr = new RegExp(/^-?\d*(\.\d{1,2})?$/);
	var regex = new RegExp(regExpr);
	return regex.test(real_nos_str);
}

function RoundOff(number, n, pad_flag) // rounds up given no to 'n' number of places
{
	str='';
	number=parseFloat(number);
	if(!isNaN(number))
	{
		power=Math.pow(10,n);
		number=Math.round(number*power)/power;
		
		if(pad_flag)
		{	
			var number_str = number.toString();			
			var dot = number_str.indexOf('.');
			var dot_str = '';
			var dot_i = n;

			if(dot < 0)
				dot_i = 0;
			else
			{
				var diff = number_str.length - dot - 1;
				
				if(diff < n)
					dot_i = diff;
			}


			if(dot_i < n)
			{
				if(dot_i < 1)
					dot_str = '.';
				
				for(; dot_i < n; dot_i++)
					dot_str += '0';
			
				number = number_str + dot_str;			
			}
		}
	}

	return number;
}

function str_trim(str) // strips of leading and following whitespaces from a string
{	
	if(str.length > 0)
		while(str.charAt(0)==' ')
			str = str.substr(1);
		
	if(str.length > 0)
		while(str.charAt((str.length - 1))==' ')
			str = str.substring(0, str.length-1);
	
	return str;
}

function str_implode(arr, delim) // Join array elements with a string
{
	var ret_str = "";
	var arr_len = 0;

	arr_len = arr.length;
	delim_len = delim.length;
	
	if(arr_len > 0)
	{
		for(var i=0; i < arr_len; i++)
			ret_str += delim + arr[i];

		if(ret_str.substr(0, delim_len))
			ret_str = ret_str.substr(delim_len);
	}
	
	return ret_str;
}

function str_explode(arr, delim)
{
	var ret_str = "";
	var arr_len = 0;

	arr_len = arr.length;
	delim_len = delim.length;
	
	if(arr_len > 0)
	{
		for(var i=0; i < arr_len; i++)
			ret_str += delim + arr[i];

		if(ret_str.substr(0, delim_len))
			ret_str = ret_str.substr(delim_len);
	}
	
	return ret_str;
}

function submitenq()
{   
	e=0;	 // means error
	for (var i = 0; i < document.enq.elements.length; i++) 
	{
		if(document.enq.elements[i].type == 'checkbox')
		{
			if(document.enq.elements[i].checked )
			{
				e=0;
				break;
			}
			else
				e=1;	   	   
		}
	}
	
	if( e==1) // do nothing !!!
		alert("Select a message")
	else
		document.enq.submit();
}

function CheckNum(obj) // validates a form ctrl for an integer
{
	regExpr = new RegExp(/^\d*$/);

	if(str_trim(obj.value)=="" || !regExpr.test(obj.value))
		obj.value="0";		
}

function CheckNum2(obj) // validates a form ctrl for an integer
{
	regExpr = new RegExp(/^\d*$/);

	if(!regExpr.test(obj.value))
		obj.value="0";		
}

function CheckRealNum(obj) // validates a form ctrl for a real number
{
	regExpr=new RegExp(/^-?\d*(\.\d*)?$/);
	
	if(str_trim(obj.value)=="" || !regExpr.test(obj.value) || isNaN(obj.value) || obj.value < 0)
		obj.value="0";		
}

// NAVIGATION BASED
function AddAnother()
{ 
	if(Validate())
	{
		document.forms[0].add_mode.value = "Y";
		document.forms[0].submit();
	}
	else
		document.forms[0].add_mode.value = "N";
}

function GoToPage(page)
{
	window.document.location.href=page;
}

function ConfirmDelete(txt, page)
{
	var msg = "You Are About To Delete this " + txt + "! Continue?";

	if(confirm(msg))
		window.document.location.href=page;
}

function ConfirmBox(txt,action, page)
{
	var msg = "You Are About To " + action + " this " + txt + "! Continue?";

	if(confirm(msg))
		window.document.location.href=page;
}

function SubmitToThisPage(frm_nm, ctrl_nm, page_name)
{
	var page_no = document.getElementById(ctrl_nm).value;	
	var frm = eval("document."+frm_nm);
	
	frm.action = page_name+"?page="+page_no;
	frm.submit();
}

function SubmitPage(frm_nm, page)
{
	var frm = eval("document."+frm_nm);	
	frm.action = page;
	frm.submit();
}

function DefaultFocus(ctrl_nm)
{
	if(document.getElementById(ctrl_nm))
	{
		obj = document.getElementById(ctrl_nm);
		obj.focus();
	}
}

function SetFocus(obj)
{
	// alert('SetFocus');
	obj.focus();
	obj.select();
}

function UploadMailerPics()
{
	info="upload_images.php";
	window.open(info,"","menubars=0,width=500,height=550,scrollbars=1,resizable=1");
}

function ChangeRank(mode, fld, fld_val)
{
	var str = "";

	if(fld != "" && fld_val != "")
		str = "&fld=" + fld + "&fld_val=" + fld_val;

	var file = "rank-update.php?mode="+mode+str;
	win = window.open(file,'ChangeRank','width=900,height=600,scrollbars=1,resizable=1');
	WindowPosition(900,600,win);
}

function ChangeImageRank(mode, fld, fld_val)
{
	var str = "";

	if((!fld || fld == "undefined") && (!fld_val || fld_val == "undefined")) {}
	else
		str = "&fld=" + fld + "&fld_val=" + fld_val;

	var file = "uploaded_image_disp.php?mode="+mode+str; //	var file = "image-rank-update.php?mode="+mode+str;
	win = window.open(file,'ChangeRank','width=900,height=600,scrollbars=1,resizable=1');
	WindowPosition(900,600,win);
}

function WindowPosition(widthX,heightX,windowName)
{
	var width = (screen.width);
	var height = (screen.height - 25);
	var centerleft = 0;
	var centertop = 0;
	var centerleft = (width/2) - (widthX/2);
	var centertop = (height/2) - (heightX/2);

	windowName.moveTo(centerleft,centertop);
//	windowName.resizeTo(widthX, heightX);
	windowName.focus();
}

function WindowPosition2(widthX,heightX,windowName) //same as above, only it takes %age vals as params for width n height
{
	var width = (screen.width);
	var height = (screen.height - 25);
		
	var wt = (width * widthX) / 100;
	var ht = (height * heightX) / 100;

	var centerleft = (width/2) - (wt/2);
	var centertop = (height/2) - (ht/2);

	windowName.resizeTo(wt, ht);
	windowName.moveTo(centerleft,centertop);
	windowName.focus();
}

function FillFromList(list_obj)
{
	var cmb = list_obj;

	str = "";
		
	for(i=0; i < cmb.length; i++)
		if(cmb.options[i])
			str += "~" + cmb.options[i].value;
	
	return str.substr(1);
}

function ConvertFromYMDtoDMY(ymd_date)
{
	var dt_arr = ymd_date.split('-');
	var dmy_date = dt_arr[2] + "-" + dt_arr[1] + "-" + dt_arr[0];
	return dmy_date;
}

function ConvertFromDMYtoYMD(dmy_date)
{
	var dt_arr = dmy_date.split('-');
	var ymd_date = dt_arr[2] + "-" + dt_arr[1] + "-" + dt_arr[0];
	return ymd_date;
}

function GetRadioValue(rd_obj)
{
	for(var i=0; i < rd_obj.length; i++)
	{
		if(rd_obj[i].checked)
			return rd_obj[i].value;
	}

	return false;
}

function GetRadioID(rd_obj)
{
	for(var i=0; i < rd_obj.length; i++)
	{
		if(rd_obj[i].checked)
			return rd_obj[i].id;
	}

	return false;
}

function ChangeRankX(mode, cond_str)
{
	var str = "";

	if(cond_str && cond_str != "")
		str = "&cond_str=" + cond_str;

	var file = "rank-updatex.php?mode="+mode+str;
	win = window.open(file,'ChangeRank','width=900,height=600,scrollbars=1,resizable=1');
	WindowPosition(900,600,win);
}

function SetIFrameSrc(iframe_name, url)
{
	if(!document.getElementById(iframe_name))
		return false;
	
	document.getElementById(iframe_name).src = url;
}

var win='';
function OpenPopup(file)
{
	if (win.location && !win.closed) 
	{
		// win.location.href = url;
		win.focus(); 
	}
	else 
	{	// 
		win = window.open(file,'Popup','width=600,height=450,scrollbars=1,resizable=1');
		WindowPosition(600,450,win);
	}
}


function PicExists()
{
	alert("Picture already exists..Please delete the existing picture to add a new one!!!");
	return false;
}

function DateDiff(dtfrom,dto) // works with d-m-Y formatted dates
{
	var ret_val = false;
	
	fday = dtfrom.substr(0,2);
	tday = dto.substr(0,2);
	fmonth = dtfrom.substr(3,2);
	tmonth = dto.substr(3,2);
	fyear = dtfrom.substr(6,4);
	tyear = dto.substr(6,4);
	
	dtFdate = new Date(fyear,fmonth,fday);
	dtTdate = new Date(tyear,tmonth,tday);
	
	var sOneDay = 1000*60*60*24;
	var iDiff = dtTdate-dtFdate;
	var diff = (iDiff/sOneDay);
	
	return diff;
}

function UploadImages()
{ 
	info="upload_images.php";
	win = window.open(info,'editor','menubars=0,width=500,height=550,scrollbars=1,resizable=1');
	WindowPosition(1050,450,win);
}

function VerifyDate(str_dt1, str_dt2) //(1st date[from], 2nd date[to])
{	
	var arr_dt1 = str_dt1.split("-");
	dt1 = new Date(arr_dt1[1] + "/" + arr_dt1[0] + "/" + arr_dt1[2]);

	var arr_dt2 = str_dt2.split("-");
	dt2 = new Date(arr_dt2[1] + "/" + arr_dt2[0] + "/" + arr_dt2[2]);

	difference = dt2 - dt1;
	years = difference/(1000*60*60*24*365);

	if(difference < 0)
		return false;

	return true;
}

function in_array(str, arr)
{
	var ret_flag = false;
	var arr_len = 0;

	arr_len = arr.length;

	if(arr_len > 0)
	{
		for(var i=0; i < arr_len; i++)	
			if(arr[i] == str)
			{
				ret_flag = true;
				break;
			}
	}

	return ret_flag;
}

function ArrayIndex(arr, str)
{
	var ret_flag = false;
	var arr_len = 0;

	arr_len = arr.length;

	if(arr_len > 0)
	{
		for(var i=0; i < arr_len; i++)	
			if(arr[i] == str)
			{
				ret_val = i;
				break;
			}
	}

	return ret_val;
}

function ToggleOptions(obj_id)
{
	if(!document.getElementById(obj_id))
		return false;
	
	obj = document.getElementById(obj_id);
	var disp_flag = obj.style.display;
	disp_cmb_flag = true;
	
	if(disp_flag == "none")
	{
		disp_cmb_flag = false;
		var div_arr = document.getElementsByTagName("div");
		var div_len = div_arr.length;
		
		for(var i=0; i < div_len; i++)
		{
			var div_nm_arr = div_arr[i].id.split("_");
			
			// if any other sliders are open...
			if(div_nm_arr[0] == "slide" && div_arr[i].style.display != "none")
				div_arr[i].style.display = "none";
		}

		obj.style.display = "block";
	}
	else
		obj.style.display = "none";

	ToggleComboBoxVisibility(disp_cmb_flag);
}

function SetSelectedValues(form_name, chk_obj, txt_nm, lbl_nm)
{
	var chk_val = chk_obj.value.split('~');
	var chk_id = chk_val[0];
	var chk_nm = chk_val[1];

	var txt_obj = eval("document."+form_name+"."+txt_nm);	
	var txt_arr = txt_obj.value.split(',');
	var txt_cnt = txt_arr.length;

	var lbl_obj = document.getElementById(lbl_nm);
	var lbl_arr = lbl_obj.innerHTML.split(',');
	var lbl_cnt = lbl_arr.length;

	if(chk_obj.checked) // add to list
	{
		if(txt_cnt > 0 && txt_obj.value!='')
		{
			if(!in_array(chk_id, txt_arr))
			{
				txt_obj.value += ","+chk_id;
				lbl_obj.innerHTML += ", " + chk_nm;
			}
		}
		else
		{
			txt_obj.value = chk_id;
			lbl_obj.innerHTML = chk_nm;
		}
	}
	else // remove from list
	{
		var rmv_index = -1; // index of value to be removed...
		
		if(txt_cnt > 0 && txt_obj.value!='')
		{
			rmv_index = ArrayIndex(txt_arr, chk_id);

			if(rmv_index > -1)
			{
				for(var i=rmv_index; i < txt_arr.length; i++)
				{
					if(i != (txt_arr.length - 1)) // not the last element in the array
					{
						txt_arr[i] = txt_arr[i+1];
						lbl_arr[i] = lbl_arr[i+1];
					}
				}
				
				txt_arr.length = (txt_cnt - 1); // pop off the last array item
				lbl_arr.length = (lbl_cnt - 1);
				txt_obj.value = txt_arr.join(",");
				lbl_obj.innerHTML = lbl_arr.join(",");
			}
		}
		
		if(txt_obj.value == "")
			lbl_obj.innerHTML = "None Selected";
	}
} 

function ToggleComboBoxVisibility(flag)
{
	visibility_mode = (flag)? "visible": "hidden";

	for(var i = 0; i < document.forms.length; i++) 
		for(var j=0; j < document.forms[i].elements.length; j++)
			if(document.forms[i].elements[j].type == 'select-one')
				document.forms[i].elements[j].style.visibility = visibility_mode;
}

function ToggleFilterVisibiltity(frm)
{
	var tbl_obj = document.getElementById(frm);
	if(!tbl_obj)
		return false;
	
	tbl_obj.style.display = (tbl_obj.style.display=='none')? '': 'none';
}

function ToggleVisibility(obj_id)
{
	var obj = document.getElementById(obj_id);
	if(!obj)
		return false;
	
	obj.style.display = (obj.style.display=='none')? '': 'none';
}

function divX(div_width) // width
{
	var screen_width = (screen.width);
	var width_offset = posLeft();
	var x = (width_offset + (screen_width/2) - (div_width/2));
	return x;
}

function divY(div_height) // height
{
	var screen_height = (screen.height - 100);
	var height_offset = posTop();
	var y = height_offset + (screen_height/2) - (div_height/2);
	return y;
}

function posTop() 
{
	return (typeof window.pageYOffset != 'undefined') 
			? window.pageYOffset : (document.documentElement && document.documentElement.scrollTop) 
									? document.documentElement.scrollTop: document.body.scrollTop;
}

function posLeft() 
{
	return (typeof window.pageXOffset != 'undefined') 
			? window.pageXOffset : (document.documentElement && document.documentElement.scrollLeft) 
									? document.documentElement.scrollLeft: document.body.scrollLeft;
}

function EnterThisPage(url) // only for pagination...
{
	if(window.event.keyCode == 13)
		window.document.location.href=url;
}

function isEnterKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode // if not a digit or arrow key abort
	// return ( charCode == 13)? true: false;
	
	return (charCode == 13)? true: false;
}

function EnterThisFunction(e) // only for pagination...
{
// document.onkeydown = checkKeycode
	var keycode;
	if (window.event)
	{
		// alert('window.event');
		keycode = window.event.keyCode;
	}
	else if (e) 
	{
		// alert('e');
		keycode = e.which;
	}
	
//	if(keycode==13)
	// alert("keycode: " + keycode);

/*	if(window.event.keyCode == 13)
	{
		alert('EnterThisFunction');
		eval(function_str);
	}
	
	return false;	// */
}

function AddAnother(frm)
{
	frm.add_mode.value = "Y";
	
	if(Validate(frm))
		frm.submit();
}

function DumpProperties(obj, parent) 
{
   for (var i in obj) // Go through all the properties of the passed-in object
   {
      // if a parent (2nd parameter) was passed in, then use that to
      // build the message. Message includes i (the object's property name)
      // then the object's property value on a new line
      if (parent) { var msg = parent + "." + i + "\n" + obj[i]; } else { var msg = i + "\n" + obj[i]; }
      // Display the message. If the user clicks "OK", then continue. If they
      // click "CANCEL" then quit this level of recursion
      if (!confirm(msg)) { return; }
      // If this property (i) is an object, then recursively process the object
//      if (typeof obj[i] == "object") {
 //        if (parent) { dumpProps(obj[i], parent + "." + i); } else { dumpProps(obj[i], i); }
  //    }
   }
}

function replaceString(oldS,newS,fullS)
{// Replaces oldS with newS in the string fullS  
	for (var i=0; i<fullS.length; i++)
		if (fullS.substring(i,i+oldS.length) == oldS) 
			fullS = fullS.substring(0,i)+newS+fullS.substring(i+oldS.length,fullS.length)  

	return fullS
}

function inArray(srch_txt, arr)
{	
	for(var i=arr.length-1; i>=0; i--)
		if(arr[i] == srch_txt)
			return true;
	
	return false;
}

function UploadContentPics()
{
	info="content_pics.php";
	window.open(info,"","menubars=0,width=500,height=550,scrollbars=1");
}

function F5()
{
	window.location.reload();
}

function ClearID(txt, id)
{
	if(str_trim(txt)=='')
		document.getElementById(id).value='0';
}

function ReplaceNewlines(str)
{
	return str.replace(new RegExp('\\n', 'g'), ',');
}
function InitCalendar(txt_id, btn_id, flag)
{
	if(!flag || flag==undefined)
		flag = 'D';
		
	if(flag=='DT')
	{
		format = '%d-%m-%Y %H:%M:00';
		showtime = 'true';
	}
	else
	{
		format = '%d-%m-%Y';
		showtime = 'false';
	}
		
	Calendar.setup({inputField: txt_id, ifFormat: format, showsTime: showtime, button: btn_id, singleClick: true, step: 2});
}

function MarkNow(td_id)
{
	if(document.getElementById(td_id))
	{
		var td_obj = document.getElementById(td_id);
		MarkRow(td_obj);
	}
}

function Preloader(div_id, type)
{
	// alert('type');
	if(!type || type==undefined)
		type = '';
	
	var div_obj = document.getElementById(div_id);
	if(div_obj)
		div_obj.innerHTML = '<div align="center"><img src="./images/preloader'+type+'.gif" alt="loading, please wait..."></div>';
	else
		alert('div not found');
}

/*function GeneratePass(temp,rand)
{
	var pattern = new Array('4321','3214','2143','1432','4231','2314','3142','1423','4123','1234','2341','3412','4132','1324','3241','2413');

	 var ranvar    = Math.round(Math.random() * 15);
	 var mypattern = pattern[ranvar];
	 
	 var temparr   = new Array();
	 
	 temparr[1] = temp.substr(0,8);
	 temparr[2] = temp.substr(8,8);
	 temparr[3] = temp.substr(16,8);
	 temparr[4] = temp.substr(24,8);
	 
	 passwordstr = rand+temparr[mypattern.substr(0,1)]+rand+temparr[mypattern.substr(1,1)]+rand+temparr[mypattern.substr(2,1)]+rand+temparr[mypattern.substr(3,1)]+mypattern;
	 
	 return passwordstr;
}*/
function JQueryNotify(text, type, sticky)
{
	if(type!='' && sticky)
		$.jnotify(text, type, sticky);
	else if(type!='')
		$.jnotify(text, type);
	else if(sticky)
		$.jnotify(text, sticky);
	else
		$.jnotify(text);
}

function RemoveRow(tr_id)
{
	var tr_obj = document.getElementById(tr_id);
	if(tr_obj) tr_obj.parentNode.removeChild(tr_obj);
}

function IsValueExceeded(val, ubound)
{
	val = parseFloat(val);	
	return (val > ubound)? true: false;
}

function CheckRealNum2(obj) // validates a form ctrl for a real number
{
	regExpr=new RegExp(/^-?\d*(\.\d*)?$/);
	var sign = 1;

	if(str_trim(obj.value)!="" && !isNaN(obj.value) && obj.value < 0)
	{
		sign = -1;
		obj.value *= sign;
	}

	if(str_trim(obj.value)=="" || !regExpr.test(obj.value) || isNaN(obj.value) || obj.value < 0)
		obj.value="0";

	obj.value *= sign;	
}

function SubmitForm(frm)
{
	if(Validate(frm))
		frm.submit();
}

function PFunc(action,frm,mode,prod_count)
{
	//alert('action='+action+' frm='+frm+' prod_count='+prod_count);
	
	if(action != '') 
		frm.action = action;

	if(mode != '')	
		frm.mode.value = mode;
		
	if(prod_count != '')
		frm.prod_count.value = prod_count;
		
	frm.submit();
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function CheckNumCart(obj) // validates a form ctrl for an integer
{
	regExpr = new RegExp(/^\d*$/);

	if(str_trim(obj.value)=="" || !regExpr.test(obj.value))
		obj.value="1";		
}