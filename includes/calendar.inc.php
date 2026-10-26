<?php
class Calendar
{
	var $daysInMonth=array
	   (1=>31,
		2=>28,
		3=>31,
		4=>30,
		5=>31,
		6=>30,
		7=>31,
		8=>31,
		9=>30,
		10=>31,
		11=>30,
		12=>31);
	
	var $monthName=array
	   (1=>"Jan",
		2=>"Feb",
		3=>"Mar",
		4=>"Apr",
		5=>"May",
		6=>"Jun",
		7=>"Jul",
		8=>"Aug",
		9=>"Sep",
		10=>"Oct",
		11=>"Nov",
		12=>"Dec");
//-----------------------------------------------------------------------------
// To check if the given year is a leap year to consider for 29 days in Feb.

    function isLeap($yr)
    {
		return  date("L", mktime(0,0,0,1,1,$yr));
    }

//-----------------------------------------------------------------------------
// Given the month and year returns the number of days in the month
	function getDaysInMonth ($yr, $mn)
    {
        $mn = intval ($mn);
        $yr = intval ($yr);

        if ($this->isLeap($yr) && $mn  == 2)
          return 29;

        return  $this->daysInMonth[$mn];
    }
	
 //-----------------------------------------------------------------------------
// This function accepts values for month and year and returns an array
// of 2 time stamps representing first and last day of month
	function getDateRange ($mn, $yr)
	{
		$mn = intval ($mn);
		$yr = intval ($yr);
		
		$last = $this->getDaysInMonth ($yr, $mn);
		$start = mktime (0,0,0, $mn,1, $yr);
		$end   = mktime (0,0,0, $mn,$last, $yr);
		$start = date ("Y-m-d", $start);
		$end =  date ("Y-m-d", $end);
		return array ($start, $end);
	}

//-----------------------------------------------------------------------------
    function getFirstDayInMonth ($yr, $mn)
    {
        $mn = intval ($mn);
        $yr = intval ($yr);
        return date("w", mktime(0,0,0,$mn,1,$yr));
    }

//-----------------------------------------------------------------------------
    function getMonthName ($mn)
    {
       $mn = intval ($mn);
       return $this->monthName[$mn];
    }

//-----------------------------------------------------------------------------
    function  getCurrentMonth()
    {
        return intval(Date('m'));
    }

//-----------------------------------------------------------------------------
    function  getCurrentYear ()
    {
       return intval(Date("Y"));
    }

//-----------------------------------------------------------------------------
	// Draws the calander table
	function drawMonth($yr, $mn, $data_arr, $opt_str=array())
	{
 
		$headerColor="#D1DCEB";
		$bgColor="#8F9BBC";
		$borderColor="WHITE";
		$filledColor="#CCCCCC";

		$entries = $this->getDaysInMonth ($yr, $mn);
		$firstSq = $this->getFirstDayInMonth ($yr, $mn);
		$month = $this->getMonthName($mn);
		
		list($mn_start_dt, $mn_end_dt) = $this->GetTimeSpan($yr.'.'.$mn, 'M');
				
		$str = '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="calendar_tbl">'.NEWLINE;
		$str .= '<tr height="12px">'.NEWLINE;
		$str .= '<th colspan="8"><a href="#" onclick="ShowEvents(\''.$mn_start_dt.'\',\''.$mn_end_dt.'\'); return false;">'.$month.' ('.$yr.')</a></th>'.NEWLINE;
		$str .= '</tr>'.NEWLINE;
		$str .= '<tr>'.NEWLINE;
		$str .= '<th class="calendar_hdr">S</th>
					<th class="calendar_hdr">M</th>
					<th class="calendar_hdr">T</th>
					<th class="calendar_hdr">W</th>
					<th class="calendar_hdr">T</th>
					<th class="calendar_hdr">F</th>
					<th class="calendar_hdr">S</th>'.NEWLINE;
		$str .= '</tr>'.NEWLINE;
		
		// some of the first sqaures may be blank i.e if month doesn't
		// start on Sunday. so use $count to determine if square is blank
		$count = 0 -  $firstSq ;
		
		$x_mn = (strlen($mn) == 1)? '0'.$mn: $mn;
	
		for ($r=0; $r<6; $r++)
		{
			$str .= '<tr>'.NEWLINE;
			for ($c=0; $c<7; $c++)
			{
				$count++;
				if ($count <  1 || $count > $entries)
				{
					$str .= '<td>&nbsp;</td>'.NEWLINE;
					continue;
				}
				else
				{
					$count1 = $count;		

					if(($count<10)&&(strlen($count)==1))
						$count = '0'.$count;
			
					if(($mn<10)&&(strlen($mn)==1))
						$mn = '0'.$mn;
					
					$dt = $yr.'-'.$mn.'-'.$count;
				}
				
				$dmy_dt = ConvertFromYMDtoDMY($dt);
				$td_css = "calendar_day"; // css for the td
 				$td_title = ''; 
				$a_txt = $count1;
				
				$td_id = ($dt==TODAY)? 'id="calendar_today"': '';  // is it TODAY's date?
				$a_txt = '<a href="activity_scheduler_disp.php?dt='.$dt.'" name="'.$dt.'" onclick="ShowOptions(this); return false;">'.$count1.'</a>';
				$td_title="";
				$concat="";
				$evt_color_arr = array();
				
				if(isset($data_arr[$dt]['SCHEDULE'])) // Does a schedule exist for this day?
				{
				  //$type=explode("-",$data_arr[$dt]);
					$td_css = "calendar_events";
					//$td_title .= $data_arr[$dt]['SCHEDULE']['COUNT'].' SCHEDULE';
					$td_title .= $data_arr[$dt]['SCHEDULE'].' SCHEDULE';
					$concat=" and ";
/*					if(isset($data_arr[$dt]['EVENT']) && count($data_arr[$dt]['EVENT']))
					{
						$td_title .= ' ('.implode(', ',$data_arr[$dt]['EVENT']).')';
						$evt_color_arr = $data_arr[$dt]['COLOR'];
					}	// */					
				}
				
					if(isset($data_arr[$dt]['ACTIVITY'])) // Does a schedule exist for this day?
				{
				  //$type=explode("-",$data_arr[$dt]);
					
					$td_css = "calendar_events";
					$td_title .= $concat.$data_arr[$dt]['ACTIVITY'].' ACTIVITY';
					
/*					if(isset($data_arr[$dt]['EVENT']) && count($data_arr[$dt]['EVENT']))
					{
						$td_title .= ' ('.implode(', ',$data_arr[$dt]['EVENT']).')';
						$evt_color_arr = $data_arr[$dt]['COLOR'];
					}	// */					
				}
				
//				$div_str = $this->PrepOptionStr($opt_str, $dt, $td_title);
				
				$td_str = $a_txt; // .$div_str;
				$td_style = '';

/*				if(count($evt_color_arr))
					foreach($evt_color_arr as $evt_color)
						$td_style = 'background-color:#'.$evt_color.';'; // '<span style="border:1px solid #'.$evt_color.';">'.$td_str.'</span>';	*/
				
				$str .= '<td '.$td_id.' title="'.$td_title.'" class="'.$td_css.'" style="border:1px solid #eaeaea;'.$td_style.'" align="center">'.$td_str.'</td>'.NEWLINE;
			}
			$str .= '</tr>'.NEWLINE;
		}
		$str .= '</table>'.NEWLINE;
	
		return $str;
	}
	
	/*function GenerateOptionString($css_arr)
	{
		DFA($css_arr);
		$str = '<div name="div_opts" id="div_[DT]" style="display:none;" class="calendar_options">
					<b><a href="#" onclick="ShowEvents(\'[DT]\'); return false;">[DT]</a></b>[DT_EVENTS]<br />';
		
		foreach($css_arr as $css_id=>$css_title)
			$str .= '<a name="a_popup" href="#a_csl_popup" onclick="setCSLIFrameSrc('.$css_id.',\'A\',0,\'\',\'&dt=[DT]\');">'.$css_title.'</a><br />';

		$str .= '<a href="#" onclick="CreateCSS(\'[DT]\'); return false;">add new work</a> | <a href="#" onclick="ToggleVisibility(this.parentNode.id); return false;">close</a></div>';
		
		return $str;	
	}*/
	

	function GetTimeSpan($val, $mode, $my_arr=array(), $cols=3)
	{
		$start_dt = $end_dt = TODAY;
		
		if($mode=='Q') // $val = 1, 2, 3, 4...
		{
			list($x_yr, $x_mn) = explode('.', $my_arr[(($val-1)*$cols)]);
			list($y_yr, $y_mn) = explode('.', $my_arr[(($val*$cols)-1)]);
			
			$start_dt = $x_yr.'-'.(pad_month($x_mn)).'-01';
			$end_dt = GetMonthLastDate($y_yr, $y_mn);
		}
		else if($mode=='M') // $val = <yyyy>.<mm>
		{
			list($x_yr, $x_mn) = explode('.', $val);
			
			$start_dt = $x_yr.'-'.($this->pad_month($x_mn)).'-01';
			$end_dt = $this->GetMonthLastDate($x_yr, $x_mn);
		}
		
		
		return array($start_dt, $end_dt);
	}
	
	function pad_month($mn)
	{
		$mn = intval($mn);
		
		return ($mn < 10)? '0'.$mn: $mn;
	}
	
	function GetMonthLastDate($yr, $mn)
	{
		$days_in_month = array(1=>31, 2=>28, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);
		$mn = intval ($mn);
		$yr = intval ($yr);
	
		if (isLeapYear($yr) && $mn  == 2)
		  return 29;
	
		return  $yr.'-'.$this->pad_month($mn).'-'.$days_in_month[$mn];
	}
	
	function PrepOptionStr($str, $dt, $td_title)
	{
		$td_title = (!empty($td_title))? ' - '.$td_title: '';

		$str = str_replace('[DT]', $dt, $str);
		$str = str_replace('[DT_EVENTS]', $td_title, $str);
		
		return $str;
	}
}// end calendar class
//--------------------------------------------------------------
?>