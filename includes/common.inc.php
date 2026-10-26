<?php
function GetIDArray($q)
{
	$arr = array();
	$r = sql_query($q, 'COM.236');
	while(list($memid)=sql_fetch_row($r))
		$arr[$memid] = $memid;

	return $arr;
}

function chop_words($str, $words = 20, $limit = 0, $suffix = ' ...')
{
    //string  $str --The input string
    //$words  The number of words to return, default 20, 0 to skip
    //$limit  Maximum length of the returned string 
     //string  $suffix  The string to append to the input if shortened.

    if($limit) $limit -= strlen($suffix);
       
    for ($i = 0, $ix = 0; $i < $words; $i++)
        if (($is = strpos($str, ' ', $ix)) !== false)
        {
            if ($limit && $is + 1 > $limit)
                break;

            $ix = $is + 1;        
        }
        else
            return $str;

    return substr($str, 0, $ix) . $suffix;
}

function GetIDString($q)
{
	$arr = array();
	$r=sql_query($q)or die("<strong>ERROR CODE : </strong> COM - 2575");
	while(list($memid)=sql_fetch_row($r))
	{
		$arr[$memid] = $memid;
	}
	$arr[0] = 0;
	$str=implode(",",$arr);
	return $str;
}

function GetSubContentCat($level, $parentid, $arr, $mode="1", $cond="")
{
	$space = "";
	$level++;
	$q = "select iPCatID, vName, iParentID, cStatus from prodcat where iParentID=$parentid $cond order by iRank";
	$r = sql_query($q, 'COM.67');
	
	if(sql_num_rows($r))
	{
		if($mode == "1")
		{
			for($i=1; $i < $level; $i++)
				$space .= "&nbsp;&nbsp;&nbsp;";
		
			while(list($id,$nm,$pid,$stat)=sql_fetch_row($r))
			{
				$arr[$id] = $space . $nm;
				$arr = GetSubContentCat($level, $id, $arr, $mode);
			}
		}
		elseif($mode == "2") 
		{		
			for($i=1; $i < $level; $i++)
				$space .= "&nbsp;&nbsp;&nbsp;";
		
			for($i=1; list($id,$nm,$pid,$stat)=sql_fetch_row($r); $i++)
			{
				$arr[$id] = array("I"=>$i, "LEVEL"=>$level, "SPACE"=>$space, "ID"=>$id, "NAME"=>$nm, "PARENTID"=>$pid, "STATUS"=>$stat);
				$arr = GetSubContentCat($level, $id, $arr, $mode);
			}
		}
		else if($mode == "3")
		{
			for($i=1; $i < $level; $i++)
				$space .= "&nbsp;&nbsp;";
		
			while(list($id,$nm,$pid,$stat)=sql_fetch_row($r))
			{
				$pnm = (isset($arr[$pid]))? trim($arr[$pid]) . ' &gt;&gt; ': '';
				$arr[$id] = $space . $pnm . $nm;
				$arr = GetSubContentCat($level, $id, $arr, $mode);
			}
		}
	}
	return $arr;
}
function GetShowImageString($url, $status, $pc_id, $a_id)
{
	$str = "";
	
	if($status=="Y")
		$str = "<a href='#' onClick=\"ChangeImgStat('$url','N', '$pc_id', '$a_id'); return false;\">" . IMG_YES . "</a>";
	else
		$str = "<a href='#' onClick=\"ChangeImgStat('$url','Y', '$pc_id', '$a_id'); return false;\">" . IMG_NO . "</a>";

	return $str;
}
function GetPagination($q,$pageno,$param_str,$function="")
{
	$str = "";
	$param_str = (empty($param_str))?"":"&".$param_str;
	//echo $param_str;
	
	$query = $q;
	//echo $query;
	$result = sql_query($query) or die("COM:880".sql_error()."  => ".$query);
	$query_data = sql_fetch_row($result);
	$numrows = $query_data[0];
	
	$lastpage = ceil($numrows/PAGE_LIMIT);
	$pageno = (int)$pageno;
	if ($pageno > $lastpage)
	{
		$pageno = $lastpage;
	} // if
	if ($pageno < 1) 
	{
		$pageno = 1;
	} // if
	
	
	if($numrows > PAGE_LIMIT)
	{
		if ($pageno == 1)
		{
			echo " <span class='pageprevnexg'>&lt;&lt;</span><span class='pageprevnexg'> &lt;</span> ";
		}
		else
		{
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=1$param_str' class='pageprevnex'>&lt;&lt;</a> ";
			$prevpage = $pageno-1;
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$prevpage$param_str' class='pageprevnex'>&lt;</a> ";
		} // if
		
		echo " <span class='pagination'>( Page $pageno of $lastpage )</span> ";
		
		if ($pageno == $lastpage)
		{
			echo " <span class='pageprevnexg'>&gt;</span> <span class='pageprevnexg'>&gt;&gt;</span> ";
		}
		else
		{
			$nextpage = $pageno+1;
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$nextpage$param_str' class='pageprevnex'>&gt;</a> ";
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$lastpage$param_str' class='pageprevnex'>&gt;&gt;</a> ";
		} // if
     }
	//return $limit;
}

function GetPaginationTopCat($q,$pageno,$param_str,$function="")
{
	$str = "";
	$param_str = (empty($param_str))?"":"&".$param_str;
	//echo $param_str;
	
	$query = $q;
	//echo $query;
	$result = sql_query($query) or die("COM:880".sql_error()."  => ".$query);
	$query_data = sql_fetch_row($result);
	$numrows = $query_data[0];
	
	$lastpage = ceil($numrows/PAGE_LIMIT);
	$pageno = (int)$pageno;
	if ($pageno > $lastpage)
	{
		$pageno = $lastpage;
	} // if
	if ($pageno < 1) 
	{
		$pageno = 1;
	} // if
	
	
	if($numrows > PAGE_LIMIT)
	{
		if ($pageno == 1)
		{
			echo " <span class='pageprevnexg'>&lt;&lt;</span><span class='pageprevnexg'> &lt;</span> ";
		}
		else
		{
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=1$param_str' class='pageprevnex'>&lt;&lt;</a> ";
			$prevpage = $pageno-1;
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$prevpage$param_str' class='pageprevnex'>&lt;</a> ";
		} // if
		
		echo " <span class='pagination'>( Page $pageno of $lastpage )</span> ";
		
		if ($pageno == $lastpage)
		{
			echo " <span class='pageprevnexg'>&gt;</span> <span class='pageprevnexg'>&gt;&gt;</span> ";
		}
		else
		{
			$nextpage = $pageno+1;
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$nextpage$param_str' class='pageprevnex'>&gt;</a> ";
			echo " <a ".$function." href='{$_SERVER['PHP_SELF']}?pageno=$lastpage$param_str' class='pageprevnex'>&gt;&gt;</a> ";
		} // if
     }
	//return $limit;
}
function GetLimit($pageno)
{
	$limit = 'LIMIT ' .($pageno - 1) * PAGE_LIMIT .',' .PAGE_LIMIT;
	return $limit;
}

function GetLastPageCount($pageno)
{
	$from = (($pageno * PAGE_LIMIT) - PAGE_LIMIT);
	return $from;
}
function SuggestPassword()
{
	$arr = array();
	
	// length: 6 - 8 chars
	$len = rand(6, 8);	
	// echo $len."<br>";
	
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

	$ctr = $i;

	// atleast 1 symbol
	$symb_arr = array('!', '#', '$', '%', '&', '*', '+', ',', '-', '.', ':', '=', '?', '@', '_', '~');
	$d_len = $len-$a_len-$b_len-$c_len;
	// echo 'd_len: '.$d_len.'<br>';
	
	for(;$i<($ctr+$d_len); $i++)
		$arr[$i] = $symb_arr[rand(0, count($symb_arr)-1)];

	// DFA($arr);
	shuffle($arr);
	// DFA($arr);
	
	$str = '';	
	foreach($arr as $a)
		$str .= $a;
	
	return $str;
}

function EncodeParam($param)
{
	$rand = rand();
	$crypt_str = md5($rand);
	
	$len = strlen($param);
	$a = substr($crypt_str, 0, 1);
	$start = hexdec($a);
	
	$a = substr($crypt_str, 0, $start + 1);
	$b = substr($crypt_str, ($start + 1 + $len + 1));	
	$x =  $a . $len . $param . $b;
	
	return $x;	
}

function DecodeParam($crypt_param)
{
	$a = substr($crypt_param, 0, 1);
	$start = hexdec($a);
	$len = substr($crypt_param, $start + 1, 1);
			
	$param = substr($crypt_param, ($start + 1 + 1), $len);
	return $param;
}
function SetMinRank($tb1,$cond="")
{
	$cond = (strtoupper(trim($cond)) != "")? " where " . $cond: "";	
	$min = GetXFromYID("select min(iRank) from $tb1 $cond");
	
	if($min == 0)
	{
		sql_query("update $tb1 set iRank=iRank+2 $cond")or die("<strong>ERROR CODE :</strong> COM-68");
	}
	else
	{
		sql_query("update $tb1 set iRank=iRank+1 $cond")or die("<strong>ERROR CODE :</strong> COM-72");
	}
	
	return 1;
}
?>