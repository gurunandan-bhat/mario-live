<?php
require_once("common.php");
getconnected();

if(isset($_GET["prefix"])) $prefix = $_GET["prefix"];
else $prefix = "";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else $mode = "";

$len = strlen($prefix);
$data_arr = array();
$result_arr = array();
$arr = array();

// $data_arr[0] = 'P:'. $prefix;

if($len)
{
	if($mode == "ORDER_MUSIC")
	{
		$q = "select A.iAlbumID, A.cCode, A.vTitle, T.iTrackID, T.cCode, T.vTitle ";
		$q .= " from album as A left outer join track as T on A.iAlbumID=T.iAlbumID ";
		$q .= " where A.vTitle like '$prefix%' ";
		$q .= " order by A.iRank, T.iRank";
		$r = mysql_query($q) or die("<strong>Error Code: _AS24</strong>");

		// $data_arr[1] = $q;
		
		$last = '';
		for($i=0; list($a_id, $a_code, $a_title, $t_id, $t_code, $t_title) = sql_fetch_row($r); $i++)
		{
			$a_txt = trim($a_title . ' - ' . $a_code);

			if($last != $a_id)
			{
				$data_arr[$a_id.'.0'] = $a_txt;
				$last = $a_id;
			}
			
			if(!empty($t_id))
			{
				$t_txt = trim($t_title . ' - ' . $t_code);
				$data_arr[$a_id.'.'.$t_id] = '- ' . $t_txt;
			}	// */
			// $data_arr[$i] = 'aaa';
		}
	
		foreach($data_arr as $d_txt)
			$result_arr[] = array( "id"=>db_output($d_txt) ,"value"=>db_output($d_txt), "info"=>"0");
	
		foreach($result_arr as $r)
			$arr[] = "{\"id\": \"".$r['id']."\", \"value\": \"".$r['value']."\", \"info\": \"\"}";
	}
}

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0
header("Content-Type: application/json");

echo "{\"results\": [" . implode(", ", $arr) . "]}";
// $xyz = "{\"id\": \"abc\", \"value\": \"a".$mode.'-'.implode(':', $_GET)."\", \"info\": \"\"}";
// echo "{\"results\": [" . $xyz . "]}";
?>