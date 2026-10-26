<?php

require_once('ti-salt.php');

function getconnected() 

{

	/*$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD)or die('COM.04');

	mysql_select_db(DB_NAME) or die('COM.05'); */	

  

	$CON = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD)or die("<strong>ERROR CODE : </strong> COM - 66");

	mysqli_select_db($CON, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67"); 

	

	return $CON;	

}



function get_rand_id($length)

{

	$rand_id="";

	

	if($length>0) 

	{ 

		for($i=1; $i<=$length; $i++)

		{

			mt_srand((double)microtime() * 1000000);

			$num = mt_rand(0,35);

			$rand_id .= assign_rand_value($num);

		}

	}

	

	return $rand_id;

} 



function assign_rand_value($num)

{

	$rand_value = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9");

	return $rand_value[$num];

}

	

function CheckSPAM($string)

{

	$len=strlen($string);



	for($i=0;$i<=$len;$i++)

	{

		$c=substr($string,$i,1);

		if( (ord($c)>=0 && ord($c)<=127) || ord($c)==156 ) {}

		else

			return false;

	}

	return true;

}

	

function Passwordify($password)

{

	$passarr = array();	

	$passarr[0] = substr($password,0,8);

	$passarr[1] = substr($password,8,8);

	$passarr[2] = substr($password,16,8);

	$passarr[3] = substr($password,24,8);

	$passarr[4] = substr($password,32,8);

	$passarr[5] = substr($password,40,8);

	$passarr[6] = substr($password,48,8);

	$passarr[7] = substr($password,56,8);

	$passarr[8] = substr($password,64,4);



	$ptrarr = array();

	$ptrarr[0] = substr($passarr[8],0,1);

	$ptrarr[1] = substr($passarr[8],1,1);

	$ptrarr[2] = substr($passarr[8],2,1);

	$ptrarr[3] = substr($passarr[8],3,1);

	

	$k=1;

	$genpass = array();

	foreach($ptrarr as $key=>$value)

	{

		$genpass[$value] = $passarr[$key+$k];

		$k=$k+1;

	}

				

	$password = $genpass[1].$genpass[2].$genpass[3].$genpass[4];

	

	return $password;

}



function db_input($string)

{

	$string = strip_tags($string);

    //$string = (!MAGIC_QUOTES)? addslashes($string): $string; //stripslashes($string);

    $string = addslashes($string);

	$string = htmlspecialchars($string);

	return $string;

}



function db_input2($string)

{

    //$string = (!MAGIC_QUOTES)? addslashes($string): $string; //stripslashes($string);	

    $string = addslashes($string);	

	return $string;

}

  

function db_input3($string) // textareas wt editors

{

    //$string = (!MAGIC_QUOTES)? addslashes($string): $string; //stripslashes($string);

    $string = addslashes($string);

	$string = htmlspecialchars($string);

	return $string;

}

  

function db_output($string) 

{

    return htmlspecialchars($string);

}



function ForceOut($err=false)

{

	$str = ($err===false)? '': '?err='.$err;

	session_destroy(); // destroy all data in session

	header("location:index.php".$str);

	exit;

}



function DFA($arr)

{

	echo '<pre>';

	print_r($arr);

	echo '</pre>';

}



function FormatDate($date_val, $flag="A")

{

	$dt="";

	$date_val = trim($date_val);



	if($date_val != "" && $date_val!='0000-00-00' && $date_val!="0000-00-00 00:00:00")

	{

		$time_val = strtotime($date_val);

		

		if($flag=="A")	$date_format = "d/M";

		elseif($flag=="B")	$date_format = "d/m/y H:i";

		elseif($flag=="C")	$date_format = "h:i A";

		elseif($flag=="D")	$date_format = "H:i";

		elseif($flag=="E")	$date_format = "d/m/y h:i a";

		elseif($flag=="F")	$date_format = "d/m/Y";

		elseif($flag=="G")	$date_format = "g:i A  d/m";

		elseif($flag=="H")	$date_format = "d F Y G:i:00";

		elseif($flag=="I")	$date_format = "M d, Y G:i:00";

		elseif($flag=="J")	$date_format = "d M Y";

		elseif($flag=="K")	$date_format = "Y-m-d";

		else $date_format = "d/m/y";



		$dt = date($date_format, $time_val);

	}



	return $dt;

}



function Greet($nm)

{

	$msg="";

	$T=date("H");

	

	if($T>24) $T=$T%24;

		

	if($T<12)	$msg = "Good Morning";

	else if($T<16)	$msg = "Good Afternoon";

	else	$msg = "Good Evening";



	return $msg . ' ' . ucwords($nm); //  . "!";

}



function check_inject_string_url($str)

{

	return (preg_match("/((SELECT)|(DELETE)|(INSERT)|(UPDATE)|(ALTER)|(CREATE)|(TABLE)|(DROP)|(UNION)|(-))+/i", $str)>0)? false: true;

}



function check_inject($sql_in) 

{

	return (strstr($sql_in,'/*') || strstr($sql_in,'--') || stristr($sql_in,'<script>') || stristr($sql_in,'</script>'))? true: false;

}





function GetEditImageString($url)

{

	$str = '<a href="'.$url.'">'.EDIT_IMG.'</a>';

	return $str;

}



function GetDeleteImageString($type, $url)

{

	$str = "<a href='#' onClick=\"return ConfirmDelete('$type', '$url')\">";

		$str .= DELETE_IMG."</a>";

	

	return $str;

}



function GetStatusImageString($mode, $status, $id, $ajax_flag=true)

{

	$str = "";

	if($ajax_flag)

	{

		if($status=="A") $str = "<span class='badge bg-success'><a href='#'class='text-success' onClick=\"ChangeStatus(this, '$mode','I','$id'); return false;\">" . ACTIVE_IMG . "</a></span>";

		else if($status=='P') $str = "<span class='badge bg-warning'><a href='#' onClick=\"ChangeStatus(this, '$mode','A','$id'); return false;\">" . PENDING_IMG . "</a></span>";

		else $str = "<span class='badge bg-danger'><a href='#' onClick=\"ChangeStatus(this, '$mode','A','$id'); return false;\">" . INACTIVE_IMG . "</a></span>";

	}

	else

	{

		if($status=="A") $str = ACTIVE_IMG;

		else if($status=='P') $str = PENDING_IMG;

		else $str = INACTIVE_IMG;

	}



	return $str;

}

function GetStatusImageString1($url, $status, $id, $ajax_flag='1', $title='')

{

	$str = "";



	if($ajax_flag)

	{

		if($status=="A") $str = '<a href="#" onClick="ChangeStatus1(\''.$url.'\',\'I\','.$id.'); return false;" title="'.$title.'">'.ACTIVE_IMG.'</a>';

		else if($status=='P') $str = '<a href="#" onClick="ChangeStatus1(\''.$url.'\',\'A\','.$id.'); return false;" title="'.$title.'">'.PENDING_IMG.'</a>';

		else $str = '<a href="#" onClick="ChangeStatus1(\''.$url.'\',\'A\','.$id.'); return false;" title="'.$title.'">'.INACTIVE_IMG.'</a>';

	}

	else

	{

		if($status=="A") $str = '<span title="'.$title.'">'.ACTIVE_IMG.'</span>';

		else if($status=='P') $str = '<span title="'.$title.'">'.PENDING_IMG.'</span>';

		else $str = '<span title="'.$title.'">'.INACTIVE_IMG.'</span>';

	}



	return $str;

}



function ConvertFromYMDtoDMY($ymd_date, $tmode = false)

{

	$year = $mnth = $days = $hour = $mins = $secs = 0;

	

	if(trim($ymd_date)=="") return $ymd_date;

	elseif($ymd_date == "0000-00-00 00:00:00" || $ymd_date == "0000-00-00") return "";

	

	if($tmode) // time also included

	{

		$t_arr = explode(' ', $ymd_date);

		if(count($t_arr) < 2) return "";

		

		$ymd_date = $t_arr[0];

		$time_str = $t_arr[1];

		

		$tm_arr = explode(':', $time_str);

		if(count($tm_arr) < 3) return "";

		

		$hour = $tm_arr[0];

		$mins = $tm_arr[1];

		$secs = $tm_arr[2];

	}



	$dt_arr = explode('-', $ymd_date);

	if(count($dt_arr) < 3) return "";



	$year = $dt_arr[0];

	$mnth = $dt_arr[1];

	$days = $dt_arr[2];

	

	if($tmode)

		$dmy_date = $days."-".$mnth."-".$year." ".$hour.":".$mins.":".$secs;

	else

		$dmy_date = $days."-".$mnth."-".$year;



	return $dmy_date;

}



function ConvertFromDMYToYMD($dmy_date, $tmode=false)

{

	$year = $mnth = $days = $hour = $mins = $secs = 0;



	if(trim($dmy_date) == "") return $dmy_date;

	elseif($dmy_date == "0000-00-00 00:00:00" || $dmy_date == "0000-00-00") return "";



	if($tmode) // time also included

	{

		$t_arr = explode(' ', $dmy_date);

		if(count($t_arr) < 2) return "";



		$dmy_date = $t_arr[0];

		$time_str = $t_arr[1];

		

		$tm_arr = explode(':', $time_str);

		if(count($tm_arr) < 3) return "";



		$hour = $tm_arr[0];

		$mins = $tm_arr[1];

		$secs = $tm_arr[2];

	}



	$dt_arr = explode('-', $dmy_date);

	if(count($dt_arr) < 3) return "";



	$days = $dt_arr[0];

	$mnth = $dt_arr[1];

	$year = $dt_arr[2];

	

	if($tmode)

		$ymd_date = $year."-".$mnth."-".$days." ".$hour.":".$mins.":".$secs;

	else

		$ymd_date = $year."-".$mnth."-".$days;



	return $ymd_date;

}





function FillCombo($selected, $ctr, $type, $comp, $values,  $fn="", $class="form-control", $combo_type="KEY_VALUE") 

{

	$display = ($type<>"COMBO")? "size=10": "";



	$str = "<select name='$ctr' id='$ctr' class='$class' $display $fn>"; //  



	if(($comp<>"y" )&&( $comp<>"Y") )

	{

		if($comp=='0')

			$str .= "<option value='0' selected> - select - </option>\n";

		elseif($comp=='1')

			$str .= "<option value='0' selected> - main category - </option>\n";

		elseif($comp=='2')

			$str .= "<option value='-1' selected> - Month - </option>\n";

		elseif($comp=='3')

			$str .= "<option value='00:00:00' selected> - hh:mm - </option>\n";

		else

			$str .= "<option value='0' selected> - select - </option>\n";

	}

	

	if($combo_type == "KEY_VALUE")

	{

		while ($var = current($values)) 

		{

			$key_val = key($values);

			$select_str = ($selected==$key_val)? "selected": "";

			$str .= "<option value='$key_val' $select_str> $var</option>";

			next($values);

		}

	}

	elseif($combo_type == "KEY_IS_VALUE")

	{

		foreach($values as $var)

		{

			$select_str = ($selected==$var)? "selected": "";

			$str .= "<option value='$var' $select_str> $var</option>";

		}

	}

	elseif($combo_type == "SPLIT_FOR_KEY_VALUE")

	{

		foreach($values as $var)

		{

			$v = explode("~", $var);

			$key = $v[0];

			$txt = $v[1];

			

			$select_str = ($selected==$key)? "selected": "";

			$str .= "<option value='$key' $select_str> $txt</option>";

		}

	}

	elseif($combo_type == "OPT_VALUE")

	{

		foreach($values as $C) 

		{			

			$var = $C['NAME'];

			$key_val = $C['ID'];

			$select_str = ($selected==$key_val)? "selected": "";

			

			if($C['LEVEL']==1)

				$str .= "<optgroup label='$var'></optgroup>";

			else

				$str .= "<option value='$key_val' $select_str> $var</option>";

		}

	}



	$str .= "</select>";

	return $str;

}



function FillData($selected, $ctr, $tp, $comp, $flds, $tbl, $cond, $ord, $fn="", $class="inputbox")

{	

	$display = ($tp=="COMBO" || $tp=="COMBO2")? "": "size=10";

	$cond = (strtoupper(trim($cond)) != 'N' && trim($cond)!='')? " where " . $cond: "";	

	$class_str = (trim($class)=="")? "box": $class;



	$stat_fld = ($tp == "COMBO")? ", 'A' ": ", cStatus";

	

	$q = "select " . $flds . $stat_fld . " from " . $tbl . $cond . " order by " . $ord;

	$result = sql_query($q, 'COM56'); 

	//echo $q;

	$str ="<select name='$ctr' id='$ctr' class='$class_str' $display $fn>\n"; //



	if($comp<>'y'&&$comp<>'Y') 

	{

		if($comp=='0')

			$str .= "<option value='0' selected> - select - </option>\n";

		else if($comp=='-1')

			$str .= "<option value='-1' selected> - select - </option>\n";

		else

			$str .= "<option value='0' selected> - select - </option>\n";

	}



	while(list($id,$nm,$stat)=sql_fetch_row($result))

	{

		$stat_style = ($stat=="A" && $tp=="COMBO2")? "": " style='background-color: #FFC5C5;'";

		$selected_str = (trim($selected) == trim($id))? "selected": "";

		$str .=  "<option value='$id' $selected_str>$nm</option>\n";

	}



	$str .= "</select>\n";

	return $str;

}



function FillPriceRange($selected, $ctr,$class="inputbox")

{	

	$class_str = (trim($class)=="")? "box": $class;

	$q = "select iPRID,iFrom,iTo from gen_price_range where cStatus='A' and CFlag='A' order by iFrom";

	$result = sql_query($q, 'COM56'); 

	$count  = sql_num_rows($result);

	$i= 1;

	

	$str ="<select name='$ctr' id='$ctr' class='$class_str' >\n"; //

    $str .= "<option value='0' selected> - select - </option>\n";

		

	while(list($id,$from,$to)=sql_fetch_row($result))

	{

		//$stat_style = ($stat=="A" && $tp=="COMBO2")? "": " style='background-color: #FFC5C5;'";

		$selected_str = (trim($selected) == trim($id))? "selected": "";

		if($i!=$count)

		{

			$str .=  "<option value='$id' $selected_str>Rs.".$from."-Rs.".$to."</option>\n";

		}

		else

		{

			$str .=  "<option value='$id' $selected_str>Above&nbsp;Rs.".$from."</option>\n";

		}

		$i++;

	}



	$str .= "</select>\n";

	return $str;

}





function IsExistFile($file, $path)

{

	$file = trim($file);

	$path = trim($path);

	

	if( ($file != "") && (strtoupper($file) != "NA") )

	{

		$f = $path . $file;



		if(file_exists($f))

			return 1;

	}



	return 0;

}



function DeleteFile($file, $path)

{

	$file = trim($file);

	$path = trim($path);

	

	if( ($file != "") && (strtoupper($file) != "NA"))

	{

		$f = $path . $file;

		if(file_exists($f))

			unlink ($f);

	}

}



function NormalizeFilename($filename, $newname="")

{

	$filename = trim($filename);

	$pos = strrpos($filename, ".");

	

	$str_nm = (trim($newname!=""))? $newname: substr($filename,0,$pos);

	$str_ext = substr($filename,$pos);

	

	$invalid_chars=array('`','=',' ','\\','[',']',';','\'',',','/','~','!','@','#','$','%','^','&','*','(',')','|','{','}',':','\"','<','>','?');



	foreach($invalid_chars as $I)

		$str_nm = str_replace($I, "_", $str_nm);



	$str_nm .= $str_ext;

	return $str_nm;

}



function GetFileType($mystring)

{

	$pos = strrpos($mystring, ".");

		

	if($pos === false)

		$typ = "";

	else

		$typ = substr($mystring,$pos); 

	

	return $typ;

}



####	SQL FUNCTIONS	######################################################################################################

function ExecQuery($q, $err_code='ERR')

{

	/*$err_str = 'Error Code: '.$err_code;

	if(SQL_ERROR)

		$err_str .= '<br>query: '.$q.' <br>error: '.sql_error();

	

	if(check_inject($q))

	{

		echo '<div class="err">Fatal Error: SQL Injection Attempt Detected, Script Terminated.</div>

				<br><br>

				<a href="#" onclick="history.back(1);return false;">Click here to go back.</a>';

		exit;

	}*/

	

	$r = sql_query($q,$err_code);

	return $r;

}



function NextID($f,$tbl)

{

	$query = "SELECT max($f) FROM $tbl";

	check_inject($query); 				//Check for Sql Injection

	$result = sql_query($query)or die("<strong>ERROR CODE : </strong> COM - 154"); 

	list($rid)=sql_fetch_row($result);

	

	if(!is_numeric( $rid))

		$rid=0;		

	$rid++;

	return $rid;			

}



function GetXFromYID($q)

{

	$x = false;

	

	check_inject($q); 		//Check for Sql Injection	

	$r = sql_query($q, 'GNC.181');

	if(sql_num_rows($r))

		list($x)=sql_fetch_row($r);

	

	return $x;

}	



function GetXArrFromYID($q, $mode="1")

{

	$arr = array();

	$r = sql_query($q, 'COM.191');

	

	if(sql_num_rows($r))

	{

		if($mode == "2")

			for($i=0; list($x) = sql_fetch_row($r); $i++)

				$arr[$i] = $x;

		else if($mode == "3")

			for($i=0; list($x, $y) = sql_fetch_row($r); $i++)

				$arr[$x] = $y;

		else

			while(list($x) = sql_fetch_row($r))

				$arr[$x] = $x;

	}



	return $arr;

}







function LogAttempt($user_name, $log_type, $fail_str)

{

	$now = NOW;

	$hostaddress = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	$log_str = ($log_type=='S')? 'Login Successful': 'Login Failed';

	

	$q = "insert into logreport values('$user_name','$now','$hostaddress', '".session_id()."', '$log_str', '$fail_str','$log_type')";

	$r = sql_query($q, 'GNC.216');

}



function FillArray($selected, $ctr, $type, $comp, $values, $fn="", $class="inputbox", $combo_type="KEY_VALUE")

{

	$display = ($type<>"COMBO")? "size=10": "";



	$str = "<select name=$ctr id='$ctr' class='$class' $display $fn>"; //  



	if(($comp<>"y" )&&( $comp<>"Y") )

	{

		if($comp=='0')

			$str .= "<option value='0' selected> - select - </option>";

		elseif($comp == '1')

			$str .= "<option value='0' selected> - select one - </option>";

		elseif($comp == '2')

			$str .= "<option value='0' selected> - show all - </option>";

		elseif($comp == '3')

			$str .= "<option value='0' selected> TIME </option>";

		else

			$str .= "<option value='0' selected> - select one - </option>";

	}

	

	if($combo_type == "KEY_VALUE")

	{

		while ($var = current($values)) 

		{

			$key_val = key($values);

			$select_str = ($selected==$key_val)? "selected": "";

			$str .= "<option value='$key_val' $select_str> $var</option>";

			next($values);

		}

	}

	elseif($combo_type == "KEY_IS_VALUE")

	{

		foreach($values as $var)

		{

			$select_str = ($selected==$var)? "selected": "";

			$str .= "<option value='$var' $select_str> $var</option>";

		}

	}

	elseif($combo_type == "SPLIT_FOR_KEY_VALUE")

	{

		foreach($values as $var)

		{

			$v = explode("~", $var);

			$key = $v[0];

			$txt = $v[1];

			

			$select_str = ($selected==$key)? "selected": "";

			$str .= "<option value='$key' $select_str> $txt</option>";

		}

	}



	$str .= "</select>";

	return $str;

}





function FormatNumber($number, $pad_len=0, $mode='ind') // int: international; ind: indian

{

	$sign = ($number < 0)? '-': '';

	$number = abs($number);

	

	if($mode == 'ind')

		$number = exp_to_dec($number);



	$dot = 	strrpos($number, ".");

	$int_buffer = array();



	if($dot===false)

	{

		$int_part  = $number;

		$deci_part = "";

	}

	else

	{

		$int_part = substr($number, 0, $dot);

		$deci_part = substr($number, $dot+1);

	}

	

	// echo '['.$mode . ' ' .$int_part.' . '.$deci_part.']<br>';



	if($pad_len > 0)

	{

		if($deci_part!='')

		{

			$deci_part_str = round('0.'.$deci_part, $pad_len);



			if($deci_part_str >= 1) // decimals have rounded up to 1 => increment integer part...

				$int_part++;

				

			$deci_part = substr($deci_part_str, 2);// , $dot+1);

		}

	}



	if($mode=='ind')

	{

		$len = strlen($int_part);

		for($i=$len-1; $i >= 0; $i--)

			$int_buffer[$i] = substr($int_part, $i, 1);

		

		$i=0;

		$int_part = "";

		foreach($int_buffer as $digit)

		{		

			$int_part = ( ($i==3) || ($i==5) || ($i==7) || ($i==9) ) ? $digit . "," . $int_part: $int_part = $digit . $int_part;			

			$i++;

		}

	}

	else if($mode == 'int')

	{

		$int_part = number_format($int_part);

	}



	$number = $int_part;

	

	if($pad_len > 0)

		$number .=  "." . str_pad($deci_part, $pad_len, "0");



	return $sign . $number;		

}



// formats a floating point number string in decimal notation, supports signed floats, also supports non-standard formatting e.g. 0.2e+2 for 20

// e.g. '1.6E+6' to '1600000', '-4.566e-12' to '-0.000000000004566', '+34e+10' to '340000000000'

// Author: Bob

function exp_to_dec($float_str)

{

    // make sure its a standard php float string (i.e. change 0.2e+2 to 20)

    // php will automatically format floats decimally if they are within a certain range

    $float_str = (string)((float)($float_str));



    // if there is an E in the float string

    if(($pos = strpos(strtolower($float_str), 'e')) !== false)

    {

        // get either side of the E, e.g. 1.6E+6 => exp E+6, num 1.6

        $exp = substr($float_str, $pos+1);

        $num = substr($float_str, 0, $pos);

       

        // strip off num sign, if there is one, and leave it off if its + (not required)

        if((($num_sign = $num[0]) === '+') || ($num_sign === '-')) $num = substr($num, 1);

        else $num_sign = '';

        if($num_sign === '+') $num_sign = '';

       

        // strip off exponential sign ('+' or '-' as in 'E+6') if there is one, otherwise throw error, e.g. E+6 => '+'

        if((($exp_sign = $exp[0]) === '+') || ($exp_sign === '-')) $exp = substr($exp, 1);

        else trigger_error("Could not convert exponential notation to decimal notation: invalid float string '$float_str'", E_USER_ERROR);

       

        // get the number of decimal places to the right of the decimal point (or 0 if there is no dec point), e.g., 1.6 => 1

        $right_dec_places = (($dec_pos = strpos($num, '.')) === false) ? 0 : strlen(substr($num, $dec_pos+1));

        // get the number of decimal places to the left of the decimal point (or the length of the entire num if there is no dec point), e.g. 1.6 => 1

        $left_dec_places = ($dec_pos === false) ? strlen($num) : strlen(substr($num, 0, $dec_pos));

       

        // work out number of zeros from exp, exp sign and dec places, e.g. exp 6, exp sign +, dec places 1 => num zeros 5

        if($exp_sign === '+') $num_zeros = $exp - $right_dec_places;

        else $num_zeros = $exp - $left_dec_places;

       

        // build a string with $num_zeros zeros, e.g. '0' 5 times => '00000'

        $zeros = str_pad('', $num_zeros, '0');

       

        // strip decimal from num, e.g. 1.6 => 16

        if($dec_pos !== false) $num = str_replace('.', '', $num);

       

        // if positive exponent, return like 1600000

        if($exp_sign === '+') return $num_sign.$num.$zeros;

        // if negative exponent, return like 0.0000016

        else return $num_sign.'0.'.$zeros.$num;

    }

    // otherwise, assume already in decimal notation and return

    else return $float_str;

}

$mode = (isset($_GET['mode']))?$_GET['mode']:'';

if($mode=='GetPass')

{

	$pass = $_GET['pass'];

	

	$salt_obj= new SaltIT;

	$passwd= $salt_obj->Encode($pass);

	

	echo $passwd;

	exit;

}

function GenerateMenu($MENU_ARR, $_file_name)

{

	$str = '';

	foreach($MENU_ARR as $MNU_KEY=>$MNU)

	{

		$mnu_text = $MNU['TEXT'];

		$mnu_file = $MNU['FILE'];

		$mnu_img = (isset($MNU['IMG']))? $MNU['IMG']: '';

		$mnu_urls = (isset($MNU['URLS']))? $MNU['URLS']: '';

		

		$sub_mnu_arr = (isset($MNU['SUB_MENU']))? $MNU['SUB_MENU']: false;

	

		$mnu_active_css = (is_array($mnu_urls) && in_array($_file_name, $mnu_urls))? 'active': '';

		if(is_array($sub_mnu_arr)){ $aroIcon = '<i class="right fas fa-angle-left"></i>';} else { $aroIcon = " ";}

		//$str .= '<li class="'.$mnu_active_css.' iconed"> <a href="'.$mnu_file.'"><span>'.$mnu_img.' '.$mnu_text.'</span></a>';
		$str .= '<li class="nav-item">
            <a href="'.$mnu_file.'" class="nav-link '.$mnu_active_css.'">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>
                '.$mnu_text.' '.$aroIcon.'
              </p>
            </a>';



		if(is_array($sub_mnu_arr))

		{

			$str .= '  <ul class="nav nav-treeview">'.NEWLINE;



			foreach($sub_mnu_arr as $SUB_MNU_KEY=>$SUB_MNU)

			{

				$sub_mnu_file = $SUB_MNU[0];

				// $str .= '    <li class="nav-item"><a href="'.$sub_mnu_file.'"><span>'.$SUB_MNU_KEY.'</span></a>';
                $str .= '    <li class="nav-item"><a href="'.$sub_mnu_file.'"  class="nav-link"><i class="far fa-circle nav-icon"></i><p>'.$SUB_MNU_KEY.'</p></a>';
                


				if(is_array($SUB_MNU))

				{

					$sub_str = '';

					

					foreach($SUB_MNU as $PAGE_KEY=>$PAGES)

					{

						if(is_numeric($PAGE_KEY))

							continue;



						$sub_str .= '       <li><a href="'.$PAGES[0].'">'.$PAGE_KEY.'</a></li>'.NEWLINE;

					}

					

					if($sub_str!='')

						$str .= '      <ul>'.$sub_str.'</ul>'.NEWLINE;

				}

				

				$str .= '</li>'.NEWLINE;

			}

			$str .= '  </ul>'.NEWLINE;

		}



		$str .= '</li>'.NEWLINE;

	}

	

	return $str;

}



function GetAddImageString($url, $title='add new')

{

	$str = '<div style="float:right;"><a href="'.$url.'" title="'.$title.'" class="btn btn-outline-primary btn-block"> '.ADD_RECORD_IMG.'</a></div>';

	return $str;

}

function EnsureValidMode($mode, $valid_modes, $default_mode)

{

	if(empty($mode) || !in_array($mode, $valid_modes))

		$mode = $default_mode;

		

	return $mode;

}



function SearchFromMemory($flag, $disp_url)

{

	global $_SESSION;

	$url_str = $disp_url;

	

	if(isset($_SESSION[PROJ_SESSION_ID]->srch_ctrl_arr[$flag]))

	{

		$srch_ctrl_arr = $_SESSION[PROJ_SESSION_ID]->srch_ctrl_arr[$flag];

		$url_str = $disp_url."?srch_mode=QUERY";

			

		foreach($srch_ctrl_arr as $ctrl_nm=>$ctrl_val)

		{

			if($ctrl_nm == "srch_mode" || $ctrl_nm == "FORM")

				continue;

		

			$url_str .= "&" . $ctrl_nm . "=" . $ctrl_val;

		}

	}



	header("location: " . $url_str);

	exit;

}

function GetFeaturedImageString($mode, $status, $id, $ajax_flag=true)

{

	$str = "";

	if($ajax_flag)

	{

		if($status=="Y") $str = "<a href='#' onClick=\"ChangeFeatured(this, '$mode','N','$id'); return false;\" >" . FEATURED_IMG . "</a>";

		else $str = "<a href='#' onClick=\"ChangeFeatured(this, '$mode','Y','$id'); return false;\">" . UNFEATURED_IMG . "</a>";

	}

	else

	{

		if($status=="A") $str = FEATURED_IMG;

		else $str = UNFEATURED_IMG;

	}



	return $str;

}

function GetFeaturedImageString2($mode, $status, $id, $ajax_flag=true)

{

	$str = "";

	if($ajax_flag)

	{

		if($status=="Y") $str = "<a href='#' class='text-success' onClick=\"ChangeFeatured2(this, '$mode','N','$id'); return false;\">" . DEFAULT_YES . "</a>";

		else $str = "<a href='#' class='text-danger' onClick=\"ChangeFeatured2(this, '$mode','Y','$id'); return false;\">" . DEFAULT_NO . "</a>";

	}

	else

	{

		if($status=="A") $str = DEFAULT_YES;

		else $str = DEFAULT_NO;

	}



	return $str;

}

function GetUrlName($title)

{

	$URL_CHAR_ARR = array("%","/",".","#","?","*","!","@","&",":","|",";","=","<",">","^","~","'","\"",",","-","(",")","'",'"','\\');

	$rurl = trim($title);

	$rurl = str_replace($URL_CHAR_ARR,'',$title);

	$rurl = str_replace('   ',' ',$rurl);

	$rurl = str_replace('  ',' ',$rurl);

	//$rurl = trim(strtolower($rurl));

	$rurl = str_replace(' ','-',$rurl);

	

	//if(strlen($rurl) > 250)

		//$rurl = substr($rurl, 0, 250);



	return $rurl;

}

function CHK_ARR2Str($chk_arr)

{

	$str = '';

	

	if(count($chk_arr))

	{

		foreach($chk_arr as $x_str=>$x_count)

			$str .= ', '.$x_str;

		

		$str = substr($str, 2);

	}

	

	return $str;

}

function GetUrlModel($title)

{

	$URL_CHAR_ARR = array("%","/",".","#","?","*","!","@","&",":","|",";","=","<",">","^","~","'","\"",",");

	$rurl = trim($title);

	$rurl = str_replace($URL_CHAR_ARR,'',$title);

	$rurl = str_replace('   ',' ',$rurl);

	$rurl = str_replace('  ',' ',$rurl);

	//$rurl = trim(strtolower($rurl));

	$rurl = str_replace(' ','-',$rurl);

	

	//if(strlen($rurl) > 250)

		//$rurl = substr($rurl, 0, 250);



	return $rurl;

}

function GetAttribDatName()

{

	$arr=array();

	$q="select iAttribDatID,vName from prodcat_attrib_dat";

	//echo $q;

	$r = sql_query($q) or die("<strong>Error Code: COM1802</strong>");

	while(list($iattribdatid,$attribdatname) = sql_fetch_row($r))

	$arr[$iattribdatid]=$attribdatname;

	return $arr;

}



function GetURL($pc_id,$p_id,$n_id,$type)

{

	$str = '';



	if($type!=='F')

	{

    	if($pc_id!='' && $pc_id!=0)

    		$pc_title = rtrim(GetXfromYID('select vUrlName from prodcat where iPCatID='.$pc_id), " ");

    	else

    		$pc_title = '';

    

    	if($p_id!='' && $p_id!=0)

    		$p_title = rtrim(GetXfromYID('select vUrlName from product where iProdID='.$p_id), " ");

    	else

    		$p_title = '';

    

    	if($n_id!='' && $n_id!=0)

    		$n_title = rtrim(GetXfromYID('select vUrlName from news where iNewsID='.$n_id), " ");

    	else

    		$n_title = '';

	}

	else

	{

		if($pc_id!='' && $pc_id!=0)

			$pc_title = rtrim(GetXfromYID('select vUrlName from flash where iFID='.$pc_id), " ");

		else

			$pc_title = '';

	}



	if($type=='PC')

		$str = SITE_ADDRESS.'category/'.$pc_title.'.html';

	elseif($type=='P')

		$str = SITE_ADDRESS.$pc_title.'/'.$p_title.'.html';

	elseif($type=='N')

		$str = SITE_ADDRESS.'news/'.$n_title.'.html';

	elseif($type=='F')

		$str = SITE_ADDRESS.'flash-sale/'.$pc_title.'.html';



	return $str;

}

function GetLatestCaraousel()

{

	$str = '';

	

	$priceARR = array();

	$pSTR = GetIDString('select iProdID from product where cStatus="A" and cLatest="Y"');

	if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



	//$q = 'select * from product where cStatus="A" and cLatest="Y"';

	$q = 'select iProdID, vName, fOPrice, fPrice, vSmallImage, vImage, iStockQty, iSold, iResaleQty, cSoldOut, iPCatID from product where cStatus="A" and cLatest="Y"';

	$r = sql_query($q, 'GGCC.963');

	$record_count = sql_num_rows($r);

	

	if($record_count)

	{

		$str .= '<div class="row-latest">';

		$str .= '<div class="well no-border">';

		$str .= '<h2 class="pull-left style">Latest</h2>';

		$str .= '</div>';

		$str .= '<div id="demo">';

		

		$str .= '<div id="owl-demo" class="owl-carousel">';

		for($i=1;$o=sql_fetch_object($r);$i++)

		{

			$p_id = $o->iProdID;

			$p_name = $o->vName;

			$p_offerprice = FormatNumber($o->fOPrice,'0','ind');

			$p_price = FormatNumber($o->fPrice,'0','ind');

			$p_smallpic = $o->vSmallImage;

			$p_pic = $o->vImage;

			$prod_stockqty = $o->iStockQty;

			$prod_sold = $o->iSold;

			$prod_resaleqty = $o->iResaleQty;

			$prod_soldout = $o->cSoldOut;

			$cat_id = $o->iPCatID;



			if(URL_REWRITTING=='ON')

				$URL_P = GetURL($cat_id,$p_id,'0','P');

			else

				$URL_P = SITE_ADDRESS.'details.php?prod_id='.$p_id;



			$str .= '<div class="new"><a href="'.$URL_P.'">';

			if(IsExistFile('sml_'.$p_smallpic,PRODUCT_UPLOAD))

				$str .= '<div class="new-img"><img src="'.PRODUCT_PATH.'sml_'.$p_smallpic.'" alt="'.$p_name.'"></div>';

			$str .= '</a> <a href="'.$URL_P.'">';

			$str .= '<h2>'.$p_name.'</h2>';

			$str .= '</a>';

			$str .= '<p class="strike-sold">';

			$chkidsearch = GetXArrFromYID('select iPCatID from prodcat where iParentID=4');

			

			if($cat_id==4 || in_array($cat_id,$chkidsearch))

			{

				if($prod_sold>=$prod_stockqty)

				{

					$str .= 'Sold Out '.$prod_stockqty.'/'.$prod_stockqty.'';

				

					if($prod_resaleqty!='' && $prod_resaleqty!='0')

					{

						$str .= ', '.$prod_resaleqty.' on Resale,<br/>';   //.$prod_stockqty.'/'.$prod_stockqty.'

						$str .= 'Sold '.($prod_sold-$prod_stockqty).' of '.$prod_resaleqty;

					}	

				}

				else

					$str .= 'Sold '.$prod_sold.' of '.$prod_stockqty;

			}

			$str .= '</p>';

			if($prod_soldout=='Y')

			$str .= '<img src="'.SITE_ADDRESS.'images/sold-red.png">';

			$str .= '<a href="'.$URL_P.'">';

			$str .= '<h2 class="red">';

			

			if(isset($priceARR[$p_id]) && !empty($priceARR[$p_id]))

			{

				$p_offerprice = $priceARR[$p_id]['SALE_PRICE'];

				$p_price = $priceARR[$p_id]['ACTUAL_PRICE'];

			}



			if(!empty($p_offerprice))

			{

				$str .= '<span class="mario">Rs '.$p_price.'</span>';

				$str .= '<span class="red-1">Rs '.$p_offerprice.'</span>';

			}

			else

				$str .= '<span class="red-1">Rs '.$p_price.'</span>';

			$str .= '</h2>';

			$str .= '</a> <a href="'.$URL_P.'">';

			$str .= '<h3>View details</h3>';

			$str .= '</a> </div>';

		}

		

		$str .= '</div>';

		$str .= '</div>';

		$str .= '</div>';

	}

		

	return $str;

}

function GetFeaturedCategoryCaraousel()

{

	$str = '';

	$FEATCAT_ARR = GetXArrFromYID('select iPCatID, vName from prodcat where cFeatured="Y" and cStatus="A" order by iFeaturedRank','3'); 



	$priceARR = array();

	$pSTR = GetIDString('select p.iProdID from product as p join prodcat as p2 on p.iPCatID=p2.iPCatID where p.cStatus="A" and p2.cStatus="A" and p.cFeatured="Y" and p2.cFeatured="Y"');

	if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);

	

	$k = 1;

	foreach($FEATCAT_ARR as $cat_id=>$cat_name)

	{

		$q = 'select * from product where iPCatID='.$cat_id.' and cStatus="A" and cFeatured="Y"';

		$r = sql_query($q, 'GGCC.963');

		$record_count = sql_num_rows($r);

		

		if($record_count)

		{

			if(URL_REWRITTING=='ON')

				$URL_PC = GetURL($cat_id,'0','0','PC');

			else

				$URL_PC = SITE_ADDRESS.'listing.php?cat_id='.$cat_id;



			$str .= '<div class="row-latest">';

			$str .= '<div class="well no-border">';

			$str .= '<h2 class="pull-left style">'.$cat_name.'</h2>';

			$str .= '<a href="'.$URL_PC.'">';

			$str .= '<p class="pull-right style1">view all</p>';

			$str .= '</a></div>';

			$str .= '<div id="demo">';

			

			$str .= '<div id="owl-demo-'.$k.'" class="owl-carousel">';

			for($i=1;$o=sql_fetch_object($r);$i++)

			{

				$p_id = $o->iProdID;

				$p_name = $o->vName;

				$p_offerprice = FormatNumber($o->fOPrice,'0','ind');

				$p_price = FormatNumber($o->fPrice,'0','ind');

				$p_smallpic = $o->vSmallImage;

				$p_pic = $o->vImage;

				$prod_stockqty = $o->iStockQty;

				$prod_sold = $o->iSold;

				$prod_resaleqty = $o->iResaleQty;

				$prod_soldout = $o->cSoldOut;



				if(URL_REWRITTING=='ON')

					$URL_P = GetURL($cat_id,$p_id,'0','P');

				else

					$URL_P = SITE_ADDRESS.'details.php?prod_id='.$p_id;



				$str .= '<div class="new"><a href="'.$URL_P.'">';

				if(IsExistFile('sml_'.$p_smallpic,PRODUCT_UPLOAD))

					$str .= '<div class="new-img"><img src="'.PRODUCT_PATH.'sml_'.$p_smallpic.'" alt="'.$p_name.'"></div>';

				$str .= '</a> <a href="'.$URL_P.'">';

				$str .= '<h2>'.$p_name.'</h2>';

				$str .= '</a>';

				$str .= '<p class="strike-sold">';

				$chkidsearch = GetXArrFromYID('select iPCatID from prodcat where iParentID=4');

				

				if($cat_id==4 || in_array($cat_id,$chkidsearch))

				{

					if($prod_sold>=$prod_stockqty)

					{

						$str .= 'Sold Out '.$prod_stockqty.'/'.$prod_stockqty.'';

					

						if($prod_resaleqty!='' && $prod_resaleqty!='0')

						{

							$str .= ', '.$prod_resaleqty.' on Resale,<br/>';   //.$prod_stockqty.'/'.$prod_stockqty.'

							$str .= 'Sold '.($prod_sold-$prod_stockqty).' of '.$prod_resaleqty;

						}	

					}

					else

						$str .= 'Sold '.$prod_sold.' of '.$prod_stockqty;

				}

				$str .= '</p>';

				if($prod_soldout=='Y')

				$str .= '<img src="'.SITE_ADDRESS.'images/sold-red.png">';

				$str .= '<a href="'.$URL_P.'">';

				$str .= '<h2 class="red">';



				if(isset($priceARR[$p_id]) && !empty($priceARR[$p_id]))

				{

					$p_offerprice = $priceARR[$p_id]['SALE_PRICE'];

					$p_price = $priceARR[$p_id]['ACTUAL_PRICE'];

				}

	

				if(!empty($p_offerprice))

				{

					$str .= '<span class="mario">Rs '.$p_price.'</span>';

					$str .= '<span class="red-1">Rs '.$p_offerprice.'</span>';

				}

				else

					$str .= '<span class="red-1">Rs '.$p_price.'</span>';

				$str .= '</h2>';

				$str .= '<div class="clear"></div>';

				$str .= '</a> <a href="'.$URL_P.'">';

				$str .= '<h3>View details</h3>';

				$str .= '</a></div>';

			}

			

			$str .= '</div>';

			$str .= '</div>';

			$str .= '</div>';

		}

		$k++;

	}

		

	return $str;

}

function SetupCalendar($date_val, $txt_ctrl, $date_type='D', $clr_flag=true, $txt_flag=false)

{

	$btn_ctrl = 'btn'.substr($txt_ctrl, 3);

	$clr_ctrl = 'clr'.substr($txt_ctrl, 3);

	

	if($txt_flag)

	{

		$btn_ctrl = $txt_ctrl;

	}

	

	

	if($date_type=='DT') // datetime...

	{

		$format = '%d-%m-%Y %H:%M:00';

		$showtime = 'true';

		$css = 'datetime';

	}

	else

	{

		$format = '%d-%m-%Y';

		$showtime = 'false';

		$css = 'date';

	}

	

	$str = '';	

	$str .= '<input type="text" name="'.$txt_ctrl.'" id="'.$txt_ctrl.'" value="'.$date_val.'" class="date" readonly>';

	

	if(!$txt_flag)

		$str .= '<input name="'.$btn_ctrl.'" type="button" id="'.$btn_ctrl.'" value="..." class="date">';

	

	$str .= '<script type="text/javascript">';

	$str .= 'Calendar.setup({inputField:"'.$txt_ctrl.'",ifFormat:"'.$format.'",showsTime:'.$showtime.',button:"'.$btn_ctrl.'",singleClick:true,step:2});';

	$str .= '</script>';

	

	if($clr_flag && !$txt_flag)

		$str .= '<input type="button" name="'.$clr_ctrl.'" id="'.$clr_ctrl.'" value="!" class="date" onClick="this.form.'.$txt_ctrl.'.value=\'\';">';



	return $str;

}

function GetDateFormat($date)

{

	$str = '';

	

	$new_date = explode('-',$date);

	

	$day = $new_date[2];

	$month = $new_date[1];

	$year = $new_date[0];



	$str = $day.'&nbsp;'.date('M',strtotime($date)).'&nbsp;'.$year; //Date('w',strtotime($txtdate[0]))

	

	return $str;

}

function GetFeaturedNewsEvents()

{

	$str = '';

	

	$q = 'select iNewsID, vTitle, dtPosted from news where cStatus="A" and cFeatured="Y" order by iFeaturedRank';

	$r = sql_query($q, 'GFNE.1055');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$str .= '<div class="white-box">';

		$str .= '<h2>NEWS &amp; EVENTS</h2>';



		while(list($n_id, $n_title, $n_posted) = sql_fetch_row($r))

		{

			$nposted = explode(' ',$n_posted);

			$posted_date = GetDateFormat($nposted[0]);



			if(URL_REWRITTING=='ON')

				$URL_N = GetURL('0','0',$n_id,'N');

			else

				$URL_N = SITE_ADDRESS.'news_details.php?id='.$n_id;



			$str .= '<p><b>'.$posted_date.'</b><br>';

			$str .= $n_title.'&nbsp;<a href="'.$URL_N.'">Read More</a></p>';

			$str .= '<div class="news-sep last"></div>';

		}

		

		$str .= '<a href="'.SITE_ADDRESS.'news.php" class="news">View all events &#9658;</a>';

		$str .= '</div>';

		$str .= '<div class="spacer30"></div>';

	}



	return $str;

}

function GetSEO($title,$keywords,$desc)

{

	$str = $SEO_Title = $SEO_Keyword = $SEO_Desc = '';



	$q_s = 'select vSEOTitle, vSEOKeywords, vSEODesc from seo_settings';

	$r_s = sql_query($q_s,'GS.1115');

	list($seotitle,$seokeywords,$seodesc) = sql_fetch_row($r_s);

	

	$SEO_Title = ($title!='')?$title:$seotitle;

	$SEO_Keyword = ($keywords!='')?$keywords:$seokeywords;

	$SEO_Desc =  ($desc!='')?$desc:$seodesc;



	$str .= '<title>'.htmlspecialchars_decode($SEO_Title).'</title>';

	$str .= '<meta name="keywords" content="'.htmlspecialchars_decode($SEO_Keyword).'">';

	$str .= '<meta name="description" content="'.htmlspecialchars_decode($SEO_Desc).'">';



	return $str;	

}

function GetBookCategoryCaraousel($cat_id,$p_id)

{

	$str = '';

	$cat_name = strtoupper(GetXFromYID('select vName from prodcat where iPCatID='.$cat_id));



	$priceARR = array();

	$pSTR = GetIDString('select iProdID from product where iPCatID='.$cat_id.' and iProdID!='.$p_id.' and cStatus="A" and cFeatured="Y"');

	if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



	//$q = 'select * from product where iPCatID='.$cat_id.' and iProdID!='.$p_id.' and cStatus="A" and cFeatured="Y"';

	$q = 'select iProdID, vName, fOPrice, fPrice, vSmallImage, vImage, iStockQty, iSold, iResaleQty, cSoldOut from product where iPCatID='.$cat_id.' and iProdID!='.$p_id.' and cStatus="A" and cFeatured="Y"';

	$r = sql_query($q, 'GGCC.963');

	$record_count = sql_num_rows($r);

	

	$k = 1;

	if($record_count)

	{

		$str .= '<div class="row-latest">';

		$str .= '<div class="well no-border">';

		$str .= '<h2 class="pull-left style">also see</h2>';

		$str .= '<a href="'.SITE_ADDRESS.'listing.php?cat_id='.$cat_id.'">';

		$str .= '<p class="pull-right style1">view all</p>';

		$str .= '</a></div>';

		$str .= '<div id="demo">';

		$str .= '<div id="owl-demo-2" class="owl-carousel">';

		

		for($i=1;$o=sql_fetch_object($r);$i++)

		{

			$p_id = $o->iProdID;

			$p_name = $o->vName;

			$p_offerprice = $o->fOPrice;

			$p_price = $o->fPrice;

			$p_smallpic = $o->vSmallImage;

			$p_pic = $o->vImage;

			$prod_stockqty = $o->iStockQty;

			$prod_sold = $o->iSold;

			$prod_resaleqty = $o->iResaleQty;

			$prod_soldout = $o->cSoldOut;

			

			if(URL_REWRITTING=='ON')

				$URL_BP = GetURL($cat_id,$p_id,'0','P');

			else

				$URL_BP = SITE_ADDRESS.'details.php?prod_id='.$p_id;



			$str .= '<div class="new"> <a href="'.$URL_BP.'">';

			if(IsExistFile('sml_'.$p_smallpic,PRODUCT_UPLOAD))

				$str .= '<div class="new-img"><img src="'.PRODUCT_PATH.'sml_'.$p_smallpic.'" alt="'.$p_name.'"></div>';

			$str .= '</a>';

			$str .= '<p class="strike-sold">';

			$chkidsearch = GetXArrFromYID('select iPCatID from prodcat where iParentID=4');

			

			if($cat_id==4 || in_array($cat_id,$chkidsearch))

			{

				if($prod_sold>=$prod_stockqty)

				{

					$str .= 'Sold Out '.$prod_stockqty.'/'.$prod_stockqty.'';

				

					if($prod_resaleqty!='' && $prod_resaleqty!='0')

					{

						$str .= ', '.$prod_resaleqty.' on Resale,<br/>';   //.$prod_stockqty.'/'.$prod_stockqty.'

						$str .= 'Sold '.($prod_sold-$prod_stockqty).' of '.$prod_resaleqty;

					}	

				}

				else

					$str .= 'Sold '.$prod_sold.' of '.$prod_stockqty;

			}

			$str .= '</p>';

			if($prod_soldout=='Y')

			$str .= '<img src="'.SITE_ADDRESS.'images/sold-red.png">';

			$str .= '<a href="'.$URL_BP.'">';

			$str .= '<h2>'.$p_name.'</h2>';

			$str .= '</a> <a href="'.$URL_BP.'">';



			if(isset($priceARR[$p_id]) && !empty($priceARR[$p_id]))

			{

				$p_offerprice = $priceARR[$p_id]['SALE_PRICE'];

				$p_price = $priceARR[$p_id]['ACTUAL_PRICE'];

			}



			if(!empty($p_offerprice))

			{

				$str .= '<span class="strike">Rs '.FormatNumber($p_price,'0','ind').'</span>';

				$str .= '<span class="red-1">Rs '.FormatNumber($p_offerprice,'0','ind').'</span>';

			}

			else

				$str .= '<span class="red-1">Rs '.FormatNumber($p_price,'0','ind').'</span>';

			$str .= '</a> <a href="'.$URL_BP.'">';

			$str .= '<h3>View details</h3>';

			$str .= '</a> </div>';

		}

		$str .= '</div>';

		$str .= '</div>';

		$str .= '</div>';

	}

		

	return $str;

}

function GetProductDetails($prod_id, $pc_id, $code)

{

	$str = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$code_label = ($pc_id=='1')?'ISBN No.:':'Code No.:';

	

    $str .= '<div>';

	$str .= '<table class="code-no" cellspacing="0" cellpadding="0">';

	

	if($code!='' && $code!='NULL')

	{

		$str .= '<tr>';

    	$str .= '<td width="25%" style="color:#b39f73">'.$code_label.'</td><td width="70%">'.$code.'</td>';

		$str .= '</tr>';

	}

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	

	$q = 'select iAttribID, iAttribDatID, vValue from product_attrib where iProdID='.$prod_id.' and fPrice=0 and fOPrice=0 order by FIELD(iAttribID,'.$att_str.')';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		while(list($attrib_id, $attribdat_id, $value) = sql_fetch_row($r))

		{

			$str .= '<tr>';

			$str .= '<td style="color:#b39f73">'.$attrib_name[$attrib_id].': </td>';

			

			if($attribdat_id)

				$str .= '<td>'.$attrib_datname[$attribdat_id].'</td>';

			elseif($value)

				$str .= '<td>'.$value.'</td>';

				

			$str .= '</tr>';

		}

	}

	

    $str .= '</table>';

    $str .= '</div>';



	return $str;

}

function GetProductAttribDetails($prod_id, $pc_id, $code, $a_selected)

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$p_attstr = GetIDString('select iProdAttribID from product_attrib where iProdID='.$prod_id.' and fPrice=0');

	

	if($p_attstr)

		$cond .= ' and iProdAttribID NOT IN ('.$p_attstr.')';

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	

	$last = '';

	$q = 'select iProdAttribID, iAttribID, iAttribDatID, vValue, fPrice, fOPrice, cDefault from product_attrib where cStock="Y" and iProdID='.$prod_id.$cond.' order by FIELD(iAttribID,'.$att_str.'), cDefault desc, fPrice';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$i = 1;

		while(list($pattribid, $attrib_id, $attribdat_id, $value, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			if($attrib_id=='1' && ($pc_id=='9' || $pc_id=='128'))

				continue;

			

			if($last!=$attrib_id)

			{

				if($i!=1)

					$str .= '</p>';

				

				$str .= '<p class="strike new">'.$attrib_name[$attrib_id].'</p>';

				$str .= '<p class="mario">';

				$last = $attrib_id;

			}

			

			if(empty($a_selected))

			{

				if($default=='Y')

					$chk = 'checked="checked"';

				else

					$chk = '';

			}

			else

			{

				if($a_selected==$pattribid)

					$chk = 'checked="checked"';

				else

					$chk = '';

			}

			

			if($attribdat_id)

				$str .= '<input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'">&nbsp;'.$attrib_datname[$attribdat_id].'<br/>';

			elseif($value)

				$str .= '<input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'">&nbsp;'.$value.'<br/>';

		}

		$str .= '</p>';

	}



    $str .= '<div class="clear"></div>';

	

	return $str;

}

function GetProductAttribDetailsSize($prod_id, $pc_id, $code, $a_selected)

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$p_attstr = GetIDString('select iProdAttribID from product_attrib where iProdID='.$prod_id.' and fPrice=0');

	

	if($p_attstr)

		$cond .= ' and iProdAttribID NOT IN ('.$p_attstr.')';

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	

	$last = '';

	$q = 'select iProdAttribID, iAttribID, iAttribDatID, vValue, fPrice, fOPrice, cDefault from product_attrib where cStock="Y" and iAttribID="1" and iProdID='.$prod_id.$cond.' order by FIELD(iAttribID,'.$att_str.'), cDefault desc, fPrice';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$i = 1;

		while(list($pattribid, $attrib_id, $attribdat_id, $value, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			if($attrib_id=='1' && ($pc_id!='9' && $pc_id!='128'))

				continue;

			

			if($last!=$attrib_id)

			{

				$str .= '<h2>Select '.$attrib_name[$attrib_id];

				if($pc_id=='9')

				    $str .= '&nbsp;<a href="#" class="show1"><span class="size-chrt" style="color: #b39f73;font-size:10px;">(Size Chart)</span></a>';

				$str .= '</h2>';

				$last = $attrib_id;

			}

			

			if(empty($a_selected))

			{

				if($default=='Y')

				{

					$chk = 'checked="checked"';

					$css = 'active-size';

				}

				else

				{

					$chk = '';

					$css = 'inactive-size';

				}

			}

			else

			{

				if($a_selected==$pattribid)

				{

					$chk = 'checked="checked"';

					$css = 'active-size';

				}

				else

				{

					$chk = '';

					$css = 'inactive-size';

				}

			}

			

			if($attribdat_id)

				$str .= '<label for="txtattribprice_'.$pattribid.'"><h3 class="'.$css.'" ><input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice2(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'" style="display:none">'.$attrib_datname[$attribdat_id].'</h3></label>';

			elseif($value)

				$str .= '<label for="txtattribprice_'.$pattribid.'"><h3 class="'.$css.'" ><input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice2(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'" style="display:none">'.$value.'</h3></label>';

		}

	}



    $str .= '<div class="clear"></div>';

	

	return $str;

}

function GetProductAttribDetailsColor($prod_id, $pc_id, $code, $c_selected, $a_selected)

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$color_name = GetXArrFromYID('select iColorID, vColor from color', '3');

	$attrib_datname = GetAttribDatName();



	$last = '';

	$q = 'select iPCID, iColorID, fPrice, fOPrice, cDefault from product_color_assoc where cStatus="A" and iProdID='.$prod_id.' and iProdAttribID='.$a_selected.' order by cDefault desc';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$i = 1;

		$str .= '<h2>Select Color</h2>';

		while(list($pattribid, $color_id, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			$viewSML = $viewBIG = $viewTITLE = '';

			$_ciq = 'select vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$prod_id.' and iPCID='.$pattribid.' order by cDefault desc';

			$_cir = sql_query($_ciq,'PCA.27');

			if(sql_num_rows($_cir))

			{

				while(list($title,$c_pic) = sql_fetch_row($_cir))

				{

					if(IsExistFile($c_pic,PRODUCT_COLOR_IMAGE_UPLOAD) && empty($viewSML) && empty($viewBIG) && empty($viewTITLE))

					{

						$viewSML = PRODUCT_COLOR_IMAGE_PATH.'sml_'.$c_pic;

						$viewBIG = PRODUCT_COLOR_IMAGE_PATH.$c_pic;

						$viewTITLE = $title;

					}

				}

			}

			

			$view = '';

			

			if(empty($c_selected))

			{

				if($default=='Y')

				{

					$chk = 'checked="checked"';

					$css = 'color-selected';

					$show = 'style="display:"';

				}

				else

				{

					$chk = '';

					$css = 'color-selected';

					$show = 'style="display:none"';

				}

			}

			else

			{

				if($pattribid==$c_selected)

				{

					$chk = 'checked="checked"';

					$css = 'color-selected';

					$show = 'style="display:"';

				}

				else

				{

					$chk = '';

					$css = 'color-selected';

					$show = 'style="display:none"';

				}

			}

			

			$img = 'tick-new.png';

			if($color_name[$color_id]=='#FFFFFF' || $color_name[$color_id]=='#ffffff' || $color_name[$color_id]=='#FFF' || $color_name[$color_id]=='#fff')

				$img = 'tick-new-black.png';

			

			$border = '';

			if($color_name[$color_id]=='#FFFFFF' || $color_name[$color_id]=='#ffffff' || $color_name[$color_id]=='#FFF' || $color_name[$color_id]=='#fff')

				$border = 'border:1px solid #ccc;';

			

			$str .= '<label for="txtcolor_'.$pattribid.'"><h3 style="background:'.$color_name[$color_id].'; '.$border.'"  onclick="GetColorSelected(\'txtcolor'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$viewSML.'\',\''.$viewBIG.'\',\''.$viewTITLE.'\');" ><input name="txtcolor" id="txtcolor'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none">

			<img src="'.SITE_ADDRESS.'images/'.$img.'" class="'.$css.' txtcolor'.$pattribid.'" '.$show.'/>

			</h3></label>';

		}

	}



    $str .= '<div class="clear"></div>';

	

	return $str;

}

function GetProductAttribDetails2($prod_id, $pc_id, $code)

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$p_attstr = GetIDString('select iProdAttribID from product_attrib where iProdID='.$prod_id.' and fPrice=0');

	

	if($p_attstr)

		$cond .= ' and iProdAttribID NOT IN ('.$p_attstr.')';

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	

	$last = '';

	$q = 'select iProdAttribID, iAttribID, iAttribDatID, vValue, fPrice, fOPrice, cDefault from product_attrib where iProdID='.$prod_id.$cond.' order by FIELD(iAttribID,'.$att_str.'), cDefault desc';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$str .= '<div class="lists">';

		

		$i = 1;

		while(list($pattribid, $attrib_id, $attribdat_id, $value, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			if($last!=$attrib_id)

			{

				if($i!=1)

					$str .= '</ul>';

				

				$str .= '<h2>'.$attrib_name[$attrib_id].'</h2>';

				$str .= '<ul>';

				$last = $attrib_id;

			}

			

			if($default=='Y')

				$chk = 'checked="checked"';

			else

				$chk = '';

			

			if($attribdat_id)

				$str .= '<li><input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'">'.$attrib_datname[$attribdat_id].'</li>';

			elseif($value)

				$str .= '<li><input name="txtattribprice" id="txtattribprice_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\');" '.$chk.' value="'.$pattribid.'">'.$value.'</li>';

		}

		$str .= '</ul>';

		$str .= '</div>';

	}



    $str .= '<div class="clear"></div>';

	

	return $str;

}

function GetSideBar($pc_id)

{

	$str = '';

	$PRICE_ARR = array();



	$NOVELTY_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 - 3000','5'=>'3000 & Above');

	$MERCHANDISE_ARR = array('1'=>'Below 500','2'=>'500 & Above');

	$PRINTS_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 & Above');

	$LIMITED_ARR = array('1'=>'Below 2000','2'=>'2000 - 3000','3'=>'3000 - 4000','4'=>'4000 & Above');

	$BOOK_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 & Above');

	$ORIGINAL_ARR = array('1'=>'20,000 - 50,000','2'=>'50,000 - 1 Lakh','3'=>'1 Lakh - 1.5 Lakh','4'=>'1.5 Lakh - 2 Lakh','5'=>'2 Lakh & Above');



	$c_arr = GetXArrFromYID('select iPCatID, iParentID from prodcat where cStatus="A"','3');

	

	if($pc_id=='1' || $c_arr[$pc_id]=='1')

		$PRICE_ARR = $BOOK_ARR;

	if($pc_id=='3' || $c_arr[$pc_id]=='3')

		$PRICE_ARR = $ORIGINAL_ARR;

	if($pc_id=='4' || $c_arr[$pc_id]=='4')

		$PRICE_ARR = $LIMITED_ARR;

	if($pc_id=='5' || $c_arr[$pc_id]=='5')

		$PRICE_ARR = $PRINTS_ARR;

	if($pc_id=='10' || $c_arr[$pc_id]=='10')

		$PRICE_ARR = $NOVELTY_ARR;

	if($pc_id=='11' || $c_arr[$pc_id]=='11')

		$PRICE_ARR = $MERCHANDISE_ARR;



	$str .= '<div class="result-box">';

    $str .= '<ul>';



	foreach($PRICE_ARR as $p_id=>$p_value)

	{

		$str .= '<li class="category"><a onclick="SearchProduct('.$p_id.');">'.$p_value.'</a></li>';           

	}



	$str .= '</ul>';

	$str .= '<br>';

	$str .= '</div>';



	return $str;

}

function GetBreadCrumb($p_id,$p_name,$p_catid,$p_catname)

{

	$str = '';



	if(URL_REWRITTING=='ON')

		$URL_MPC2 = GetURL($p_catid,'0','0','PC');

	else

		$URL_MPC2 = SITE_ADDRESS.'listing.php?cat_id='.$p_catid;



	$str .= '<p>';

    $str .= '<a href="'.SITE_ADDRESS.'">Home</a> &nbsp;&nbsp;>>&nbsp;&nbsp;';

    $str .= '<a href="'.$URL_MPC2.'">'.$p_catname.'</a> &nbsp;&nbsp;>>&nbsp;&nbsp;';

    $str .= $p_name;

	$str .= '</p>';

	  

	return $str;

}

function GetAssociatedProduct($p_id)

{

	$str = '';

	

	$p_str = GetIDString('select iPCID from product_assoc where iPPID='.$p_id.' order by iRank');

	

	if($p_str!='' && $p_str!='0')

	{

		$q = 'select iPCatID, iProdID, vName, vSmallImage, vImage, fPrice, fOPrice, iStockQty, iSold, iResaleQty from product where cStatus="A" and iProdID IN ('.$p_str.') order by FIELD(iProdID,'.$p_str.')';

		$r = sql_query($q,'BROWSE_147');

		$count = sql_num_rows($r);

		

		if($count)

		{ 

			while(list($cat,$prod_id,$prod_name,$prod_smallimg,$prod_img,$prod_price,$prod_offerprice,$prod_stockqty,$prod_sold,$prod_resaleqty)=sql_fetch_row($r))

			{

				echo '<div class="col">';

				echo '<div class="paint-box">';

				//echo '<a href="details.php?prod_id='.$prod_id.'">';

				echo '<h1>'.$prod_name.'</h1>';

				

				if(IsExistFile('sml_'.$prod_smallimg,PRODUCT_UPLOAD))

				{

					echo '<div class="image-hold">';

					echo '<img src="'.PRODUCT_PATH.'sml_'.$prod_smallimg.'">';

					echo '</div>';

				}

				 

				echo '<p>'; 

				//Soft Bound | 199 Pages<br>';

				

				if($prod_offerprice!='' && $prod_offerprice!='0')

						echo '<span>Rs. '.FormatNumber($prod_offerprice,'0','ind').' OFF</span>';

		

				echo '<h2 class="amount">Rs. '.FormatNumber($prod_price,'0','ind').'</h2>';

				echo '<a class="view_details" style="cursor:pointer;" onclick="ADDTOCART('.$prod_id.',0,\'O\')">Buy Now</a>';

				echo '<div class="clear"></div>';

				//echo '</a>';

				echo '</div>';

				echo '</div>';

			}

		}

	}

	return $str;

}

function GetProductOrder($order_id)

{

	$prod_name = GetXArrFromYID('select iProdID, vName from product','3');

	$str = '';

	$q = "select iProdID, iQty from orders_dat where iOrdID=$order_id";

	$r = sql_query($q,"PROD_CAT_NAME.2035");

	while(list($prod_id,$prod_qty)=sql_fetch_row($r))

	{

		$str .= $prod_name[$prod_id]." (Qty:-".$prod_qty."), ";

	}

	$str = substr($str,'0','-2');

	

	return $str;

}

function GetProductAttribDetail($ord_dat_id)

{

	$str = '';

	$attrib_datname = GetAttribDatName();

	$ATTRIB_ARR = GetXArrFromYID('select iAttribID, vName from attribute','3'); 



	$q = 'select iProdAttribID from orders_dat_attrib_assoc where iOrdDatId='.$ord_dat_id;

	$r = sql_query($q,'GPAD.1413');

	while(list($pattrib_id) = sql_fetch_row($r))

	{

		$qa = 'select iAttribID, iAttribDatID, vValue from product_attrib where iProdAttribID='.$pattrib_id; 

		$ra = sql_query($qa,'GPAD.1423');

		list($attrib_id,$attribdat_id,$attrib_value) = sql_fetch_row($ra);



		if($attribdat_id)

			$attrib_val = $attrib_datname[$attribdat_id];

		elseif($attrib_value)

			$attrib_val = $attrib_value;



		$attrib_name = (!empty($attrib_id))?GetXFromYID("select vName from attribute where iAttribID=".$attrib_id):'';



		$str .= $attrib_name.' = '.$attrib_val.', ';

	}

	

	$str = substr($str,0,'-2');

	

	return $str;

}

function GetProductAttriColorbDetail($ord_dat_id)

{

	$str = '';



	$color_str = '';

	$q3 = 'select iPCID from orders_dat_color_assoc where iOrdDatId='.$ord_dat_id;

	$r3 = ExecQuery($q3,"PO-89");

	while(list($pattrib_id2)=sql_fetch_row($r3))

	{

		$q4 = 'select vName from product_color_assoc as p, color as c where p.iColorID=c.iColorID and p.iPCID='.$pattrib_id2; 

		$r4 = ExecQuery($q4,"PO-220");

		list($attrib_value2) = sql_fetch_row($r4);

		$color_str .= "Color=".$attrib_value2.", ";

	}

	

	$str = $color_str;

	

	return $str;

}

function GetProductImage($p_id,$p_price)

{

	$str = '';

	

	$q = 'select iProdImageID, vTitle, vPic from product_images where cStatus="A" and iProdID='.$p_id;

	$r = sql_query($q,'GPI.1451');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_IMAGE_UPLOAD))

				$str .= '<li><img src="'.PRODUCT_IMAGE_PATH.'sml_'.$p_imgpic.'" data-large-src="'.PRODUCT_IMAGE_PATH.$p_imgpic.'"/></li>';

		}

	}

	

	

	return $str;

}

function GetSideMenu()

{

	$str = '';

	

	$q = 'select iPCatID, vName from prodcat where cLeftMenu="Y" and cStatus="A" order by iLeftRank';

	$r = sql_query($q,'GSM.1464');

	if(sql_num_rows($r))

	{

		$str .= '<div class="result-box">';

		$str .= '<ul>';

		

		while(list($c_id,$c_name) = sql_fetch_row($r))

		{

			if(URL_REWRITTING=='ON')

				$URL_SM = GetURL($c_id,'0','0','PC');

			else

				$URL_SM = SITE_ADDRESS.'listing.php?cat_id='.$c_id;

	

			$str .= '<li class="category"><a href="'.$URL_SM.'">'.$c_name.'</a></li>';           

		}



		$str .= '</ul>';

		$str .= '<br>';

		$str .= '</div>';

	}

	

	return $str;

}

function GetStaticURL($s_id,$type,$mail)

{

	$str = '';



	if($s_id!='' && $s_id!=0)

		$s_title = rtrim(GetXfromYID('select vUrlName from static where iSID='.$s_id), " ");

	else

		$s_title = '';

	

	if($type=='S')

	{

		$str = SITE_ADDRESS.'static/'.$s_title.'.html';

	}

	elseif($type=='SM')

	{

		$str = SITE_ADDRESS.'static/'.$s_title.'~'.$mail.'.html';

	}



	return $str;

}

function GetTestimonailURL($s_id,$type,$mail)

{

	$str = '';



	if($s_id!='' && $s_id!=0)



		$s_title = rtrim(GetXfromYID('select vUrlName from static where iSID='.$s_id), " ");

	else

		$s_title = '';

	

	if($type=='T')

	{

		$str = SITE_ADDRESS.'testimonial/'.$s_title.'.html';

	}

	elseif($type=='SM')

	{

		$str = SITE_ADDRESS.'testimonial/'.$s_title.'~'.$mail.'.html';

	}



	return $str;

}

function GetStaticSideBarDetails()

{

	$str = '';

	

	$q = 'select iSID, vTitle, vPic, vShortDesc from static where cStatus="A" and cUnder="H" order by iRank';

	$r = sql_query($q,'GSSBD.1512');

	

	if(sql_num_rows($r))

	{

		while(list($s_id,$s_title,$s_pic,$s_desc) = sql_fetch_row($r))

		{

			$str .= '<div class="white-box">';

			$str .= '<h2>'.$s_title.'</h2>';

			

			if(IsExistFile($s_pic,STATIC_UPLOAD))

				$str .= '<img src="'.STATIC_PATH.'sml_'.$s_pic.'"/>';

			

			$str .= '<p>'.$s_desc.' <a href="static.php?s_id='.$s_id.'" >Read More <b>&rsaquo;</b></a></p>';

			$str .= '</div>';

			$str .= '<div class="grey-sep"></div>';

		}

	}

	return $str;

}

function GetFooterLinks()

{

	$str = '';



	$q = 'select iSID, vTitle from static where cStatus="A" and cUnder="O" order by iRank';

	$r = sql_query($q,'GFL.1535');

	

	if(sql_num_rows($r))

	{

		while(list($s_id,$s_title) = sql_fetch_row($r))

		{

			if(URL_REWRITTING=='ON')

				$URL_S = GetStaticURL($s_id,'S','0');

			else

				$URL_S = SITE_ADDRESS.'static.php?s_id='.$s_id;

			

			$str .= '<a href="'.$URL_S.'"><p>'.$s_title.'</p></a>';

		}

	}

	

	return $str;

}



function GetDailyCartoon()

{

	$str = '';

	define('YESTERDAY', date("Y-m-d", strtotime("-1 day")));

	

	$q = 'select vPic from daily_cartoon where dDisplay="'.TODAY.'"';

	$r = sql_query($q,'GDC.1548');

	

	if(sql_num_rows($r))

	{

		list($dc_pic) = sql_fetch_row($r);

		

		if(IsExistFile($dc_pic,CARTOON_UPLOAD))

			$str = CARTOON_PATH.$dc_pic;

	}

	else

	{

		$id = GetXFromYID('select iDCID from daily_cartoon where dDisplay="'.YESTERDAY.'"');

		if($id=='' || $id=='0' || $id=='-1')

			$id = GetXFromYID('select iDCID from daily_cartoon order by iDCID limit 1');

		

		if($id!='' && $id!='0' && $id!='-1')

		{

			$next_id = GetXFromYID('select iDCID from daily_cartoon where iDCID>'.$id.' limit 1');

			

			if($next_id=='' || $next_id=='0' || $next_id=='-1')

				$next_id = GetXFromYID('select iDCID from daily_cartoon order by iDCID limit 1');

	

			$q = 'update daily_cartoon set dDisplay="'.TODAY.'" where iDCID='.$next_id;

			$r = sql_query($q,'GDC.1573');

			

			$dc_pic = GetXFromYID('select vPic from daily_cartoon where iDCID='.$next_id);

	

			if(IsExistFile($dc_pic,CARTOON_UPLOAD))

				$str = CARTOON_PATH.$dc_pic;

		}

	}



	return $str;

}

function GetHomeBox()

{

	$str = '';

	

	$q = 'select iSID, vTitle, vPic, vShortDesc from static where cStatus="A" and cUnder="H" order by iRank limit 2';

	$r = sql_query($q,'GSSBD.1512');

	

	if(sql_num_rows($r))

	{

		$i = '1';

		$str .= '<div class="row-testimonial">';

		$str .= '<h2 class="home-test"><span class="font-new"></span>&nbsp;&nbsp;&nbsp;Testimonials&nbsp;&nbsp;&nbsp;<span class="font-new"></span></h2>';

		while(list($s_id,$s_title,$s_pic,$s_desc) = sql_fetch_row($r))

		{

			if(URL_REWRITTING=='ON')

				$URL_S = GetTestimonailURL($s_id,'T','0');

			else

				$URL_S = SITE_ADDRESS.'testimonials.php?s_id='.$s_id;

		

			$css = ($i=='1')?' pull-left testimony fadeInLeft ':' pull-right testimony fadeInRight ';

		

			$str .= '<div class="col-md-5'.$css.'wow">';

			$str .= '<p><img src="'.SITE_ADDRESS.'images/quotes.png" class="pull-left"/>'.$s_desc.' ...<a href="'.$URL_S.'"><span class="gold"> Read more</span></a></p>';

			if(IsExistFile($s_pic,STATIC_UPLOAD))

				$str .= '<img src="'.STATIC_PATH.'sml_'.$s_pic.'" class="pull-left padding" />';

  			$str .= '<p class="pull-left blue">'.$s_title.'</p>';

  			$str .= '</div>';

			$i++;

		}

		$str .= '<div class="clearfix"></div>';

		$str .= '</div>';

	}

	return $str;

}

function GetProductImage2($p_id)

{

	$str = '';

	

	$q = 'select iProdImageID, vTitle, vPic from product_images where cStatus="A" and iProdID='.$p_id.' order by iProdImageID';

	$r = sql_query($q,'GPI.1451');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_IMAGE_UPLOAD))

				$str .= '<a href="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" class="fancybox-thumb1" rel="fancybox-thumb1" href="'.PRODUCT_IMAGE_PATH.'sml_'.$p_imgpic.'" data-large="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" data-title=""> <img src="'.PRODUCT_IMAGE_PATH.'sml_'.$p_imgpic.'" alt="'.$p_imgtitle.'" title="'.$p_imgtitle.'" width="75"/> </a>';

		}

	}

	

	

	return $str;

}



function GetProductColorImage($p_id)

{

	$str = '';

	

	$q = 'select iPCIID, vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$p_id;

	$r = sql_query($q,'GPCI.1801');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_COLOR_IMAGE_UPLOAD))

				$str .= '<a href="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" class="fancybox-thumb1" rel="fancybox-thumb1" href="'.PRODUCT_COLOR_IMAGE_PATH.'sml_'.$p_imgpic.'" data-large="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" data-title=""> <img src="'.PRODUCT_COLOR_IMAGE_PATH.'sml_'.$p_imgpic.'" alt="'.$p_imgtitle.'" title="'.$p_imgtitle.'" width="75"/> </a>';

		}

	}

	

	

	return $str;

}



function GetNonIndianShippingCharge($pData,$ship_country)

{

	$str = '';

	$total_shipping_cost = '0';

	

	$q2 = 'select fDefaultWeight, fDefaultAmount, fAdditionalWeight, fAdditionalAmount from country where cStatus="A" and cShipping="Y" and iCountryID='.$ship_country;

	$r2 = sql_query($q2,'GBDSC.1385');

	if(sql_num_rows($r2))

	{

		list($txtMinWeight, $txtMinAmount, $txtAddWeight, $txtAddAmount) = sql_fetch_row($r2);

	

	        $CART_CAT_ARR = $CART_ARR = array();

		$prod_id_arr2 = array_keys($pData);					

		foreach($prod_id_arr2 as $prod_id2)

		{

			$id = explode("_",$prod_id2);

				if(empty($id[0]))

					continue;

	

			$prod_att = explode("--",$pData[$prod_id2]);

			$prod_type = $prod_att[0];

			$print_id = $prod_att[1];

			$prod_qty = $prod_att[2];

	

			$_pq = 'select fPrice, fOPrice, iPCatID, fActualWeight, fVolumetricWeight from product where iProdID='.str_replace('_','',$id[0]);

			$_pr = sql_query($_pq,'G.P.R.286');

			list($price,$oprice,$pc_id,$prod_aweight,$prod_vweight) = sql_fetch_row($_pr);

			$pShipping = GetXFromYID('select cShippingPriceAbroad from prodcat where iPCatID='.$pc_id);

			if($pShipping=='Y')

			{

				$prod_weight = ($prod_aweight>=$prod_vweight)?$prod_aweight:$prod_vweight;

				$prod_weight = $prod_weight * $prod_qty;

				

				$prod_rate = $price;

				if(!empty($oprice))

					$prod_rate = $oprice;

		

				if(!empty($print_id))

				{

					$_q = 'select fPrice, fOPrice from product_attrib where iProdID='.str_replace('_','',$id[0]).' and iProdAttribID='.$print_id;

					$_r = sql_query($_q,'G.P.R.297');

					list($price,$oprice) = sql_fetch_row($_r);

					

					$prod_rate = $price;

					if(!empty($oprice))

						$prod_rate = $oprice;

				}

				

				$CART_ARR[] = array('CID'=>$pc_id, 'ID'=>$id[0], 'PRICE'=>$prod_rate, 'WEIGHT'=>$prod_weight);

			}

		}

	

		if(count($CART_ARR))

		{

			$CART_TEMP_ARR = array();

			foreach($CART_ARR as $key => $item)

			{

			   $CART_TEMP_ARR[$item['CID']][$key] = $item;

			}

			ksort($CART_TEMP_ARR, SORT_NUMERIC);

			

			foreach($CART_TEMP_ARR as $rKEY=>$rARRAY)		

			{

				$prod_rate = $prod_weight = '0';

				foreach($rARRAY as $rValue)

				{

					$prod_rate += $rValue['PRICE'];

					$prod_weight += $rValue['WEIGHT'];

				}

				

				if($txtMinWeight>=$prod_weight)

					$prod_weight = $txtMinWeight;

				

				$wValue = ceil($prod_weight/$txtMinWeight);

				if($wValue=='1')

					$ppAMount = $txtMinAmount;

				else

					$ppAMount = $txtMinAmount + (($wValue-1)*$txtAddAmount);

				

				$total = $ppAMount;

				$total_shipping_cost = $total_shipping_cost + $total;

			}

		}

	}



	$str = $total_shipping_cost;	

		

	return $str;

}



function GetNonIndianShippingChargeOLD($pData,$ship_country)

{

	$str = '';

	$total_shipping_cost = '0';

	

	$q2 = 'select fDefaultWeight, fDefaultAmount, fAdditionalWeight, fAdditionalAmount from country where cStatus="A" and cShipping="Y" and iCountryID='.$ship_country;

	$r2 = sql_query($q2,'GBDSC.1385');

	if(sql_num_rows($r2))

	{

		list($txtMinWeight, $txtMinAmount, $txtAddWeight, $txtAddAmount) = sql_fetch_row($r2);

		$prod_id_arr = array_keys($pData);					

		foreach($prod_id_arr as $prod_id)

		{

			$id = explode("_",$prod_id);

				if(empty($id[0]))

					continue;

	

			$prod_att = explode("--",$pData[$prod_id]);

			$prod_type= $prod_att[0];

			$print_id= $prod_att[1];

			$prod_qty = $prod_att[2];

	

			$q = 'select fActualWeight, fVolumetricWeight, iPCatID from product where iProdID='.str_replace('_','',$id[0]);

			$r = sql_query($q,'GBDSC.1393');

			if(sql_num_rows($r))

			{

				while(list($prod_aweight,$prod_vweight,$p_catid) = sql_fetch_row($r))

				{

					$pShipping = GetXFromYID('select cShipping from prodcat where iPCatID='.$p_catid);

					if($pShipping=='Y')

					{

						$prod_weight = ($prod_aweight>=$prod_vweight)?$prod_aweight:$prod_vweight;

						$prod_weight = $prod_weight * $prod_qty;

						

						$wValue = ceil($prod_weight/$txtMinWeight);

						if($wValue=='1')

							$ppAMount = $txtMinAmount;

						else

							$ppAMount = $txtMinAmount + (($wValue-1)*$txtAddAmount);

						

						$total = $ppAMount;

					}

					else

						$total = '0';

	

					$total_shipping_cost = $total_shipping_cost + $total;

				}

			}

		}

	}



	$str = $total_shipping_cost;	

		

	return $str;

}



function GetBlueDartShippingCharge($pData,$colorDATA)

{

	$p_str = $str = '';

	$total_shipping_cost = '0';

	

	$q2 = 'select fMinWeight, fPricePerWeight, fAdditionalWeight, fAdditionalPrice, fFuelSurchargePercentage, fCAFPercentage, fAWBAmount, fInsuracePercentage, fSTPercentage from bluedart_settings';

	$r2 = sql_query($q2,'GBDSC.1385');

	list($txtMinWeight, $txtPricePerWeight, $txtAddWeight, $txtAddAmount, $txtFuelSurchargePercentage, $txtCAFPercentage, $txtAWBAmount, $txtInsuracePercentage, $txtSTPercentage) = sql_fetch_row($r2);



	$CART_CAT_ARR = $CART_ALLOWED_ARR = array();

	$prod_id_arr2 = array_keys($pData);					

	foreach($prod_id_arr2 as $prod_id2)

	{

		$id = explode("_",$prod_id2);

			if(empty($id[0]))

				continue;



		$prod_att = explode("--",$pData[$prod_id2]);

		$prod_type = $prod_att[0];

		$print_id = $prod_att[1];

		$prod_qty = $prod_att[2];



		$_pq = 'select fPrice, fOPrice, iPCatID, fActualWeight, fVolumetricWeight from product where iProdID='.str_replace('_','',$id[0]);

		$_pr = sql_query($_pq,'G.P.R.286');

		list($price,$oprice,$pc_id,$prod_aweight,$prod_vweight) = sql_fetch_row($_pr);



		$priceARR = GetProductFlashSalePrice(str_replace('_','',$id[0]));

		if(isset($priceARR[str_replace('_','',$id[0])]) && !empty($priceARR[str_replace('_','',$id[0])]))

		{

			$oprice = $priceARR[str_replace('_','',$id[0])]['SALE_PRICE'];

			$price = $priceARR[str_replace('_','',$id[0])]['ACTUAL_PRICE'];

		}

				

		$_pq2 = 'select cShippingPriceIndia, cShippingPricePerItem, iParentID, cGroupItemForShipping from prodcat where iPCatID='.$pc_id;

		$_pr2 = sql_query($_pq2,'G.P.R.2195');

		list($pShipping,$pShippingPerItem,$pParentID,$pGroupItemForShipping) = sql_fetch_row($_pr2);

		

		if(!empty($pParentID))

		{

			$getAncsetorDet = GetAncestorDetail($pParentID);

			if(!empty($getAncsetorDet))

			{

				$getAncsetorDet2 = explode('~',$getAncsetorDet);

				$ancestor_id = $getAncsetorDet2[0];

				$pGroupItemForShipping = $getAncsetorDet2[1];

			}

			else

				$ancestor_id = $pc_id;

		}

		else

			$ancestor_id = $pc_id;

		

		//$pShipping = GetXFromYID('select cShippingPriceIndia from prodcat where iPCatID='.$pc_id);

		if($pShipping=='Y')

		{

			$prod_weight = ($prod_aweight>=$prod_vweight)?$prod_aweight:$prod_vweight;

			if($pShippingPerItem=='Y')

				$prod_weight = $prod_weight * $prod_qty;

			else

				$prod_weight = $prod_weight * 1;

			

			$prod_rate = $price;

			if(!empty($oprice))

				$prod_rate = $oprice;

	

			if(!empty($print_id))

			{

				$_q = 'select fPrice, fOPrice from product_attrib where iProdID='.str_replace('_','',$id[0]).' and iProdAttribID='.$print_id;

				$_r = sql_query($_q,'G.P.R.297');

				list($price,$oprice) = sql_fetch_row($_r);

				

				$prod_rate = $price;

				if(!empty($oprice))

					$prod_rate = $oprice;

			}



			if(isset($colorDATA[$prod_id2]))

			{

				$color_id = $colorDATA[$prod_id2];

				

				$_cq = 'select fPrice, fOPrice from product_color_assoc where iPCID='.$color_id.' and iProdAttribID='.$print_id.' and cStatus="A"';

				$_cr = sql_query($_cq,'G.P.S.C.R.297');

				if(sql_num_rows($_cr))

				{

					list($price,$oprice) = sql_fetch_row($_cr);

					

					if(!empty($price))

					{

						$prod_rate = $price;

						if(!empty($oprice))

							$prod_rate = $oprice;

					}

				}

			}	 	

			

			if($pGroupItemForShipping=='Y')

			{

				if(!isset($CART_ALLOWED_ARR[$ancestor_id]))

					$CART_ALLOWED_ARR[$ancestor_id] = 'Y';

				else

					continue;	

			}

			

			$CART_ARR[] = array('CID'=>$pc_id, 'ID'=>$id[0], 'PRICE'=>$prod_rate, 'WEIGHT'=>$prod_weight);

		}

	}



	if(count($CART_ARR))

	{

		$CART_TEMP_ARR = array();

		foreach($CART_ARR as $key => $item)

		{

		   $CART_TEMP_ARR[$item['CID']][$key] = $item;

		}

		ksort($CART_TEMP_ARR, SORT_NUMERIC);

		

		foreach($CART_TEMP_ARR as $rKEY=>$rARRAY)		

		{

			$prod_rate = $prod_weight = '0';

			foreach($rARRAY as $rValue)

			{

				$prod_rate += $rValue['PRICE'];

				$prod_weight += $rValue['WEIGHT'];

			}

			

			if($txtMinWeight>=$prod_weight)

				$prod_weight = $txtMinWeight;

			

			$wValue = ceil($prod_weight/$txtMinWeight);

			if($wValue=='1')

				$ppAMount = $txtPricePerWeight;

			else

				$ppAMount = $txtPricePerWeight + (($wValue-1)*$txtAddAmount);

			

			$minChargeable_weight =  $ppAMount; //$prod_weight * $txtPricePerWeight;

			$fuelSurcharge = ($txtFuelSurchargePercentage * $minChargeable_weight)/100;

			$CAF = ($txtCAFPercentage * ($minChargeable_weight + $fuelSurcharge))/100;

			$AWB = $txtAWBAmount;

			$insurance = ($txtInsuracePercentage * $prod_rate)/100;

			$st = ($txtSTPercentage * ($minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance))/100; 

	

			$total = $minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance + $st;

			$total_shipping_cost = $total_shipping_cost + $total;

		}

	}

	

	$str = $total_shipping_cost;

	return $str;

}



function GetBlueDartShippingChargeOLD($pData)

{

	$p_str = '';

	

	$str = '';

	$total_shipping_cost = '0';

	

	$q2 = 'select fMinWeight, fPricePerWeight, fAdditionalWeight, fAdditionalPrice, fFuelSurchargePercentage, fCAFPercentage, fAWBAmount, fInsuracePercentage, fSTPercentage from bluedart_settings';

	$r2 = sql_query($q2,'GBDSC.1385');

	list($txtMinWeight, $txtPricePerWeight, $txtAddWeight, $txtAddAmount, $txtFuelSurchargePercentage, $txtCAFPercentage, $txtAWBAmount, $txtInsuracePercentage, $txtSTPercentage) = sql_fetch_row($r2);



	$prod_id_arr = array_keys($pData);					

	foreach($prod_id_arr as $prod_id)

	{

		$id = explode("_",$prod_id);

			if(empty($id[0]))

				continue;



		$prod_att = explode("--",$pData[$prod_id]);

		$prod_type= $prod_att[0];

		$print_id= $prod_att[1];

		$prod_qty = $prod_att[2];



		if($print_id=='0')

		{

			$_q = 'select fPrice, fOPrice from product where iProdID='.str_replace('_','',$id[0]);

			$_r = sql_query($_q,'G.P.R.286');

			list($price,$oprice) = sql_fetch_row($_r);

			

			$prod_rate = $price;

			if(!empty($oprice))

				$prod_rate = $oprice;

		}

		else

		{

			$_q = 'select fPrice, fOPrice from product_attrib where iProdID='.str_replace('_','',$id[0]).' and iProdAttribID='.$print_id;

			$_r = sql_query($_q,'G.P.R.297');

			list($price,$oprice) = sql_fetch_row($_r);

			

			$prod_rate = $price;

			if(!empty($oprice))

				$prod_rate = $oprice;

		}



		$q = 'select fActualWeight, fVolumetricWeight, iPCatID from product where iProdID='.str_replace('_','',$id[0]);

		$r = sql_query($q,'GBDSC.1393');

		if(sql_num_rows($r))

		{

			while(list($prod_aweight,$prod_vweight,$p_catid) = sql_fetch_row($r))

			{

				$pShipping = GetXFromYID('select cShipping from prodcat where iPCatID='.$p_catid);

				if($pShipping=='Y')

				{

					$prod_weight = ($prod_aweight>=$prod_vweight)?$prod_aweight:$prod_vweight;

					$prod_weight = $prod_weight * $prod_qty;

					if($txtMinWeight>=$prod_weight)

						$prod_weight = $txtMinWeight;

					

					$wValue = ceil($prod_weight/$txtMinWeight);

					if($wValue=='1')

						$ppAMount = $txtPricePerWeight;

					else

						$ppAMount = $txtPricePerWeight + (($wValue-1)*$txtAddAmount);



					$minChargeable_weight =  $ppAMount; //$prod_weight * $txtPricePerWeight;

					$fuelSurcharge = ($txtFuelSurchargePercentage * $minChargeable_weight)/100;

					$CAF = ($txtCAFPercentage * ($minChargeable_weight + $fuelSurcharge))/100;

					$AWB = $txtAWBAmount;

					$insurance = ($txtInsuracePercentage * $prod_rate)/100;

					$st = ($txtSTPercentage * ($minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance))/100; 

	

					$total = $minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance + $st;

				}

				else

					$total = '0';



				$total_shipping_cost = $total_shipping_cost + $total;

			}

		}

	}

	

	$str = $total_shipping_cost;

	return $str;

}



function GetPriceFilter($pc_id)

{

	$str = '';

	$PRICE_ARR = array();



	$NOVELTY_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 - 3000','5'=>'3000 & Above');

	$MERCHANDISE_ARR = array('1'=>'Below 500','2'=>'500 & Above');

	$PRINTS_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 & Above');

	$LIMITED_ARR = array('1'=>'Below 2000','2'=>'2000 - 3000','3'=>'3000 - 4000','4'=>'4000 & Above');

	$BOOK_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 & Above');

	$ORIGINAL_ARR = array('1'=>'20,000 - 50,000','2'=>'50,000 - 1 Lakh','3'=>'1 Lakh - 1.5 Lakh','4'=>'1.5 Lakh - 2 Lakh','5'=>'2 Lakh & Above');



	$c_arr = GetXArrFromYID('select iPCatID, iParentID from prodcat where cStatus="A"','3');

	

	if($pc_id=='1' || $c_arr[$pc_id]=='1')

		$PRICE_ARR = $BOOK_ARR;

	if($pc_id=='3' || $c_arr[$pc_id]=='3')

		$PRICE_ARR = $ORIGINAL_ARR;

	if($pc_id=='4' || $c_arr[$pc_id]=='4')

		$PRICE_ARR = $LIMITED_ARR;

	if($pc_id=='5' || $c_arr[$pc_id]=='5')

		$PRICE_ARR = $PRINTS_ARR;

	if($pc_id=='10' || $c_arr[$pc_id]=='10')

		$PRICE_ARR = $NOVELTY_ARR;

	if($pc_id=='11' || $c_arr[$pc_id]=='11')

		$PRICE_ARR = $MERCHANDISE_ARR;



	foreach($PRICE_ARR as $p_id=>$p_value)

		$str .= '<option value="'.$p_id.'">'.$p_value.'</option>';           



	return $str;

}



function GetAssociatedProductNew($p_id)

{

	$str = '';

	

	$p_str = GetIDString('select iPCID from product_assoc where iPPID='.$p_id.' order by iRank');

	

	if($p_str!='' && $p_str!='0')

	{

		$priceARR = array();

		$pSTR = GetIDString('select iProdID from product where cStatus="A" and iProdID IN ('.$p_str.')');

		if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



		$q = 'select iPCatID, iProdID, vName, vSmallImage, vImage, fPrice, fOPrice, iStockQty, iSold, iResaleQty from product where cStatus="A" and iProdID IN ('.$p_str.') order by FIELD(iProdID,'.$p_str.')';

		$r = sql_query($q,'BROWSE_147');

		$count = sql_num_rows($r);

		

		if($count)

		{ 

			$str .= '<h4 class="postcard">Individual Items</h4>';

			while(list($cat,$prod_id,$prod_name,$prod_smallimg,$prod_img,$prod_price,$prod_offerprice,$prod_stockqty,$prod_sold,$prod_resaleqty)=sql_fetch_row($r))

			{

				$str .= '<div class="single-card">';

				if(IsExistFile('sml_'.$prod_smallimg,PRODUCT_UPLOAD))

				{

					$str .= '<div class="one-side">';

					$str .= '<img src="'.PRODUCT_PATH.'sml_'.$prod_smallimg.'">';

					$str .= '</div>';

				}

				$str .= '<div class="one-side right">';

				$str .= '<h2>'.$prod_name.'</h2>';

				$str .= '<p>';



				if(isset($priceARR[$prod_id]) && !empty($priceARR[$prod_id]))

				{

					$prod_offerprice = $priceARR[$prod_id]['SALE_PRICE'];

					$prod_price = $priceARR[$prod_id]['ACTUAL_PRICE'];

				}



				if(!empty($prod_offerprice))

				{



					$str .= '<span class="strike">Rs '.FormatNumber($prod_price,'0','ind').'</span>';

					$str .= '<span class="red-1">Rs '.FormatNumber($prod_offerprice,'0','ind').'</span>';

				}

				else

					$str .= '<span class="red-1">Rs '.FormatNumber($prod_price,'0','ind').'</span>';

				$str .= '</p>';

				$str .= '<input type="submit" class="add-cart" onclick="ADDTOCART('.$prod_id.',0,\'O\')" value="Add to cart">';

				$str .= '</div>';

				$str .= '<div class="clear"></div>';

				$str .= '</div>';

			}

		}

	}

	return $str;

}



function SuggestCode()

{

	$arr = array();

	

	$len = rand(10, 12);	

	

	// atleast 1 uppercase char

	$a_len = rand(1, $len-3);

	// echo 'a_len: '.$a_len.'<br>';

	

	for($i=0; $i<$a_len; $i++)

		$arr[$i] = chr(rand(65, 90));



	$ctr = $i;



	// atleast 1 lowercase char

	$b_len = rand(1, $len-2-$a_len);

	// echo 'b_len: '.$b_len.'<br>';



	for(;$i<($ctr+$b_len); $i++)

		$arr[$i] = chr(rand(97, 122));



	$ctr = $i;



	// atleast 1 number

	$c_len = rand(1, $len-1-$a_len-$b_len);

	// echo 'c_len: '.$c_len.'<br>';

	

	for(;$i<($ctr+$c_len); $i++)

		$arr[$i] = rand(0, 9);

	

	// DFA($arr);

	shuffle($arr);

	// DFA($arr);

	

	$str = '';	

	foreach($arr as $a)

		$str .= $a;

	

	return $str;

}



function GenerateCouponCode()

{

	$str = '';

	

	$code = SuggestCode();

	$code2 = GetXFromYID('select count(*) from disc_coupon where vCode="'.$code.'"');

	if(!empty($code2))

		GenerateCouponCode();

	else

		$str = $code;

		

	return $str;

}



function DateTimeAdd($date, $dd=0, $mm=0, $yy=0, $hh=0, $nn=0, $ss=0, $format="Y-m-d H:i:s")

{

	$d = date("Y-m-d H:i:s", strtotime($date));

	

	//echo $d . " ($dd, $mm, $yy) <br>";	

	$t_arr = explode(' ', $d);

	$date_str = $t_arr[0];

	$time_str = $t_arr[1];

		

	$tm_arr = explode(':', $time_str);

	$hour = $tm_arr[0];

	$mins = $tm_arr[1];

	$secs = $tm_arr[2];



	$dt_arr = explode('-', $date_str);

	$year = $dt_arr[0];

	$mnth = $dt_arr[1];

	$days = $dt_arr[2];



//	echo "mktime($hour, $mins, $secs, ($mnth + $mm), ($days + $dd), ($year + $yy)) <br>";

	$t = mktime(($hour + $hh), ($mins + $nn), ($secs + $ss), ($mnth + $mm), ($days + $dd), ($year + $yy));

	

	if(empty($format)) $format = "Y-m-d H:i:s";		

	$date = date($format, $t);



	return $date;

}



function GetAncestorDetail($pc_id)

{

	$str = '';

	

	$_pq2 = 'select iParentID, cGroupItemForShipping from prodcat where iPCatID='.$pc_id;

	$_pr2 = sql_query($_pq2,'G.P.R.2195');

	if(sql_num_rows($_pr2))

	{

		list($pParentID,$pGroupItemForShipping) = sql_fetch_row($_pr2);

		if(!empty($pParentID))

			$str = GetAncestorDetail($pParentID);

	

		$str = $pc_id.'~'.$pGroupItemForShipping;

	}



	return $str;

}



function GetFlashSaleDet()

{

	$str = '';

	$COLOR_ARR = GetXArrFromYID('select iColorID, vColor from color', '3');

	$endTIMER = '';

	

	$q = 'select iFID, vName, dtStart, dtEnd, iColorID from flash where cStatus="A" and dtEnd>"'.NOW.'" order by dtStart';

	$r = sql_query($q,'');

	if(sql_num_rows($r))

	{

 	 	$str .= '<div class="container">';

 	 	$str .= '<div class="mario-offer-set">';

		

		while(list($id,$name,$start,$end,$color_id) = sql_fetch_row($r))

		{

			$bgCOLOR = (!empty($color_id))?$COLOR_ARR[$color_id]:'';



			if(URL_REWRITTING=='ON')

				$URL_FLASH = GetURL($id,'0','0','F');

			else

				$URL_FLASH = SITE_ADDRESS.'flashsale.php?f_id='.$id;



			$str .= '<div class="mario-offer" style="background:'.$bgCOLOR.'">';

			$str .= '<h5><a href="'.$URL_FLASH.'">'.$name.'</a></h5>';

			$str .= '<p>'.str_replace('  ','&nbsp;&nbsp;',FormatDate($start,'G')).'</p>';

	  		

			//echo $start.'>'.NOW;

			

			if($start>NOW)

				$str .= '<p class="mario-soon">Coming Soon</p>';

			else

			{

				$diff = abs(strtotime($end) - strtotime(NOW)); 

				$years   = floor($diff / (365*60*60*24)); 

				$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 

				$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

				$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

				$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

			

				$str .= '<div class="time-duration">';

				$str .= '<div id="timer-text">';

				$str .= '<p>Ends in</p>';

				$str .= '</div>';

				$str .= '<div id="timer">';

				$str .= '<div id="hours" class="ti-mer ti-mer-time">'.$hours.'</div>';

				$str .= '<div id="colon1" class="ti-mer">:</div>';

				$str .= '<div id="minutes" class="ti-mer ti-mer-time">'.$minuts.'</div>';

				$str .= '<div id="colon1" class="ti-mer">:</div>';

				$str .= '<div id="seconds" class="ti-mer ti-mer-time">'.$seconds.'</div>';

				$str .= '<div class="clear"></div>';

				$str .= '</div>';

				$str .= '<div class="clear"></div>';

				$str .= '</div>';

				

				$endTIMER = $end;

			}

			

			$str .= '</div>';

		}

		

		$str .= '<div class="clear"></div>';

		$str .= '</div>';

		$str .= '</div>';

	}

	

	return $str.'~~**~~'.$endTIMER;

}



function GetProductFlashSalePrice($p_id=0)

{

	$arr = array();

	

	$cond = '';

	if(!empty($p_id))

	{

		if (strpos($p_id, ',') !== false)

			$cond = ' and f2.iProdID IN ('.$p_id.')';

		else

			$cond = ' and f2.iProdID='.$p_id;

	}

	

	$q = 'select f2.iProdID, f2.fPrice, f2.fOPrice, f.dtStart, f.dtEnd from flash_dat as f2 join flash as f on f2.iFID=f.iFID where f.cStatus="A"';

	$r = sql_query($q,'');

	if(sql_num_rows($r))

	{

		while(list($pID,$pPRICE,$pOPRICE,$pSTART,$pEND) = sql_fetch_row($r))

		{

		    if($pSTART<=NOW && $pEND>=NOW)

		    {

			    $arr[$pID]['SALE_PRICE'] = $pPRICE;

			    $arr[$pID]['ACTUAL_PRICE'] = $pOPRICE;

		    }

	    }

	}

	

	return $arr;

}



function GetMaxRank($tbl, $cond="", $fld='iRank')

{

	$cond = (strtoupper(trim($cond)) != "")? " where " . $cond: "";	



	$q = "select max($fld) from $tbl $cond";	

	$r = sql_query($q, 'GEN.94');

	list($max)=sql_fetch_row($r);



	if($max < 1)

		$max = 0;



	return ++$max;

}



//2020 Functions

function GetURL2020($pc_id,$pc_title,$id,$title,$type)

{

	$str = '';



	if($type=='PC')

		$str = SITE_ADDRESS.'category/'.$pc_title.'.html';

	elseif($type=='P')

		$str = SITE_ADDRESS.$pc_title.'/'.$title.'.html';

	elseif($type=='N')

		$str = SITE_ADDRESS.'news/'.$pc_title.'.html';

	elseif($type=='F')

		$str = SITE_ADDRESS.'flash-sale/'.$pc_title.'.html';

	elseif($type=='HP')

		$str = SITE_ADDRESS.'section/'.$pc_title.'.html';



	return $str;

}



function GetParentCategoryList2020($id,$str='')

{

	$q = 'select iPCatID, vName, vUrlName, iParentID from prodcat where iPCatID='.$id;

	$r = sql_query($q,'GPCL.');

	if(sql_num_rows($r))

	{

		while(list($id,$name,$url,$p_id) = sql_fetch_row($r))

		{

			if(!empty($p_id)) $str .= GetParentCategoryList2020($p_id);

			

			$URL = (URL_REWRITTING=='ON')?GetURL2020($id,$url,'0','','PC'):SITE_ADDRESS.'listing.php?cat_id='.$id;

			//if(empty($p_id)) $URL = '#';

			$str .= '<li><a href="'.$URL.'">'.htmlspecialchars_decode($name).'</a> >> </li>';

		}

	}

	

	return $str;

}



function GetPriceFilter2020($pc_id)

{

	$PRICE_ARR = array();



	$NOVELTY_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 - 3000','5'=>'3000 & Above');

	$MERCHANDISE_ARR = array('1'=>'Below 500','2'=>'500 & Above');

	$PRINTS_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 & Above');

	$LIMITED_ARR = array('1'=>'Below 2000','2'=>'2000 - 3000','3'=>'3000 - 4000','4'=>'4000 & Above');

	$BOOK_ARR = array('1'=>'Below 500','2'=>'500 - 1000','3'=>'1000 - 2000','4'=>'2000 & Above');

	$ORIGINAL_ARR = array('1'=>'20,000 - 50,000','2'=>'50,000 - 1 Lakh','3'=>'1 Lakh - 1.5 Lakh','4'=>'1.5 Lakh - 2 Lakh','5'=>'2 Lakh & Above');



	$c_arr = GetXArrFromYID('select iPCatID, iParentID from prodcat where cStatus="A"','3');

	

	if($pc_id=='1' || $c_arr[$pc_id]=='1')

		$PRICE_ARR = $BOOK_ARR;

	if($pc_id=='3' || $c_arr[$pc_id]=='3')

		$PRICE_ARR = $ORIGINAL_ARR;

	if($pc_id=='4' || $c_arr[$pc_id]=='4')

		$PRICE_ARR = $LIMITED_ARR;

	if($pc_id=='5' || $c_arr[$pc_id]=='5')

		$PRICE_ARR = $PRINTS_ARR;

	if($pc_id=='10' || $c_arr[$pc_id]=='10')

		$PRICE_ARR = $NOVELTY_ARR;

	if($pc_id=='11' || $c_arr[$pc_id]=='11')

		$PRICE_ARR = $MERCHANDISE_ARR;



	return $PRICE_ARR;

}



function GetChildCategory2020($id)

{

	$arr = array();

	

	$q = 'select iPCatID, vName, vUrlName from prodcat where cStatus="A" and iParentID='.$id.' order by iRank';

	$r = sql_query($q,'');

	if(sql_num_rows($r))

	{

		while(list($p_catid,$p_catname,$p_caturl) = sql_fetch_row($r))

			$arr[$p_catid] = array('NAME'=>$p_catname, 'URL'=>$p_caturl);

	}

	

	return $arr;

}



function GetParentCategoryBanner2020($id,$str='')

{

	$q = 'select vBannerImage, iParentID from prodcat where iPCatID='.$id;

	$r = sql_query($q,'GPCL.');

	if(sql_num_rows($r))

	{

		while(list($banner_image,$p_id) = sql_fetch_row($r))

		{

			if(!empty($p_id)) $str = GetParentCategoryList2020($p_id);

			else

			{

				if(!empty($banner_image) && IsExistFile($banner_image,PROD_CAT_UPLOAD))

					$str = $banner_image;

			}

		}

	}

	

	return $str;

}



function GetParentCategoryMobileBanner2020($id,$str='')

{

	$q = 'select vMobileBannerImage, iParentID from prodcat where iPCatID='.$id;

	$r = sql_query($q,'GPCL.');

	if(sql_num_rows($r))

	{

		while(list($mobilebanner_image,$p_id) = sql_fetch_row($r))

		{

			if(!empty($p_id)) $str = GetParentCategoryMobileBanner2020($p_id);

			else

			{

				if(!empty($mobilebanner_image) && IsExistFile($mobilebanner_image,PROD_CAT_UPLOAD))

					$str = $mobilebanner_image;

			}

		}

	}

	

	return $str;

}



function GetProductCategoryList2020($id,$arr=array())

{

	$q = 'select iPCatID, vName, vUrlName, iParentID from prodcat where iPCatID='.$id;

	$r = sql_query($q,'GPCL.');

	if(sql_num_rows($r))

	{

		while(list($id,$name,$url,$p_id) = sql_fetch_row($r))

		{

			if(!empty($p_id)) $arr = GetProductCategoryList2020($p_id,$arr);

			

			$URL = (URL_REWRITTING=='ON')?GetURL2020($id,$url,'0','','PC'):SITE_ADDRESS.'listing.php?cat_id='.$id;

			

			$arr[$id] = array('NAME'=>htmlspecialchars_decode($name), 'URL'=>$URL);

		}

	}

	

	return $arr;

}



function GetProductImage2020($id)

{

	$str = '';

	

	$q = 'select iProdImageID, vTitle, vPic from product_images where cStatus="A" and iProdID='.$id.' order by iProdImageID';

	$r = sql_query($q,'GPI.1451');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_IMAGE_UPLOAD))

				$str .= '<a class="pro-block" href="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" title="'.htmlspecialchars_decode($p_imgtitle).'"><div class="pro-img-bx"><img src="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" alt="'.htmlspecialchars_decode($p_imgtitle).'"/><div class="pro-overlay"><img src="'.SITE_ADDRESS.'assets2/images/popup.png" alt="Popup" /></div></div></a>';

		}

	}

	

	

	return $str;

}



function GetProductColorImage2020($id)

{

	$str = '';

	

	$q = 'select iPCIID, vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$id;

	$r = sql_query($q,'GPCI.1801');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_COLOR_IMAGE_UPLOAD))

				$str .= '<a class="pro-block" href="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" title="'.htmlspecialchars_decode($p_imgtitle).'"><div class="pro-img-bx"><img src="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" alt="'.htmlspecialchars_decode($p_imgtitle).'"/><div class="pro-overlay"><img src="'.SITE_ADDRESS.'assets2/images/popup.png" alt="Popup" /></div></div></a>';

		}

	}



	return $str;

}



function GetProductImage2020_2($id)

{

	$str = '';

	

	$q = 'select iProdImageID, vTitle, vPic from product_images where cStatus="A" and iProdID='.$id.' order by iProdImageID';

	$r = sql_query($q,'GPI.1451');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_IMAGE_UPLOAD))

				$str .= '<div class="item"><div class="pro-img-bx popup-gallery"><a class="pro-block" href="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" title="'.htmlspecialchars_decode($p_imgtitle).'"><div class="pro-img-bx"><img src="'.PRODUCT_IMAGE_PATH.$p_imgpic.'" alt="'.htmlspecialchars_decode($p_imgtitle).'"/><div class="pro-overlay"><img src="'.SITE_ADDRESS.'assets2/images/popup.png" alt="Popup" /></div></div></a></div></div>';

		}

	}

	

	

	return $str;

}



function GetProductColorImage2020_2($id)

{

	$str = '';

	

	$q = 'select iPCIID, vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$id;

	$r = sql_query($q,'GPCI.1801');

	if(sql_num_rows($r))

	{

		while(list($p_imgid,$p_imgtitle,$p_imgpic) = sql_fetch_row($r))

		{

			if(IsExistFile($p_imgpic,PRODUCT_COLOR_IMAGE_UPLOAD))

				$str .= '<div class="item"><div class="pro-img-bx popup-gallery"><a class="pro-block" href="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" title="'.htmlspecialchars_decode($p_imgtitle).'"><div class="pro-img-bx"><img src="'.PRODUCT_COLOR_IMAGE_PATH.$p_imgpic.'" alt="'.htmlspecialchars_decode($p_imgtitle).'"/><div class="pro-overlay"><img src="'.SITE_ADDRESS.'assets2/images/popup.png" alt="Popup" /></div></div></a></div></div>';

		}

	}



	return $str;

}



function GetProductDetails2020($prod_id, $pc_id, $code)

{

	$str = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$code_label = ($pc_id=='1')?'ISBN No.:':'Code No.:';

	

    $str .= '<div class="pro-info-list">';

	

	if($code!='' && $code!='NULL')

	{

		$str .= '<div class="pro-feature-bx">';

		$str .= '<div class="feature-info">';

		$str .= '<label>'.$code_label.'</label>';

		$str .= '</div>';

		$str .= '<div class="feature-info">';

		$str .= '<p>'.$code.'</p>';

		$str .= '</div>';

		$str .= '<div class="clear"></div>';

		$str .= '</div>';

	}

	

	$DETAIL_ARR = array();

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	$q = 'select iAttribID, iAttribDatID, vValue from product_attrib where iProdID='.$prod_id.' and fPrice=0 and fOPrice=0 order by FIELD(iAttribID,'.$att_str.')';

	$r = sql_query($q, 'GPD.1196');

	if(sql_num_rows($r))

	{

		while(list($attrib_id, $attribdat_id, $value) = sql_fetch_row($r))

		{

			$VALUE = $value;

			if($attribdat_id)

				$VALUE = $attrib_datname[$attribdat_id];



			if(!isset($DETAIL_ARR[$attrib_id])) $DETAIL_ARR[$attrib_id] = array();

			array_push($DETAIL_ARR[$attrib_id],$VALUE);

		}

	}

	

	if(!empty($DETAIL_ARR) && count($DETAIL_ARR))

	{

		foreach($DETAIL_ARR as $a=>$v)

		{

			$str .= '<div class="pro-feature-bx">';

			$str .= '<div class="feature-info">';

			$str .= '<label>'.$attrib_name[$a].':</label>';

			$str .= '</div>';

			$str .= '<div class="feature-info">';

			if(count($v)>1)

			{

				$str .= '<ul>';

				foreach($v as $v2)

					$str .= '<li>'.$v2.'</li>';

				$str .= '</ul>';

			}

			else

			{

				foreach($v as $v2)

					$str .= '<p>'.$v2.'</p>';

			}

			$str .= '</div>';

			$str .= '<div class="clear"></div>';

			$str .= '</div>';

		}

	}

	

	

    $str .= '</div>';



	return $str;

}



function GetProductAttribDetails2020($prod_id, $a_selected, $p_catid, $SIZE_CHART='N')

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');



	$p_attstr = GetIDString('select iProdAttribID from product_attrib where iProdID='.$prod_id.' and fPrice=0');

	if($p_attstr)

		$cond .= ' and iProdAttribID NOT IN ('.$p_attstr.')';

	

	$last = '';

	$q = 'select iProdAttribID, iAttribID, iAttribDatID, vValue, fPrice, fOPrice, cDefault from product_attrib where cStock="Y" and iProdID='.$prod_id.$cond.' order by FIELD(iAttribID,'.$att_str.'), cDefault desc, fPrice';

	$r = sql_query($q, 'GPD.1196');

	if(sql_num_rows($r))

	{

		$i = 1;

		while(list($pattribid, $attrib_id, $attribdat_id, $value, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			if($last!=$attrib_id)

			{

				if($i!=1)

					$str .= '</div>';

				

				$str .= '<div class="pro-type-bx">';

				if($attrib_id=='1')

				{

					$str .= '<h2>Select '.$attrib_name[$attrib_id];

					if($SIZE_CHART=='Y')

						$str .= '&nbsp;<a  href="#test-form" class="popup-size-form size-popup show1">Size Chart</a>';

					$str .= '</h2>';

				}

				else

					$str .= '<h6>'.$attrib_name[$attrib_id].'</h6>';

				$last = $attrib_id;

			}



			if($attrib_id!='1') // && $attrib_id!='18'

			{

                if(empty($a_selected))

                {

                    if($default=='Y')

                        $chk = 'checked="checked"';

                    else

                        $chk = '';

                }

                else

                {

                    if($a_selected==$pattribid)

                        $chk = 'checked="checked"';

                    else

                        $chk = '';

                }



                $VALUE = (!empty($attribdat_id))?$attrib_datname[$attribdat_id]:$value;

                $str .= '<input name="rdattribute" id="rdattribute_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\',\''.$pattribid.'\');" '.$chk.' value="'.$pattribid.'">&nbsp;'.$VALUE.'<br/>';

            }

			else

			{

				if($attrib_id=='1' && $p_catid=='95')

				{

					$chk = $css = '';

					if(empty($a_selected))

					{

						if($default=='Y')

						{

							$chk = 'checked="checked"';

							$css = ' selected';

						}

					}

					else

					{

						if($a_selected==$pattribid)

						{

							$chk = 'checked="checked"';

							$css = ' selected';

						}

					}

	

					$labelTAG = '';

					$VALUE = (!empty($attribdat_id))?$attrib_datname[$attribdat_id]:$value;

					if(strpos($VALUE,'Kids - ') !== false)

					{

						$labelTAG = '<span class="kids-tag">Kids</span>';

						$VALUE = str_replace('Kids - ','',$VALUE);

					}

	

					if(strpos($VALUE,'Kids ') !== false)

					{

						$labelTAG = '<span class="kids-tag">Kids</span>';

						$VALUE = str_replace('Kids ','',$VALUE);

					}

					

					$str .= '<label for="rdattribute_'.$pattribid.'"><div class="size-bx'.$css.'" name="rdattribute_'.$pattribid.'">'.$labelTAG.'<input name="rdattribute" id="rdattribute_'.$pattribid.'" type="radio" onclick="GetProductPrice3(\''.$price_india.'\',\''.$price_oindia.'\',\''.$pattribid.'\');" '.$chk.' value="'.$pattribid.'" style="display:none;">'.$VALUE.'</div></label>';

				}

              	else

                {

                    if(empty($a_selected))

                    {

                        if($default=='Y')

                            $chk = 'checked="checked"';

                        else

                            $chk = '';

                    }

                    else

                    {

                        if($a_selected==$pattribid)

                            $chk = 'checked="checked"';

                        else

                            $chk = '';

                    }



                    $VALUE = (!empty($attribdat_id))?$attrib_datname[$attribdat_id]:$value;

                    $str .= '<input name="rdattribute" id="rdattribute_'.$pattribid.'" type="radio" onclick="GetProductPrice(\''.$price_india.'\',\''.$price_oindia.'\',\''.$pattribid.'\');" '.$chk.' value="'.$pattribid.'">&nbsp;'.$VALUE.'<br/>';

                }

				/*elseif($attrib_id=='18')

				{

					$view = '';

					$chk = '';

					$show = ' style="display:none"';

					if(empty($a_selected))

					{

						if($default=='Y')

						{

							$chk = 'checked="checked"';

							$show = ' style="display:"';

						}

					}

					else

					{

						if($pattribid==$a_selected)

						{

							$chk = 'checked="checked"';

							$show = ' style="display:"';

						}

					}

		

					$VALUE = (!empty($attribdat_id))?$attrib_datname[$attribdat_id]:$value;

					$str .= '<label for="rdattribute_'.$pattribid.'"><div class="color-bx" style="background-color:'.str_replace(' ','',$VALUE).';" onClick="GetProductPrice4(\'rdattribute_'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$pattribid.'\');"><input name="rdattribute" id="rdattribute_'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none"><img src="'.SITE_ADDRESS.'assets2/images/check.png" alt="check" class="color-selected rdattribute_'.$pattribid.'"'.$show.'/></div></label>';

				}*/

			}

		}

		

		$str .= '</div>';

		$str .= '<div class="clear"></div>';

	}

	

	return $str;

}



function GetProductAttribDetailsSize2020($prod_id, $a_selected, $SIZE_CHART='N')

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$attrib_datname = GetAttribDatName();



	$p_attstr = GetIDString('select iProdAttribID from product_attrib where iProdID='.$prod_id.' and fPrice=0');

	if($p_attstr)

		$cond .= ' and iProdAttribID NOT IN ('.$p_attstr.')';

	

	$att_str = GetIDString('select iAttribID from product_attrib_assoc where iProdID='.$prod_id.' order by iRank');

	

	$last = '';

	$q = 'select iProdAttribID, iAttribID, iAttribDatID, vValue, fPrice, fOPrice, cDefault from product_attrib where cStock="Y" and iAttribID="1" and iProdID='.$prod_id.$cond.' order by FIELD(iAttribID,'.$att_str.'), cDefault desc, fPrice';

	$r = sql_query($q, 'GPD.1196');

	if(sql_num_rows($r))

	{

		$i = 1;

		while(list($pattribid, $attrib_id, $attribdat_id, $value, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			if($last!=$attrib_id)

			{

				$str .= '<h2>Select '.$attrib_name[$attrib_id];

				if($SIZE_CHART=='Y')

				    $str .= '&nbsp;<a  href="#test-form" class="popup-size-form size-popup show1">Size Chart</a>';

				$str .= '</h2>';

				$last = $attrib_id;

			}

			

			$chk = $css = '';

			if(empty($a_selected))

			{

				if($default=='Y')

				{

					$chk = 'checked="checked"';

					$css = ' selected';

				}

			}

			else

			{

				if($a_selected==$pattribid)

				{

					$chk = 'checked="checked"';

					$css = ' selected';

				}

			}



			$labelTAG = '';

			$VALUE = (!empty($attribdat_id))?$attrib_datname[$attribdat_id]:$value;

			if(strpos($VALUE,'Kids - ') !== false)

			{

				$labelTAG = '<span class="kids-tag">Kids</span>';

				$VALUE = str_replace('Kids - ','',$VALUE);

			}



			if(strpos($VALUE,'Kids ') !== false)

			{

				$labelTAG = '<span class="kids-tag">Kids</span>';

				$VALUE = str_replace('Kids ','',$VALUE);

			}

			

			$str .= '<label for="rdattribute_'.$pattribid.'"><div class="size-bx'.$css.'" name="rdattribute_'.$pattribid.'">'.$labelTAG.'<input name="rdattribute" id="rdattribute_'.$pattribid.'" type="radio" onclick="GetProductPrice2(\''.$price_india.'\',\''.$price_oindia.'\',\''.$pattribid.'\');" '.$chk.' value="'.$pattribid.'" style="display:none;">'.$VALUE.'</div></label>';

		}

		

		$str .= '<div class="clear"></div>';

	}

	

	return $str;

}



function GetProductAttribDetailsColor2020($prod_id, $c_selected, $a_selected)

{

	$str = $cond = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$color_name = GetXArrFromYID('select iColorID, vColor from color', '3');

	$attrib_datname = GetAttribDatName();



	if(!empty($c_selected))

	{

		$cCOUNT = GetXFromYID('select count(*) from product_color_assoc where cStatus="A" and iProdID='.$prod_id.' and iProdAttribID='.$a_selected.' and iPCID='.$c_selected);

		if(empty($cCOUNT) || $cCOUNT=='-1')

			$c_selected = 0;

	}



	$last = '';

	$q = 'select iPCID, iColorID, fPrice, fOPrice, cDefault from product_color_assoc where cStatus="A" and iProdID='.$prod_id.' and iProdAttribID='.$a_selected.' order by cDefault desc';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	

	if($count)

	{

		$i = 1;

		$str .= '<h6>Select Color</h6>';

		while(list($pattribid, $color_id, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			$viewSML = $viewBIG = $viewTITLE = '';

			$_ciq = 'select vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$prod_id.' and iPCID='.$pattribid.' order by cDefault desc';

			$_cir = sql_query($_ciq,'PCA.27');

			if(sql_num_rows($_cir))

			{

				while(list($title,$c_pic) = sql_fetch_row($_cir))

				{

					if(IsExistFile($c_pic,PRODUCT_COLOR_IMAGE_UPLOAD) && empty($viewSML) && empty($viewBIG) && empty($viewTITLE))

					{

						$viewSML = PRODUCT_COLOR_IMAGE_PATH.'sml_'.$c_pic;

						$viewBIG = PRODUCT_COLOR_IMAGE_PATH.$c_pic;

						$viewTITLE = $title;

					}

				}

			}

			

			$view = '';

			$chk = '';

			$show = ' style="display:none"';

			if(empty($c_selected))

			{

				if($default=='Y')

				{

					$chk = 'checked="checked"';

					$show = ' style="display:"';

				}

			}

			else

			{

				if($pattribid==$c_selected)

				{

					$chk = 'checked="checked"';

					$show = ' style="display:"';

				}

			}



			$str .= '<label for="txtcolor_'.$pattribid.'"><div class="color-bx" style="background:'.$color_name[$color_id].';" onClick="GetColorSelected(\'txtcolor'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$viewSML.'\',\''.$viewBIG.'\',\''.$viewTITLE.'\',\''.$pattribid.'\',\''.$a_selected.'\');"><input name="txtcolor" id="txtcolor'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none"><img src="'.SITE_ADDRESS.'assets2/images/check.png" alt="check" class="color-selected txtcolor'.$pattribid.'"'.$show.'/></div></label>';

			

			//$str .= '<label for="txtcolor_'.$pattribid.'"><h3 style="background:'.$color_name[$color_id].'; '.$border.'"  onclick="GetColorSelected(\'txtcolor'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$viewSML.'\',\''.$viewBIG.'\',\''.$viewTITLE.'\');" ><input name="txtcolor" id="txtcolor'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none"><img src="'.SITE_ADDRESS.'images/'.$img.'" class="'.$css.' txtcolor'.$pattribid.'" '.$show.'/></h3></label>';

		}

		

		$str .= '<div class="clear"></div>';

	}

	

	return $str;

}



function GetProductAttribDetailsColors2020($prod_id, $c_selected, $a_selected)

{

	$str = $cond = $SELECTED_COLOR = '';

	$attrib_name = GetXArrFromYID('select iAttribID, vName from attribute', '3');

	$color_name = GetXArrFromYID('select iColorID, vColor from color', '3');

	$attrib_datname = GetAttribDatName();



	if(!empty($c_selected))

	{

		$cCOUNT = GetXFromYID('select count(*) from product_color_assoc where cStatus="A" and iProdID='.$prod_id.' and iProdAttribID='.$a_selected.' and iPCID='.$c_selected);

		if(empty($cCOUNT) || $cCOUNT=='-1')

			$c_selected = 0;

	}



	$last = '';

	$q = 'select iPCID, iColorID, fPrice, fOPrice, cDefault from product_color_assoc where cStatus="A" and iProdID='.$prod_id.' and iProdAttribID='.$a_selected.' order by cDefault desc';

	$r = sql_query($q, 'GPD.1196');

	$count = sql_num_rows($r);

	if($count)

	{

		$i = 1;

		$str .= '<h6>Select Color</h6>';

		while(list($pattribid, $color_id, $price_india, $price_oindia, $default) = sql_fetch_row($r))

		{

			$viewSML = $viewBIG = $viewTITLE = '';

			$_ciq = 'select vTitle, vPic from product_color_image_assoc where cStatus="A" and iProdID='.$prod_id.' and iPCID='.$pattribid.' order by cDefault desc';

			$_cir = sql_query($_ciq,'PCA.27');

			if(sql_num_rows($_cir))

			{

				while(list($title,$c_pic) = sql_fetch_row($_cir))

				{

					if(IsExistFile($c_pic,PRODUCT_COLOR_IMAGE_UPLOAD) && empty($viewSML) && empty($viewBIG) && empty($viewTITLE))

					{

						$viewSML = PRODUCT_COLOR_IMAGE_PATH.'sml_'.$c_pic;

						$viewBIG = PRODUCT_COLOR_IMAGE_PATH.$c_pic;

						$viewTITLE = $title;

					}

				}

			}

			

			$view = '';

			$chk = '';

			$show = ' style="display:none"';

			if(empty($c_selected))

			{

				if($default=='Y')

				{

					$chk = 'checked="checked"';

					$show = ' style="display:"';

					$SELECTED_COLOR = $pattribid;

				}

			}

			else

			{

				if($pattribid==$c_selected)

				{

					$chk = 'checked="checked"';

					$show = ' style="display:"';

					$SELECTED_COLOR = $pattribid;

				}

			}



			$str .= '<label for="txtcolor_'.$pattribid.'"><div class="color-bx" style="background:'.$color_name[$color_id].';" onClick="GetColorSelected(\'txtcolor'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$viewSML.'\',\''.$viewBIG.'\',\''.$viewTITLE.'\',\''.$pattribid.'\',\''.$a_selected.'\');"><input name="txtcolor" id="txtcolor'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none"><img src="'.SITE_ADDRESS.'assets2/images/check.png" alt="check" class="color-selected txtcolor'.$pattribid.'"'.$show.'/></div></label>';

			

			//$str .= '<label for="txtcolor_'.$pattribid.'"><h3 style="background:'.$color_name[$color_id].'; '.$border.'"  onclick="GetColorSelected(\'txtcolor'.$pattribid.'\',\''.$price_india.'\',\''.$price_oindia.'\',\''.$viewSML.'\',\''.$viewBIG.'\',\''.$viewTITLE.'\');" ><input name="txtcolor" id="txtcolor'.$pattribid.'" type="radio" '.$chk.' value="'.$pattribid.'" style="display:none"><img src="'.SITE_ADDRESS.'images/'.$img.'" class="'.$css.' txtcolor'.$pattribid.'" '.$show.'/></h3></label>';

		}

	}



    $str .= '<div class="clear"></div>';

	

	return $str.'~**~'.$SELECTED_COLOR;

}



function IsValidFile($file_type, $extension, $type, $size=false, $max_file_size=false)

{

	global $IMG_TYPE, $DOC_TYPE, $IMG_FILE_TYPE, $DOC_FILE_TYPE;



	$str = false;



	if($type=='P')

	{

		if(in_array($extension,$IMG_TYPE))

			$str = true;

	}

	elseif($type=='D')

	{

		if(in_array($extension,$DOC_TYPE))

			$str = true;

	}



	return $str;

}



function GetBlueDartShippingCharge2020($pData,$colorDATA)

{

	$p_str = $str = '';

	$total_shipping_cost = '0';

	

	$q2 = 'select fMinWeight, fPricePerWeight, fAdditionalWeight, fAdditionalPrice, fFuelSurchargePercentage, fCAFPercentage, fAWBAmount, fInsuracePercentage, fSTPercentage from bluedart_settings';

	$r2 = sql_query($q2,'GBDSC.1385');

	list($txtMinWeight, $txtPricePerWeight, $txtAddWeight, $txtAddAmount, $txtFuelSurchargePercentage, $txtCAFPercentage, $txtAWBAmount, $txtInsuracePercentage, $txtSTPercentage) = sql_fetch_row($r2);



	$CART_ARR = $CART_CAT_ARR = $CART_ALLOWED_ARR = array();

	$prod_id_arr2 = array_keys($pData);					

	

	foreach($prod_id_arr2 as $KEY=>$prod_id2)

	{

		list($id,$attrib_id,$color_id) = explode("~~**~~",$prod_id2);

		if(empty($id))

			continue;



		$print_id = $attrib_id;

		$prod_qty = $pData[$prod_id2];



		$_pq = 'select fPrice, fOPrice, iPCatID, fActualWeight, fVolumetricWeight from product where iProdID='.$id;

		$_pr = sql_query($_pq,'G.P.R.286');

		list($price,$oprice,$pc_id,$prod_aweight,$prod_vweight) = sql_fetch_row($_pr);



		$priceARR = GetProductFlashSalePrice($id);

		if(isset($priceARR[$id]) && !empty($priceARR[$id]))

		{

			$oprice = $priceARR[$id]['SALE_PRICE'];

			$price = $priceARR[$id]['ACTUAL_PRICE'];

		}

				

		$_pq2 = 'select cShippingPriceIndia, cShippingPricePerItem, iParentID, cGroupItemForShipping from prodcat where iPCatID='.$pc_id;

		$_pr2 = sql_query($_pq2,'G.P.R.2195');

		list($pShipping,$pShippingPerItem,$pParentID,$pGroupItemForShipping) = sql_fetch_row($_pr2);

		

		if(!empty($pParentID))

		{

			$getAncsetorDet = GetAncestorDetail($pParentID);

			if(!empty($getAncsetorDet))

			{

				$getAncsetorDet2 = explode('~',$getAncsetorDet);

				$ancestor_id = $getAncsetorDet2[0];

				$pGroupItemForShipping = $getAncsetorDet2[1];

			}

			else

				$ancestor_id = $pc_id;

		}

		else

			$ancestor_id = $pc_id;

		

		//$pShipping = GetXFromYID('select cShippingPriceIndia from prodcat where iPCatID='.$pc_id);

		if($pShipping=='Y')

		{

			$prod_weight = ($prod_aweight>=$prod_vweight)?$prod_aweight:$prod_vweight;

			if($pShippingPerItem=='Y')

				$prod_weight = $prod_weight * $prod_qty;

			else

				$prod_weight = $prod_weight * 1;

			

			$prod_rate = $price;

			if(!empty($oprice))

				$prod_rate = $oprice;

	

			if(!empty($print_id))

			{

				$_q = 'select fPrice, fOPrice from product_attrib where iProdID='.$id.' and iProdAttribID='.$print_id;

				$_r = sql_query($_q,'G.P.R.297');

				list($price,$oprice) = sql_fetch_row($_r);

				

				$prod_rate = $price;

				if(!empty($oprice))

					$prod_rate = $oprice;

			}



			if(!empty($color_id))

			{

				$color_id = $color_id;

				$_cq = 'select fPrice, fOPrice from product_color_assoc where iPCID='.$color_id.' and iProdAttribID='.$print_id.' and cStatus="A"';

				$_cr = sql_query($_cq,'G.P.S.C.R.297');

				if(sql_num_rows($_cr))

				{

					list($price,$oprice) = sql_fetch_row($_cr);

					

					if(!empty($price))

					{

						$prod_rate = $price;

						if(!empty($oprice))

							$prod_rate = $oprice;

					}

				}

			}	 	

			

			if($pGroupItemForShipping=='Y')

			{

				if(!isset($CART_ALLOWED_ARR[$ancestor_id]))

					$CART_ALLOWED_ARR[$ancestor_id] = 'Y';

				else

					continue;	

			}

			

			$CART_ARR[] = array('CID'=>$pc_id, 'ID'=>$id[0], 'PRICE'=>$prod_rate, 'WEIGHT'=>$prod_weight);

		}

	}



	if(count($CART_ARR))

	{

		$CART_TEMP_ARR = array();

		foreach($CART_ARR as $key => $item)

		{

		   $CART_TEMP_ARR[$item['CID']][$key] = $item;

		}

		ksort($CART_TEMP_ARR, SORT_NUMERIC);

		

		foreach($CART_TEMP_ARR as $rKEY=>$rARRAY)		

		{

			$prod_rate = $prod_weight = '0';

			foreach($rARRAY as $rValue)

			{

				$prod_rate += $rValue['PRICE'];

				$prod_weight += $rValue['WEIGHT'];

			}

			

			if($txtMinWeight>=$prod_weight)



				$prod_weight = $txtMinWeight;

			

			$wValue = ceil($prod_weight/$txtMinWeight);

			if($wValue=='1')

				$ppAMount = $txtPricePerWeight;

			else

				$ppAMount = $txtPricePerWeight + (($wValue-1)*$txtAddAmount);

			

			$minChargeable_weight =  $ppAMount; //$prod_weight * $txtPricePerWeight;

			$fuelSurcharge = ($txtFuelSurchargePercentage * $minChargeable_weight)/100;

			$CAF = ($txtCAFPercentage * ($minChargeable_weight + $fuelSurcharge))/100;

			$AWB = $txtAWBAmount;

			$insurance = ($txtInsuracePercentage * $prod_rate)/100;

			$st = ($txtSTPercentage * ($minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance))/100; 

	

			$total = $minChargeable_weight + $fuelSurcharge + $CAF + $AWB + $insurance + $st;

			$total_shipping_cost = $total_shipping_cost + $total;

		}

	}

	

	$str = $total_shipping_cost;

	return $str;

}



function GetNewDiscountApplicability2020($txtcode,$total_amount)

{

	$DISC_APPLICABLE = 'N';

	$str = $str2 = '';

	

	$new_discount = $new_total = '';

	$q_d = "select * from disc_coupon where cStatus='A' and vCode ='".$txtcode."'";

	$r_d = sql_query($q_d,"PO-20");

	if(sql_num_rows($r_d))

	{

	    $o = sql_fetch_object($r_d);

		$txt_id = $o->iDiscCoupID;

		$disc_campid = $o->iDiscCompID;

		$txt_type = $o->cVType;

   	 	$txt_amt = $o->fValue;

		$disc_count = $o->iClaimCount;

		$disc_usage = $o->cUsageType;

		$min_purchase = $o->fMinPurchase;



		if($min_purchase<=$total_amount)

		{

			$q_c = 'select dtEnd, cType, cStatus from disc_campaign where iDiscCompID='.$disc_campid;

			$r_c = sql_query($q_c,'DISC_CAMP.31');

			list($dtend,$type,$status)=sql_fetch_row($r_c);



			if($type=='L')

			{

				if(($dtend < TODAY) && TODAY!=$dtend)

					$DISC_APPLICABLE = 'N';

			}

	

			if($disc_usage=='S')

			{

				if($disc_count>='1')

					$DISC_APPLICABLE = 'N';

			}

	

			if($txt_type=='R')

			{

				$new_discount = $txt_amt;

				$new_total = $total_amount - $txt_amt;

			}

			else if($txt_type=='P')

			{

				$new_discount = $total_amount / $txt_amt;

				$new_total = $total_amount - $new_discount;

			}

	

			$DISC_APPLICABLE = 'Y';

			$str2 = $txt_id.'~'.$new_discount.'~'.$txtcode;

		}

		else

			$DISC_APPLICABLE = 'N';

	}

	else

		$DISC_APPLICABLE = 'N';



	$str = $DISC_APPLICABLE.'~'.$str2;

	

	return $str;

}



function GetShowcaseDetails2020($IS_MOBILE='N')

{

	$str = '';

	$_SLIDEARR = array();



	$_sq = 'select iPicID, vPicTitle, vPic, vPic_AltTag, vMobilePic, vMobilePic_AltTag, vLink from showcase where cStatus="A" order by iRank';

	$_sr = sql_query($_sq,'S.S.DET.30');

	if(sql_num_rows($_sr))

	{

		while(list($_sid,$_stitle,$_spic,$_spic_alt,$_spic2,$_spic_alt2,$_slink) = sql_fetch_row($_sr))

		{

			if($IS_MOBILE=='Y')

			{

				if(IsExistFile($_spic2,SHOWCASE_UPLOAD))

				{

					$_SLIDEARR[$_sid]['ID'] = $_sid;

					$_SLIDEARR[$_sid]['TITLE'] = $_stitle;

					$_SLIDEARR[$_sid]['PIC'] = $_spic2;

                  	$_SLIDEARR[$_sid]['ALT'] = $_spic_alt2;

					$_SLIDEARR[$_sid]['LINK'] = $_slink;

				}

			}

			else

			{

				if(IsExistFile($_spic,SHOWCASE_UPLOAD))

				{

					$_SLIDEARR[$_sid]['ID'] = $_sid;

					$_SLIDEARR[$_sid]['TITLE'] = $_stitle;

					$_SLIDEARR[$_sid]['PIC'] = $_spic;
                  
					$_SLIDEARR[$_sid]['ALT'] = $_spic_alt;

					$_SLIDEARR[$_sid]['LINK'] = $_slink;

				}

			}

		}

	}



	if(!empty($_SLIDEARR) && count($_SLIDEARR))

	{

		$str .= '<div class="offer-slider-bx">';

		$str .= '<div class="owl-carousel offer-slider">';



		foreach($_SLIDEARR as $_SKEY=>$_SVALUE)

		{

			$HREF = ' style="cursor:pointer"';

			if(!empty($_SVALUE['LINK']))

				$HREF = ' href="'.$_SVALUE['LINK'].'" target="_blank"';
			
			$ALT = (!empty($_SVALUE['ALT']))?$_SVALUE['ALT']:$_SVALUE['TITLE'];

			$str .= '<div class="item"> <a'.$HREF.'> <img src="'.SHOWCASE_PATH.$_SVALUE['PIC'].'"  alt="'.$ALT.'" /></a></div>';

		}

		

		$str .= '</div>';

		$str .= '</div>';

	}

	

	return $str;

}



function GetOfferSections2020()

{

	$str = $str2 = '';

	$COLOR_ARR = GetXArrFromYID('select iColorID, vColor from color', '3');

	

	$FLASH_END = $blockCSS = '';

	$q = 'select iOSecID, cRefType, iRefID, vTitle, vLink, iColorID from offers_section where cStatus="A" order by iRank';

	$r = sql_query($q,'');

	if(sql_num_rows($r))

	{

		$blockCSS = (sql_num_rows($r)=='1')?' one-offer':'';

		while(list($ID,$REFTYPE,$REFID,$TITLE,$LINK,$COLOR_ID) = sql_fetch_row($r))

		{

			$bgCOLOR = (!empty($COLOR_ID))?$COLOR_ARR[$COLOR_ID]:'';

		

			if($REFTYPE=='F')

			{

				$q2 = 'select iFID, vName, dtStart, dtEnd, iColorID from flash where cStatus="A" and dtEnd>"'.NOW.'" and iFID='.$REFID.' order by dtStart';

				$r2 = sql_query($q2,'');

				if(sql_num_rows($r2))

				{

					while(list($id,$name,$start,$end,$color_id) = sql_fetch_row($r2))

					{

						$bgCOLOR = (!empty($color_id))?$COLOR_ARR[$color_id]:$bgCOLOR;

			

						if(URL_REWRITTING=='ON')

							$URL_FLASH = GetURL($id,'0','0','F');

						else

							$URL_FLASH = SITE_ADDRESS.'flashsale.php?f_id='.$id;



						$str2 .= '<div class="offer-bx" style="background:'.$bgCOLOR.' !important">';

						$str2 .= '<div class="align-cneter">';

						$str2 .= '<h6>'.$name.'</h6>';

						$str2 .= '<p>'.str_replace('  ','&nbsp;&nbsp;',FormatDate($start,'G')).'</p>';

						if($start>NOW)

							$str2 .= '<p class="c-soon">Coming Soon</p>';

						else

						{

							$diff = abs(strtotime($end) - strtotime(NOW)); 

							$years   = floor($diff / (365*60*60*24)); 

							$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 

							$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

							$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

							$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

							$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

						

							$str2 .= '<div id="timer">';

							$str2 .= '<div id="hours" class="ti-mer ti-mer-time">'.$hours.'<span>Hours</span></div>';

							$str2 .= '<div id="colon1" class="ti-mer">:</div>';

							$str2 .= '<div id="minutes" class="ti-mer ti-mer-time">'.$minuts.'<span>Min</span></div>';

							$str2 .= '<div id="colon1" class="ti-mer">:</div>';

							$str2 .= '<div id="seconds" class="ti-mer ti-mer-time">'.$seconds.'<span>Sec</span></div>';

							$str2 .= '<div class="clear"></div>';

							$str2 .= '</div>';



							$FLASH_END = $end;

						}

						$str2 .= '</div>';

						$str2 .= '</div>';

					}

				}

			}

			

			if($REFTYPE=='C')

			{

				$_cq = 'select c.vName, c2.vCode from disc_campaign as c join disc_coupon as c2 on c.iDiscCompID=c2.iDiscCompID where iDiscCoupID='.$REFID;

				$_cr = sql_query($_cq,'');

				if(sql_num_rows($_cr))

				{

					list($x_name2,$x_code) = sql_fetch_row($_cr);



					$str2 .= '<div class="offer-bx" style="background:'.$bgCOLOR.' !important">';

					$str2 .= '<div class="align-cneter">';

					$str2 .= '<h6>'.$x_name2.'</h6>';

					if(!empty($x_code))

						$str2 .= '<p>Use Code <span>'.$x_code.'</span></p>';

					$str2 .= '</div>';

					$str2 .= '</div>';

				}

			}

			

			if($REFTYPE=='N')

			{

				if(!empty($TITLE))

				{

					$str2 .= '<div class="offer-bx" style="background:'.$bgCOLOR.' !important">';

					$str2 .= '<div class="align-cneter">';

					$str2 .= '<h6>'.$TITLE.'</h6>';

					$str2 .= '</div>';

					$str2 .= '</div>';

				}

			}

		}

	}

	

	if(!empty($str2))

	{

		$str .= '<div class="swiper-container">';

		$str .= '<div class="offer-list-bx'.$blockCSS.'">';

		$str .= $str2;

		$str .= '<div class="clear"></div>';

		$str .= '</div>';

		$str .= '</div>';

	}

	

	return $str.'~~**~~'.$FLASH_END;

}



function GetPageSections2020()

{

	$HP_ARR = array();

	$q = 'select h.iHPSecID, h.vName, h.vUrlName, h2.iProdID from homepage_section as h join homepage_section_dat as h2 on h.iHPSecID=h2.iHPSecID where h.cStatus="A" order by iRank';

	$r = sql_query($q,'');

	if(sql_num_rows($r))

	{

		while(list($ID,$NAME,$URL,$PRODID) = sql_fetch_row($r))

		{

			if(!isset($HP_ARR[$ID]))

			{

				$HP_URL = (URL_REWRITTING=='ON')?GetURL2020($ID,$URL,0,'','HP'):SITE_ADDRESS.'sections.php?id='.$ID;

				$HP_ARR[$ID] = array('NAME'=>htmlspecialchars_decode($NAME), 'URL'=>$HP_URL, 'PROD_ID'=>array(), 'PROD_DET'=>array());

			}

			array_push($HP_ARR[$ID]['PROD_ID'],$PRODID);

		}

	}



	if(!empty($HP_ARR) && count($HP_ARR))

	{

		foreach($HP_ARR as $hKEY=>$hVALUE)

		{

			if(!empty($hVALUE['PROD_ID']) && count($hVALUE['PROD_ID']))

			{

				$pSTR = implode(',',$hVALUE['PROD_ID']);

				if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



				$_pq = 'select p.iProdID, p.iPCatID, pc.vUrlName, p.vName, p.vUrlName, p.fPrice, p.fOPrice, p.vSmallImage, p.vSmallImage_AltTag, p.vImage, p.vImage_AltTag, p.iStockQty, p.iSold, p.iResaleQty, p.cSoldOut, p.cLatest, p.cBestSeller from product as p join prodcat as pc on p.iPCatID=pc.iPCatID where iProdID IN ('.$pSTR.') and p.cStatus="A"';

				$_pr = sql_query($_pq, 'GGCC.963');

				if(sql_num_rows($_pr))

				{
                    
					while(list($PROD_ID,$PROC_CAT,$PROD_CATURL,$PROD_NAME,$PROD_URL,$PROD_PRICE,$PROD_OPRICE,$PROD_SIMAGE,$PROD_SIMAGE_ALT,$PROD_IMAGE,$PROD_IMAGE_ALT,$PROD_STOCKQTY,$PROD_SOLD,$PROD_RESALE,$PROD_SOLDOUT,$PROD_NEW,$PROD_BESTSELLER) = sql_fetch_row($_pr))

					{

 
						$URL_PC = (URL_REWRITTING=='ON')?GetURL2020($PROC_CAT,$PROD_CATURL,$PROD_ID,$PROD_URL,'P'):SITE_ADDRESS.'details.php?prod_id='.$PROD_ID;

						

						$DISC_TEXT = '';

						if(!empty($PROD_OPRICE)) $DISC_TEXT = 'Discounted';

						

						if(isset($priceARR[$PROD_ID]) && !empty($priceARR[$PROD_ID]))

						{

							$PROD_OPRICE = $priceARR[$PROD_ID]['SALE_PRICE'];

							$PROD_PRICE = $priceARR[$PROD_ID]['ACTUAL_PRICE'];

							

							$DISC_TEXT = 'Flash Sale';

						}

						

						$IMAGE = '';

						if(IsExistFile('sml_'.$PROD_SIMAGE,PRODUCT_UPLOAD))

							$IMAGE = PRODUCT_PATH.'sml_'.$PROD_SIMAGE;
						
						$IMAGE_ALT = (!empty($PROD_SIMAGE_ALT))?$PROD_SIMAGE_ALT:$PROD_NAME;


						$chkidsearch = GetXArrFromYID('select iPCatID from prodcat where iParentID=4');

						$PROD_SOLDVALUE = '';

						if($PROC_CAT==4 || in_array($PROC_CAT,$chkidsearch))

						{

							if($PROD_SOLDQTY>=$PROD_SQTY)

							{

								$PROD_SOLDVALUE .= 'Sold Out '.$PROD_SQTY.'/'.$PROD_SQTY.'';

							

								if($PROD_RESALE!='' && $PROD_RESALE!='0')

								{

									$PROD_SOLDVALUE .= ', '.$PROD_RESALE.' on Resale,<br/>';

									$PROD_SOLDVALUE .= 'Sold '.($PROD_SOLDQTY-$PROD_SQTY).' of '.$PROD_RESALE;

								}	

							}

							else

								$PROD_SOLDVALUE .= 'Sold '.$PROD_SOLDQTY.' of '.$PROD_SQTY;

						}



						array_push($HP_ARR[$hKEY]['PROD_DET'],array('PROD_ID'=>$PROD_ID, 'NAME'=>htmlspecialchars_decode($PROD_NAME), 'URL'=>$URL_PC, 'IMAGE'=>$IMAGE, 'IMAGE_ALT'=>htmlspecialchars_decode($IMAGE_ALT), 'PRICE'=>$PROD_PRICE, 'OPRICE'=>$PROD_OPRICE, 'PROD_STOCKQTY'=>$PROD_STOCKQTY, 'PROD_SOLD'=>$PROD_SOLD, 'PROD_RESALE'=>$PROD_RESALE, 'PROD_SOLDOUT'=>$PROD_SOLDOUT, 'PROD_NEW'=>$PROD_NEW, 'PROD_BESTSELLER'=>$PROD_BESTSELLER, 'DISC_TEXT'=>$DISC_TEXT));

					}

				}

			}

		}

	}



	return $HP_ARR;

}



function GetDailyCartoon2020()

{

	$arr = array();

	$q = 'select vTitle, vPic, vPic_AltTag from daily_cartoon where cStatus="A" order by dDisplay desc';

	$r = sql_query($q,'GDC.1548');

	

	if(sql_num_rows($r))

	{

		while(list($vTitle, $dc_pic, $dc_pic_alt) = sql_fetch_row($r))

		{

			
			$alt = (!empty($dc_pic_alt))?$dc_pic_alt:$vTitle;
			if(IsExistFile($dc_pic,CARTOON_UPLOAD))

				array_push($arr,$vTitle.'~~**~~'.CARTOON_PATH.$dc_pic.'~~**~~'.$alt);

		}

	}



	return $arr;

}



function GetMoreProducts2020($cat_id,$p_id)

{

	$str = '';

	$cat_url = strtoupper(GetXFromYID('select vUrlName from prodcat where iPCatID='.$cat_id));



	$priceARR = array();

	$pSTR = GetIDString('select iProdID from product where iPCatID='.$cat_id.' and iProdID!='.$p_id.' and cStatus="A" limit 10');

	if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



	$CAT_URL = (URL_REWRITTING=='ON')?GetURL2020($cat_id,$cat_url,'0','','PC'):SITE_ADDRESS.'listing.php?cat_id='.$cat_id;



	$q = 'select iProdID, vName, vUrlName, fOPrice, fPrice, vSmallImage, vSmallImage_AltTag, vImage, vImage_AltTag, iStockQty, iSold, iResaleQty, cSoldOut, cLatest, cBestSeller from product where iPCatID='.$cat_id.' and iProdID!='.$p_id.' and cStatus="A" limit 10';

	$r = sql_query($q, 'GGCC.963');



	$k = 1;

	if(sql_num_rows($r))

	{

		$str .= '<div class="wapper section-gap" id="product-range-section-two">';

		$str .= '<div class="container">';

		$str .= '<h1>YOU MAY ALSO LIKE</h1>';

		$str .= '<div class="owl-carousel product-slider gallery-slider">';

		

		for($i=1;$o=sql_fetch_object($r);$i++)

		{

			$p_id = $o->iProdID;

			$p_name = $o->vName;

			$p_url = $o->vUrlName;

			$p_offerprice = $o->fOPrice;

			$p_price = $o->fPrice;

			$p_smallpic = $o->vSmallImage;
			$p_smallpic_alt = $o->vSmallImage_AltTag;
			$p_pic = $o->vImage;
			$p_pic_alt = $o->vImage_AltTag;

			$prod_stockqty = $o->iStockQty;

			$prod_sold = $o->iSold;

			$prod_resaleqty = $o->iResaleQty;

			$prod_soldout = $o->cSoldOut;
			$product_new = $o->cLatest;
			$product_bestseller = $o->cBestSeller;



			$URL_BP = (URL_REWRITTING=='ON')?GetURL2020($cat_id,$cat_url,$p_id,$p_url,'P'):SITE_ADDRESS.'details.php?prod_id='.$p_id;

			$ALT = (!empty($p_smallpic_alt))?$p_smallpic_alt:$p_name;

			$str .= '<div class="item">';

			$str .= '<div class="range-product-bx"> <a href="'.$URL_BP.'">';
          
			$IMAGE =  SITE_ADDRESS.'assets2/images/pl-1.jpg';
			if(IsExistFile('sml_'.$p_smallpic,PRODUCT_UPLOAD))
				$IMAGE = PRODUCT_PATH.'sml_'.$p_smallpic;

				$str .= '<div class="r-pro-img">';
                if($prod_soldout=='Y')
                    $str .= '<p class="sold">Sold</p>';
                if($product_new=='Y')
                    $str .= '<p class="stock-new">New</p>';
                if($product_bestseller=='Y')
                    $str .= '<p class="bestseller">Best Seller</p>';
                $str .= '<img src="'.$IMAGE.'" alt="'.htmlspecialchars_decode($ALT).'">';
          		$str .= '</div>';

			$str .= '<h5>'.$p_name.'</h5>';

			

			$flash_str = 'Discounted';

			if(isset($priceARR[$p_id]) && !empty($priceARR[$p_id]))

			{

				$prod_offerprice = $priceARR[$p_id]['SALE_PRICE'];

				$prod_price = $priceARR[$p_id]['ACTUAL_PRICE'];

				$flash_str = 'Flash Sale';

			}

			

			if(!empty($p_offerprice))

				$str .= '<p><span class="price"><b>&#x20B9;</b>'.FormatNumber($p_price,'0','ind').'</span> <span class="offer-price"><b>&#x20B9;</b>'.FormatNumber($p_offerprice,'0','ind').'</span> '.$flash_str.'</p>';

			else

				$str .= '<p><span class="offer-price"><b>&#x20B9;</b>'.FormatNumber($p_price,'0','ind').'</span></p>';

			$str .= '</a> </div>';

			$str .= '</div>';

			

		}

		

		$str .= '</div>';

		$str .= '<div class="btn-box"> <a target="_blank" href="'.$CAT_URL.'">View More</a> </div>';

		$str .= '</div>';

		$str .= '</div>';

	}

		

	return $str;

}



function GetAssociatedProductDetails2020($p_id,$cart_data)

{

	$str = '';

	

	$p_str = GetIDString('select iPCID from product_assoc where iPPID='.$p_id.' order by iRank');

	if($p_str!='' && $p_str!='0')

	{

		$priceARR = array();

		$pSTR = GetIDString('select iProdID from product where cStatus="A" and iProdID IN ('.$p_str.')');

		if(!empty($pSTR) && $pSTR!='-1') $priceARR = GetProductFlashSalePrice($pSTR);



		$q = 'select iPCatID, iProdID, vName, vSmallImage, vSmallImage_AltTag, vImage, vImage_AltTag, fPrice, fOPrice, iStockQty, iSold, iResaleQty from product where cStatus="A" and iProdID IN ('.$p_str.') order by FIELD(iProdID,'.$p_str.')';

		$r = sql_query($q,'BROWSE_147');

		$count = sql_num_rows($r);

		

		if($count)

		{ 

			$str .= '<div class="individual-product">';

			while(list($cat,$prod_id,$prod_name,$prod_smallimg,$prod_smallimg_alt,$prod_img,$prod_img_alt,$prod_price,$prod_offerprice,$prod_stockqty,$prod_sold,$prod_resaleqty)=sql_fetch_row($r))

			{

				$cartQtyCOUNT = 0;

				if(!empty($cart_data))

				{

					foreach($cart_data as $key=>$value)

					{

						list($item_id,$item_attrib,$item_colour) = explode('~~**~~',$key);

						if($item_id==$prod_id)

						{

							$cartQtyCOUNT = $cartQtyCOUNT + $value;

				

							if(!empty($item_attrib))

							{

								$a_selected = $item_attrib;

								$_q = 'select fPrice, fOPrice from product_attrib where iProdID='.$prod_id.' and iProdAttribID='.$a_selected;

								$_r = sql_query($_q,'G.P.R.297');

								if(sql_num_rows($_r))

									list($prod_price,$prod_offerprice) = sql_fetch_row($_r);

							}

						

							if(!empty($item_colour))

							{

								$c_selected = $item_colour;

								$_cq = 'select fPrice, fOPrice from product_color_assoc where iPCID='.$c_selected.' and iProdAttribID='.$a_selected.' and cStatus="A"';

								$_cr = sql_query($_cq,'G.P.S.C.R.297');

								if(sql_num_rows($_cr))

									list($prod_price,$prod_offerprice) = sql_fetch_row($_cr);

							}

							

							break;

						}

					}

				}



				$flash_str = 'Discounted';

				$prod_name = htmlspecialchars_decode($prod_name);

				if(isset($priceARR[$prod_id]) && !empty($priceARR[$prod_id]))

				{

					$prod_offerprice = $priceARR[$prod_id]['SALE_PRICE'];

					$prod_price = $priceARR[$prod_id]['ACTUAL_PRICE'];

					$flash_str = 'Flash Sale';

				}
				
				$alt = (!empty($prod_smallimg_alt))?$prod_smallimg_alt:$prod_name;
				

				$str .= '<div class="single-item">';

				if(IsExistFile('sml_'.$prod_smallimg,PRODUCT_UPLOAD))

					$str .= '<div class="one-side"><img src="'.PRODUCT_PATH.'sml_'.$prod_smallimg.'" alt="'.$alt.'"></div>';

				$str .= '<div class="one-side right">';

				$str .= '<h2>'.$prod_name.'</h2>';

				if(!empty($prod_offerprice))

				{

					$str .= '<p><span class="price"><b>&#x20B9;</b>'.$prod_price.'</p>';

					$str .= '<p><span class="red-1"><b>&#x20B9;</b>'.$prod_offerprice.$flash_str.'</span></p>';

				}

				else

					$str .= '<p><span class="red-1"><b>&#x20B9;</b>'.$prod_price.'</span></p>';

				

				$displayADD = 'none';

				$displayUPDATE = '';

				if(empty($cartQtyCOUNT))

				{

					$displayADD = '';

					$displayUPDATE = 'none';

				}

				

				$str .= '<div id="ADDTOCART_DIV_'.$prod_id.'">';

				$str .= '<input type="hidden" name="quantity_'.$prod_id.'" id="quantity_'.$prod_id.'" value="'.$cartQtyCOUNT.'" style="display:block;"/>';

				$str .= '<div class="d-btn-box1" style="display:'.$displayADD.'; cursor:pointer;" id="CARTADDDIV_'.$prod_id.'"><a class="cart-btn" onClick="ADDTOCART2(\''.$prod_id.'\',\'1\');">ADD TO CART</a></div>';

				$str .= '<div class="d-btn-box1" style="display:'.$displayUPDATE.'" id="CARTUPDATEDIV_'.$prod_id.'"><div class="add-to-btn"><button class="min" onClick="UpdateCartCount2('.$prod_id.',\'-\');"> - </button><span id="cartQtyCOUNT_'.$prod_id.'"> '.$cartQtyCOUNT.' </span><button class="plus" onClick="UpdateCartCount2('.$prod_id.',\'+\');"> + </button><div class="clear"></div></div></div>';

				$str .= '</div>';

								

				$str .= '</div>';

				$str .= '<div class="clear"></div>';

				$str .= '</div>';

			}

			$str .= '</div>';

		}

	}

	return $str;

}



function DateDiff($date1, $date2, $mode='1')

{

	list($yr1, $mnt1, $day1) = explode('-', $date1);

	$xx=gmmktime ( 0, 0, 0, $mnt1,$day1,$yr1);

		

	list($yr2, $mnt2, $day2) = explode('-', $date2);	

	$xy = gmmktime(0, 0, 0, $mnt2, $day2, $yr2);

	

	$diff=$xy-$xx;

	$min=$diff/60;

	$hr=$min/60;

	$day=$hr/24;

	

	if($mode == '2')

	{

		$month_arr = array(1=>31, 2=>28, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);

		$y = $yr2 - $yr1;

		$m = $mnt2 - $mnt1;

		

		if($m < 0)

		{

			$m = 12 + $m;

			$y -= 1;

		}

			

		$d = $day2 - $day1;

		

		if($d < 0)

		{

			$mnt1 = ltrim($mnt1, '0');



			$_adj = $month_arr[$mnt1];			

			if($mnt1==2 && IsLeapYear($y1)) // if start month is Feb and is a Leap Year

				$_adj += 1;

			

			$d = $_adj + $d;			

			$m -= 1;

		}

	

		$y_txt = ($y)? ($y>1)? $y . " yr ": "1 yr ": "";

		$m_txt = ($m)? ($m>1)? $m . " mnths ": "1 mnth ": "";

		$d_txt = ($d)? ($d>1)? $d . " days ": "1 day ": "";

		

		if($y_txt != '')

			$m_txt = "," . $m_txt;

			

		if($m_txt != '')

			$d_txt = "," . $d_txt;



		

		$ret_val = $y_txt . $m_txt . $d_txt;

	}

	else

		$ret_val = $day;

		

	return $ret_val;

}



function RefreshInstaAccessToken($accessTOKEN)

{

  	$newACCESSTOKEN = '';

  

	$json_feed_url="https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=$accessTOKEN";

	$json_feed = @file_get_contents($json_feed_url);

	$contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);



  	if(!empty($contents) && count($contents))

    {

    	$newACCESSTOKEN = $contents['access_token'];

    	$EXPIRY_IN_SECS = $contents['expires_in'];

      

      	$DAYS = round($EXPIRY_IN_SECS/(60*60*24))-1;

      	$EXPIRY_DATE = DateTimeAdd(TODAY, $DAYS, 0, 0, 0, 0, 0, "Y-m-d");

      

      	$_uq = "update instagram_app set vAccessToken='$newACCESSTOKEN', dExpiry='$EXPIRY_DATE'";

      	$_ur = sql_query($_uq,'');

    }

  

  	return $newACCESSTOKEN;

}



function GetInstaAccountMedia2020()

{	

	$arr = array();

	

	$_iq = 'select vInstagramAppID, vInstagramAppSecret, vAccessToken, dExpiry from instagram_app';

	$_ir = sql_query($_iq,'');

	list($APP_ID,$APP_SECRET,$ACCESS_TOKEN,$EXPIRY) = sql_fetch_row($_ir);

	

  	$NEW_ACCESS_TOKEN = '';

	$daysLEFT = DateDiff(TODAY,$EXPIRY);

	if($daysLEFT<5)

		$NEW_ACCESS_TOKEN = RefreshInstaAccessToken($ACCESS_TOKEN);



  	if(!empty($NEW_ACCESS_TOKEN)) $ACCESS_TOKEN = $NEW_ACCESS_TOKEN;

  

	$fields = "id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";

	$token = $ACCESS_TOKEN;

	$limit = 10;

	 

	$json_feed_url="https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";

	$json_feed = @file_get_contents($json_feed_url);

	$contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);

	

	if(!empty($contents["data"]) && count($contents["data"])) 

	{

		foreach($contents["data"] as $post)

		{

			$username = (isset($post["username"]))? $post["username"]:"";

			$caption = (isset($post["caption"]))? $post["caption"]:"";

			$media_url = (isset($post["media_url"]))? $post["media_url"]:"";

			$permalink = (isset($post["permalink"]))? $post["permalink"]:"";

			$media_type = (isset($post["media_type"]))? $post["media_type"]:"";

			

			$arr[] = array('USERNAME'=>$username, 'CAPTION'=>$caption, 'MEDIA_URL'=>$media_url, 'PERMALINK'=>$permalink, 'MEDAI_TYPE'=>$media_type);

		}

	}

	

	return $arr;

}



function GetCategoryTagList2020($cID)

{

	$arr = array();

	

	$cSTR = GetIDString('select iPCatID from prodcat where iParentID='.$cID);

	if(!empty($cSTR) && $cSTR!='-1') $cond = ' and p.iPCatID IN ('.$cID.','.$cSTR.')';

	else $cond = ' and p.iPCatID='.$cID;

	

	$tSTR = GetIDString('select t.iTagID from product_tag_assoc as t join product as p on t.iProdID=p.iProdID where p.cStatus="A"'.$cond);

	if(!empty($tSTR) && $tSTR!='-1')

		$arr = GetXArrFromYID('select iTagID, vName from tags where cStatus="A" and iTagID IN ('.$tSTR.')','3');

	

	return $arr;

}



function GetSectionTagList2020($sID)

{

	$arr = array();

	

	$p_str = GetIDString('select h2.iProdID from homepage_section_dat as h2 join homepage_section as h on h2.iHPSecID=h.iHPSecID where h.cStatus="A" and h.iHPSecID='.$sID);

	if(!empty($p_str) && $p_str!='-1')

	{

		$cond = ' and p.iProdID IN ('.$p_str.')';

		$tSTR = GetIDString('select t.iTagID from product_tag_assoc as t join product as p on t.iProdID=p.iProdID where p.cStatus="A"'.$cond);

		if(!empty($tSTR) && $tSTR!='-1')

			$arr = GetXArrFromYID('select iTagID, vName from tags where cStatus="A" and iTagID IN ('.$tSTR.')','3');

	}

	return $arr;

}



function GetSearchTagList2020($term)

{

	$arr = array();

	

	$cond = '';

	$term = strtolower($term);

	$pc_str = GetIDString('select iPCatID from prodcat where LOWER(vName) LIKE "%'.$term.'%" and cStatus="A"');

	if(!empty($pc_str) && $pc_str!='-1')

	{

		$pc_str2 = GetIDString('select iPCatID from prodcat where iParentID IN ('.$pc_str.') and cStatus="A"');

		if(!empty($pc_str2) && $pc_str2!='-1')

			$cond .= ' and p.iPCatID IN ('.$pc_str.','.$pc_str2.')'; 

		else

			$cond .= ' and p.iPCatID IN ('.$pc_str.')'; 

	}

	

	$tag_str = GetIDString('select iTagID from tags where LOWER(vName) LIKE "%'.$term.'%" and cStatus="A"');

	if(!empty($tag_str) && $tag_str!='-1')

	{

		$tag_str2 = GetIDString('select iProdID from product_tag_assoc where iTagID IN ('.$tag_str.')');

		if(!empty($tag_str2) && $tag_str2!='-1')

			$cond .= ' and p.iProdID IN ('.$tag_str2.')'; 

		else

			$cond .= ' and p.iProdID=0'; 

	}

	

	$p_str = GetIDString('select iProdID from product where LOWER(vName) LIKE "%'.$term.'%" or LOWER(vShortDesc) LIKE "%'.$term.'%" or LOWER(vDescription) LIKE "%'.$term.'%"');

	if($p_str)

		$cond .= ' and p.iProdID IN ('.$p_str.')'; 

		

	if(empty($cond))

		$cond .= ' and p.iProdID=0';



	$tSTR = GetIDString('select t.iTagID from product_tag_assoc as t join product as p on t.iProdID=p.iProdID where p.cStatus="A"'.$cond);

	if(!empty($tSTR) && $tSTR!='-1')

		$arr = GetXArrFromYID('select iTagID, vName from tags where cStatus="A" and iTagID IN ('.$tSTR.')','3');



	return $arr;

}



function GetFlashSaleTagList2020($fID)

{

	$arr = array();

	

	$p_str = GetIDString('select p.iProdID from flash_dat as p join flash as f on p.iFID=f.iFID where p.iFID='.$fID);

	if(!empty($p_str) && $p_str!='-1') $cond = ' and p.iProdID IN ('.$p_str.')'; 

	else $cond = ' and p.iProdID=0'; 

	

	$tSTR = GetIDString('select t.iTagID from product_tag_assoc as t join product as p on t.iProdID=p.iProdID where p.cStatus="A"'.$cond);

	if(!empty($tSTR) && $tSTR!='-1')

		$arr = GetXArrFromYID('select iTagID, vName from tags where cStatus="A" and iTagID IN ('.$tSTR.')','3');

	

	return $arr;

}

?>