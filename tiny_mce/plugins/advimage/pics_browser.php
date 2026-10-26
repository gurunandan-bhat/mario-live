<?php
require_once('../../../includes/common.php');

	$mode = (isset($_GET['mode']))?$_GET['mode']:'';
	
	if($mode=='D')
	{
		$file_image = (isset($_GET['file']))?$_GET['file']:''; 
		DeleteFile($file_image, CONTENT_UPLOAD);
		
		header('location:http://126.0.0.100/trauring/tiny_mce/plugins/advimage/pics_browser.php?field_name=src');
		exit;
	}
	
	$x=0;
	$dir = opendir(CONTENT_UPLOAD);
	$key_arr = array();
	$arr = array();
	$field_name = (isset($_GET["field_name"]))? $_GET["field_name"]: "src";

	for($i=0; $file_name = readdir($dir);)
	{
		if(($file_name!=".") && ($file_name!="..") && (strtolower($file_name)!="thumbs.db") && file_exists(CONTENT_UPLOAD . $file_name))
		{
			$file_name=str_replace(" ","%20",$file_name);
			list($imgwidth,$imgheight) = getimagesize(CONTENT_UPLOAD . $file_name);
			$width = ($imgwidth > 100)? 100: $imgwidth;
			$timestamp = filemtime(CONTENT_UPLOAD . $file_name);
			$date = date ("j M Y H:i:s.", filemtime(CONTENT_UPLOAD . $file_name));

			$key_arr[$timestamp] = $i;
			$arr[$i] = array("NAME"=>$file_name, "IMG"=>CONTENT_PATH . $file_name, "WIDTH"=>$width, "DATE"=>$date);
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

<script language="JavaScript1.2" src="../../../../../scripts/jump.js"></script>
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="../../utils/form_utils.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/functions.js"></script>
<script language="JavaScript" type="text/javascript">
WindowPosition2(95, 95, this.window);

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
	
	window.opener.document.imgurl.<?php echo $field_name ?>.value = x;
	window.opener.document.imgurl.<?php echo $field_name ?>.focus();
	
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
function ConfirmDelete(txt, page)
{
	var msg = "You Are About To Delete this " + txt + "! Continue?";

	if(confirm(msg))
		window.document.location.href=page;
}
</script>


<link href="../../../../../css/adminstyle.css" rel="stylesheet" type="text/css">
<link href="../../../../../css/jump.css" rel="stylesheet" type="text/css">
</head>

<body class="resultsbg">
<div class="maintitle">INSERT IMAGE: Type In Your URL Or Select An Image</div>
<br>
<!--- new stuff --->
<form action="" method="get" name='imageform'>
  <table border="0" width="98%" cellpadding="0" cellspacing="1" class="tblebdr">
    <tbody>
      <tr> 
        <td style="width: 6em;height: 2em; " class="txt">Image URL</td>
		<td width="2" class="txt"><strong>:</strong></td>
        <td width="txt">&nbsp;<input type="text" name="f_url" id="f_url" style="height:22px;width:75%"title="Enter the image URL here"  class="box"/>&nbsp;<button type="button" name="ok" onClick="return onOK();" class="box" style="height: 2em; ">SEND</button>      
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
<?php 
	if(count($key_arr))
	{
?>
		<tr>
			<th width="8%">Sr.No.</th>
			<th>Name</th>
			<th width="25%">Upload Date</th>
			<th colspan="3">Options</th>
		</tr>
<?php 
		$i=1;
		foreach($key_arr as $k)
		{
			$x_file = $arr[$k];
			$file_name = $x_file["NAME"];
			$file = $x_file["IMG"];
			$width = $x_file["WIDTH"];
			$date = $x_file["DATE"];
			
			$file_new_name = explode('~',$file_name);
			
			$class_str = ($i%2==1)? "class='alt'": "class='alt1'";
?>			
		<tr>
			<td height="25" <?php echo $class_str; ?>><?php echo $i++; ?>.</td>
			<td <?php echo $class_str; ?>><a href="#" onClick="showPreviewImageX('<?php echo CONTENT_PATH . $file_name; ?>', true); return false;" class="a_txt"><?php echo ((isset($file_new_name[1])) && $file_new_name[1]!='' )?$file_new_name[1]:$file_new_name[0]; ?></a></td>
			<td <?php echo $class_str; ?>><?php echo $date; ?></td>
			<td width="8%" <?php echo $class_str; ?>><a href="#" onClick="showPreviewImageX('<?php echo CONTENT_PATH . $file_name; ?>', true); return false;" class="a_txt">preview</a></td>
			<td width="8%" <?php echo $class_str; ?>><a href="#" onClick="sendtobox('<?php echo CONTENT_PATH; ?>','<?php echo $file_name; ?>'); return false;" class="a_txt">insert</a></td>
			<td width="8%" <?php echo $class_str; ?>><a href="#" onClick="ConfirmDelete('Image', 'pics_browser.php?mode=D&file=<?php echo $file_name; ?>');" class="a_txt">Delete</a></td>
		</tr>
<?php 
		}
	}
	else
	{
?>
		<tr>
			<td colspan="5" align="center" class="alt1">No Uploaded Images Found!</td>
		</tr>
<?php 
	}
?>
		<tr>
			<th colspan="5">&nbsp;</th>
			</tr>
		</table>

  </td>
  <td valign="bottom" style="text-align: right">&nbsp;</td>
 </tr>
</table>
</form>
</body>
</html>