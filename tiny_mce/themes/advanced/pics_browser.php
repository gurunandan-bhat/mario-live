<?php
require_once('../../../../../common.php');
	
	$x=0;
	$dir = opendir(UPLOAD_MAILER_PICS);
	$key_arr = array();
	$arr = array();
	$field_name = (isset($_GET["field_name"]))? $_GET["field_name"]: "src";

	for($i=0; $file_name = readdir($dir);)
	{
		if(($file_name!=".") && ($file_name!="..") && (strtolower($file_name)!="thumbs.db") && file_exists(UPLOAD_MAILER_PICS . $file_name))
		{
			$file_name=str_replace(" ","%20",$file_name);
			list($imgwidth,$imgheight) = getimagesize(UPLOAD_MAILER_PICS . $file_name);
			$width = ($imgwidth > 100)? 100: $imgwidth;
			$timestamp = filemtime(UPLOAD_MAILER_PICS . $file_name);
			$date = date ("j M Y H:i:s.", filemtime(UPLOAD_MAILER_PICS . $file_name));

			$key_arr[$timestamp] = $i;
			$arr[$i] = array("NAME"=>$file_name, "IMG"=>MAILER_PICS_PATH . $file_name, "WIDTH"=>$width, "DATE"=>$date);
			 $i++;
		}
	}
	closedir($dir);
	
	rsort($key_arr);
	reset($key_arr);
	
	//
?>
<html>
<head>
  <title>Insert Image</title>

<script language="JavaScript1.2" src="../../../../../scripts/s.js"></script>
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="../../utils/form_utils.js"></script>
<!-- <script language="javascript" type="text/javascript" src="jscripts/functions.js"></script>	-->
<script language="JavaScript" type="text/javascript">
WindowXXPosition(95, 95, this.window);

function onOK() 
{
	var required = { "f_url": "You must enter the URL" };

	for (var i in required) 
	{
		var el = document.getElementById(i);
		if (!el.value) 
		{
			alert(required[i]);
			el.focus();
			return false;
		}
	}

	// pass data back to the calling window
	x=document.imageform.f_url.value;

	window.opener.document.imgurl.<? echo $field_name ?>.value = x;
	window.opener.document.imgurl.<? echo $field_name ?>.focus();
	
	window.close();
	return false;
};

function onCancel() 
{
	window.close();
	return false;
};

function sendtobox(path,name)
{
	x=path+name;
	document.imageform.f_url.value=x;
	onOK();
}

function CloseMe()
{
	var elm = document.getElementById("prev");
	prev.style.display = "none";
}
</script>


<link href="../../../../../css/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="pgtitle">Insert Image: Type In Your URL Or Select An Image</div>
<br>
<!--- new stuff --->
<form action="" method="get" name='imageform'>
  <table border="0" width="98%" cellpadding="0" cellspacing="1" class="tble">
    <tbody>
      <tr> 
        <th style="width: 6em;height: 2em; " class="pgtitle_hor">Image URL:</th>
        <td>&nbsp;<input type="text" name="f_url" id="f_url" style="height:22px;width:75%"title="Enter the image URL here"  class="box"/>&nbsp;<button type="button" name="ok" onclick="return onOK();" class="box" style="height: 2em; ">SEND</button>      
        </td>
      </tr>
    </tbody>
  </table>
<br>
<table width="100%" style="margin-bottom: 0.2em">
 <tr>
  <td valign="bottom" class="darkbluetitle">
	<div id="prev" align="center" style="position: absolute; display:none; z-index:100; background-color:#3996C6; margin:3px;"></div>
	<br>
	<table border='0' cellspacing="1" cellpadding="0" class="tble" align="center" width="98%">
<?
	if(count($key_arr))
	{
?>
		<tr>
			<th width="8%">Sr.No.</th>
			<th>Name</th>
			<th width="25%">Upload Date</th>
			<th colspan="2">Options</th>
		</tr>
<?
		$i=1;
		foreach($key_arr as $k)
		{
			$x_file = $arr[$k];
			$file_name = $x_file["NAME"];
			$file = $x_file["IMG"];
			$width = $x_file["WIDTH"];
			$date = $x_file["DATE"];
?>			
		<tr class="datarow">
			<td align="center"><? echo $i++; ?>.</td>
			<td><a href="#" onClick="showPreviewImageX('<? echo MAILER_PICS_PATH . $file_name; ?>', true);"><? echo $file_name; ?></a></td>
			<td align="center"><? echo $date; ?></td>
			<td width="8%" align="center"><a href="#" onClick="showPreviewImageX('<? echo MAILER_PICS_PATH . $file_name; ?>', true);">preview</a></td>
			<td width="8%" align="center"><a href="#" onClick="sendtobox('<? echo MAILER_PICS_PATH; ?>','<? echo $file_name; ?>'); return false;">insert</a></td>
		</tr>
<?
		}
	}
	else
	{
?>
		<tr>
			<td colspan="4" align="center" class="txt">No Uploaded Images Found!</td>
		</tr>
<?
	}
?>
		</table>

  </td>
  <td valign="bottom" style="text-align: right">&nbsp;</td>
 </tr>
</table>
</form>
</body>
</html>