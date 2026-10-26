<html style="width: 420; height: 450">
<head>
  <title>Insert Image</title>

<script language="JavaScript1.2" src="../../../../scripts/gim.js"></script>
<script language="JavaScript">
	 WindowPosition(600,450);
</script>
<script type="text/javascript">

function onOK() {
  var required = {
    "f_url": "You must enter the URL"
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
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

function onCancel() {
  window.close();
  return false;
};

function sendtobox(path,name)
{
x=path+name;
document.imageform.f_url.value=x;
onOK();
}

</script>


<link href="../../../../css/gim.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
include('../../../../common.php');
?>
<div class="admintitle">Insert Image</div>
<br>
<div class="redlink" style="padding-left:4px"><strong>Type In Your URL Or Select An Image</strong></div>
<!--- new stuff --->
<form action="" method="get" name='imageform'>
  <table border="0" width="100%" style="padding: 0px; margin: 0px">
    <tbody>
      <tr> 
        <td style="width: 6em;height: 2em; " class="pgtitle_hor">Image URL:</td>
        <td class="tdata" style="border:0px"><input type="text" name="f_url" id="f_url" style="height:22px;width:75%"
      title="Enter the image URL here"  class="box"/>&nbsp;<button type="button" name="ok" onclick="return onOK();" class="box" style="height: 2em; ">SEND</button>         
        </td>
      </tr>
    </tbody>
  </table>
<br>
<table width="100%" style="margin-bottom: 0.2em">
 <tr>
  <td valign="bottom" class="darkbluetitle">
   <?
$x=0;
		$dir = opendir(UPLOAD_IMAGES);				
		////@chmod(UPLOAD_ARTICLE_PICS,0644);
		
print("<br><table  border='0' cellspacing='0' cellpadding='6'><tr>");
		while($file_name = readdir($dir))
		{
				if(($file_name!=".")&&($file_name!="..")&&(strtolower($file_name)!="thumbs.db") && file_exists(UPLOAD_IMAGES.$file_name))
				{
					if($x==4)
					{
					print("</tr><tr>");
					$x=0;
					}		
						$file_name=str_replace(" ","%20",$file_name);
						$file=IMAGES_PATH.$file_name;
						list($imgwidth,$imgheight) = getimagesize(($file));
						$path=IMAGES_PATH;
						
						if($imgwidth > 100)
						$width=100;
						else
						$width=$imgwidth;
						
						print("<td  style='border:1px solid #FAD7B6'><img src='$file' border='1' width='".$width."px' onClick=\"sendtobox('$path','$file_name');\" style='cursor:pointer'><div class='txt' style='padding:2px'>$file_name</div></td>");		
						$x++;	
						
				}
		}
print("</tr></table>");

?>
  </td>
  <td valign="bottom" style="text-align: right">&nbsp;
    
  </td>
 </tr>
<!--
 <tr><td colspan="3"><button type="button" name="ok" onclick="return onOK();" class="box">OK</button>
    <button type="button" name="cancel" onclick="return onCancel();" class="box">Cancel</button></td></tr>
	-->
</table>
</form>
</body>
</html>
