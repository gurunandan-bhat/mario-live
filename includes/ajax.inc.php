<?php
require_once("common.php");

if(isset($_POST["response"])) $response = $_POST["response"];
else if(isset($_GET["response"])) $response = $_GET["response"];
else $response = "";

$result = 'false'; //0~0~0~0";

if($response == "UNIQUE_CODE")
{
	if(isset($_GET["id"]) && isset($_GET['val']) && isset($_GET['mode']))
	{
		$id = $_GET["id"];
		$val = trim($_GET["val"]);
		$mode = $_GET['mode'];
		
		if($mode == 'STAFF')
		{
			$pk_fld = 'iStaffID';
			$code_fld = 'vUsername';
			$tbl = 'staff';
		}
		else if($mode == 'CLIENTS')
		{
			$pk_fld = 'iClientID';
			$code_fld = 'vCIN';
			$tbl = 'clients';
		}
		else if($mode == 'CLIENTS_PAN')
		{
			$pk_fld = 'iClientID';
			$code_fld = 'vPanNo';
			$tbl = 'clients';
		}
		else if($mode == 'DIRECTOR')
		{
			$pk_fld = 'iDID';
			$code_fld = 'vDIN';
			$tbl = 'director';
		}
		else if($mode == 'DIRECTOR_PAN')
		{
			$pk_fld = 'iDID';
			$code_fld = 'vPAN';
			$tbl = 'director';
		}
		
		$flag = IsUniqueEntry($pk_fld, $id, $code_fld, $val, $tbl);
		
/*		if($flag=='1') $str = "1~<span style='color:#00CC00;'>Available</span>";
		else if($flag=='0') $str = "0~<span style='color:#CC0000;'>Unavailable</span>";
		else $str = "1~<span></span>";	// */

		$result = ($flag=='0')? '0': '1';
	}
}
else if($response == 'UPDATE_STATUS')
{
    if(isset($_GET["mode"]) && isset($_GET["status"]) && isset($_GET["id"]))
	{
		$mode = $_GET["mode"];
		$status = $_GET["status"];
		$id = $_GET["id"];
		$valid_modes = array('ATTRIB_STATUS', 'PROD_CAT_STATUS', 'SHOWCASE_STATUS', 'PROD_STATUS', 'PROD_PIC_STATUS', 'NEWS_STATUS', 'DC_STATUS', 'COUNTRY_STATUS', 'STATE_STATUS', 'COURIER_STATUS', 'COLOR_STATUS', 'PRODUCT_COLOR_STATUS', 'PRODUCT_COLOR_IMAGE_STATUS', 'COUPON_STATUS', 'COUPON_CODE_STATUS', 'OFFERSECTION_STATUS', 'PAGESECTION_STATUS', 'TAGS_STATUS', 'GIFTWRAPCARDS_STATUS','REVIEW_STATUS','OFFER_STATUS');
		if(in_array($mode, $valid_modes))
		{
			if($mode == 'ATTRIB_STATUS')
			{
				$pk_fld = 'iAttribID';
				$tbl = 'attribute';
				$msg = 'Attribute';
			}
			elseif($mode == 'PROD_CAT_STATUS')
			{
				$pk_fld = 'iPCatID';
				$tbl = 'prodcat';
				$msg = 'Product Category';
			}
			elseif($mode == 'SHOWCASE_STATUS')
			{
				$pk_fld = 'iPicID';
				$tbl = 'showcase';
				$msg = 'Showcase';
			}
			elseif($mode == 'PROD_STATUS')
			{
				$pk_fld = 'iProdID';
				$tbl = 'product';
				$msg = 'Product';
			}
			elseif($mode == 'PROD_PIC_STATUS')
			{
				$pk_fld = 'iProdImageID';
				$tbl = 'product_images';
				$msg = 'Product Images';
			}
			elseif($mode == 'NEWS_STATUS')
			{
				$pk_fld = 'iNewsID';
				$tbl = 'news';
				$msg = 'News & Event';
			}
			elseif($mode == 'DC_STATUS')
			{
				$pk_fld = 'iDCID';
				$tbl = 'daily_cartoon';
				$msg = 'Daily Cartoon';
			}
			elseif($mode == 'COUNTRY_STATUS')
			{
				$pk_fld = 'iCountryID';
				$tbl = 'country';
				$msg = 'Country';
			}
			elseif($mode == 'STATE_STATUS')
			{
				$pk_fld = 'iStateID';
				$tbl = 'state';
				$msg = 'State';
			}
			elseif($mode == 'COURIER_STATUS')
			{
				$pk_fld = 'iCourierID';
				$tbl = 'courier';
				$msg = 'Courier';
			}
			elseif($mode == 'COLOR_STATUS')
			{
				$pk_fld = 'iColorID';
				$tbl = 'color';
				$msg = 'Color';
			}
			elseif($mode == 'PRODUCT_COLOR_STATUS')
			{
				$pk_fld = 'iPCID';
				$tbl = 'product_color_assoc';
				$msg = 'Color';
			}
			elseif($mode == 'PRODUCT_COLOR_IMAGE_STATUS')
			{
				$pk_fld = 'iPCIID';
				$tbl = 'product_color_image_assoc';
				$msg = 'Color Image';
			}
			elseif($mode == 'COUPON_STATUS')
			{
				$pk_fld = 'iDiscCompID';
				$tbl = 'disc_campaign';
				$msg = 'Coupon Campaign Status';
			}
			elseif($mode == 'COUPON_CODE_STATUS')
			{
				$pk_fld = 'iDiscCoupID';
				$tbl = 'disc_coupon';
				$msg = 'Coupon Status';
			}
			elseif($mode == 'OFFERSECTION_STATUS')
			{
				$pk_fld = 'iOSecID';
				$tbl = 'offers_section';
				$msg = 'Offers Section';
			}
			elseif($mode == 'PAGESECTION_STATUS')
			{
				$pk_fld = 'iHPSecID';
				$tbl = 'homepage_section';
				$msg = 'Page Section';
			}
			elseif($mode == 'TAGS_STATUS')
			{
				$pk_fld = 'iTagID';
				$tbl = 'tags';
				$msg = 'Tags';
			}
			elseif($mode == 'GIFTWRAPCARDS_STATUS')
			{
				$pk_fld = 'iGWCardID';
				$tbl = 'giftwrap_cards';
				$msg = 'GiftWrap Cards';
			}
            elseif($mode == 'REVIEW_STATUS')
			{
                $pk_fld = 'review_id';
				$tbl = 'reviews';
				$msg = 'Reviews';
			}
          	elseif($mode == 'OFFER_STATUS')
			{
                $pk_fld = 'offerId';
				$tbl = 'product_offers';
				$msg = 'Product Offers';
			}

			$q = "update ".$tbl." set cStatus='$status' where ".$pk_fld."=".$id;
			$r = sql_query($q, 'AJX.367');
//			$result = '1~'.$q;
	
			if(sql_affected_rows())
			{
				$str = GetStatusImageString($mode, $status, $id);	
				$result = "$str~$msg Status Has Been Changed";
			}	// */

		}
	}
}
else if($response == 'UPDATE_FEATURED')
{
	if(isset($_GET["mode"]) && isset($_GET["status"]) && isset($_GET["id"]))
	{
		$mode = $_GET["mode"];
		$status = $_GET["status"];
		$id = $_GET["id"];

		$valid_modes = array('PROD_CAT_FEATURED', 'PROD_FEATURED', 'NEWS_FEATURED', 'PROD_CAT_TOPMENU', 'PROD_CAT_LEFTMENU');
		if(in_array($mode, $valid_modes))
		{
			if($mode == 'PROD_CAT_FEATURED')
			{
				$pk_fld = 'iPCatID';
				$ch_fld = 'cFeatured';
				$tbl = 'prodcat';
				$msg = 'Product Category';
			}
			elseif($mode == 'PROD_FEATURED')
			{
				$pk_fld = 'iProdID';
				$ch_fld = 'cFeatured';
				$tbl = 'product';
				$msg = 'Product';
			}
			elseif($mode == 'NEWS_FEATURED')
			{
				$pk_fld = 'iNewsID';
				$ch_fld = 'cFeatured';
				$tbl = 'news';
				$msg = 'News & Event';
			}
			elseif($mode == 'PROD_CAT_TOPMENU')
			{
				$pk_fld = 'iPCatID';
				$ch_fld = 'cTopMenu';
				$tbl = 'prodcat';
				$msg = 'Product Category';
			}
			elseif($mode == 'PROD_CAT_LEFTMENU')
			{
				$pk_fld = 'iPCatID';
				$ch_fld = 'cLeftMenu';
				$tbl = 'prodcat';
				$msg = 'Product Category';
			}
	
			$q = "update ".$tbl." set ".$ch_fld."='$status' where ".$pk_fld."=".$id;
			$r = sql_query($q, 'AJX.367');
			
//			$result = '1~'.$q;
	
			if(sql_affected_rows())
			{
				$str = GetFeaturedImageString($mode, $status, $id);	
				$result = "$str~$msg Feature Has Been Changed";
			}	// */
		}
	}
}
else if($response == 'UPDATE_FEATURED2')
{
	if(isset($_GET["mode"]) && isset($_GET["status"]) && isset($_GET["id"]))
	{
		$mode = $_GET["mode"];
		$status = $_GET["status"];
		$id = $_GET["id"];

		$valid_modes = array('PROD_CAT_SHIP', 'PROD_CAT_SHIPABROAD', 'PROD_NEW', 'PROD_BESTSELLER');
		if(in_array($mode, $valid_modes))
		{
			if($mode == 'PROD_CAT_SHIP')
			{
				$pk_fld = 'iPCatID';
				$ch_fld = 'cShippingIndia';
				$tbl = 'prodcat';
				$msg = 'Product Category Shipping in India';
			}
			elseif($mode == 'PROD_CAT_SHIPABROAD')
			{
				$pk_fld = 'iPCatID';
				$ch_fld = 'cShippingAbroad';
				$tbl = 'prodcat';
				$msg = 'Product Category Shipping Abroad';
			}
			elseif($mode == 'PROD_NEW')
			{
				$pk_fld = 'iProdID';
				$ch_fld = 'cLatest';
				$tbl = 'product';
				$msg = 'Product New';
			}
			elseif($mode == 'PROD_BESTSELLER')
			{
				$pk_fld = 'iProdID';
				$ch_fld = 'cBestSeller';
				$tbl = 'product';
				$msg = 'Product BestSeller';
			}
	
			$q = "update ".$tbl." set ".$ch_fld."='$status' where ".$pk_fld."=".$id;
			$r = sql_query($q, 'AJX.367');
			
//			$result = '1~'.$q;
	
			if(sql_affected_rows())
			{
				$str = GetFeaturedImageString2($mode, $status, $id);	
				$result = "$str~$msg Status Has Been Changed";
			}	// */
		}
	}
}
else if($response == 'PRODUCT_ATTRIB_FEATURED')
{
	if(isset($_GET["d_val"]) && isset($_GET["p_id"]) && isset($_GET["attrib_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$d_val = $_GET["d_val"];
		$p_id = $_GET["p_id"];
		$attrib_id = $_GET["attrib_id"];
		
		$q = "update product_attrib_assoc set cFeatured='$d_val' where iProdID=$p_id and iAttribID=$attrib_id";
		$r = sql_query($q, 'AJX.43');

		$result = '1';
	}
}
else if($response == 'PRODUCT_COLOR_FEATURED')
{
	if(isset($_GET["d_val"]) && isset($_GET["p_id"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$d_val = $_GET["d_val"];
		$p_id = $_GET["p_id"];
		$id = $_GET["id"];
		
		$q = "update product_color_assoc set cDefault='$d_val' where iProdID=$p_id and iPCID=$id";
		$r = sql_query($q, 'AJX.43');

		$result = '1';
	}
}
else if($response == 'PRODUCT_COLOR_IMAGE_FEATURED')
{
	if(isset($_GET["d_val"]) && isset($_GET["p_id"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$d_val = $_GET["d_val"];
		$p_id = $_GET["p_id"];
		$id = $_GET["id"];
		
		$q = "update product_color_image_assoc set cDefault='$d_val' where iProdID=$p_id and iPCIID=$id";
		$r = sql_query($q, 'AJX.43');

		$result = '1';
	}
}
else if($response == 'PRODUCT_ATTRIB_REMOVE')
{
	if(isset($_GET["p_id"]) && isset($_GET["attrib_id"]) && isset($_GET["pattrib_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$p_id = $_GET["p_id"];
		$pattrib_id = $_GET["pattrib_id"];
		$attrib_id = $_GET["attrib_id"];

		$q = "delete from product_attrib where iProdID=$p_id and iProdAttribID=$pattrib_id and iAttribID=$attrib_id";
		$r = sql_query($q, 'AJX.43');

		$result = '1';
	}
}
else if($response == 'COUPON_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update disc_campaign set cStatus='$status' where iDiscCompID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~Discount Coupon Status Has Been Changed";
		}
	}
}
else if($response == 'COUPON_CODE_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update disc_coupon set cStatus='$status' where iDiscCoupID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~Discount Coupon Code Status Has Been Changed";
		}
	}
}
else if($response == 'PAY_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["order_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["order_id"];

		$q = "update orders set cPaymentStatus='$status' where iOrdID=$id";
		$r = sql_query($q, 'AJX.43');

		$str = '<a style="cursor:pointer" onclick="GetCombo(\'P\','.$id.',\''.$status.'\');">'.$PAY_STATUS_ARR_EN[$status].'</a>';	
		$result = $str;
	}
}
else if($response == 'ORD_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["order_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["order_id"];

		$q = "update orders set cStatus='$status' where iOrdID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = '<a style="cursor:pointer" onclick="GetCombo(\'O\','.$id.',\''.$status.'\');">'.$ORD_STATUS_ARR_EN[$status].'</a>';	
			$result = $str;
		}
	}
}

else if($response == 'ORDER_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update orders set cStatus='$status' where iOrdID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~Order Status Has Been Changed";
		}
	}
}
else if($response == 'USER_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update users set cStatus='$status' where iUserID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~User Status Has Been Changed";
		}
	}
}
else if($response =='DELETE_ADDRESS')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];

		$q = "delete from member_address where iMAddrID=$id";
 		$r = ExecQuery($q, '_AJX.103');

		$result = "1~$id~$rank";
	}
}

////////////////////////// Rank /////////////////////////////
else if($response =='SLIDESHOW_RANK')
{
	if(isset($_GET["id"]) && isset($_GET["rank"]))
	{
		$id = $_GET["id"];
		$rank = $_GET["rank"];

		$q = "update slideshow set iRank=$rank where iSlideId=$id";
		$r = sql_query($q, '_AJX.327');

		$result = "1~$id~$rank";
	}
}
////////////////////////// quick add  ///////////////////////

else if($response == 'QUICKADD_ATTRIB')
{
	if(isset($_GET["name"]))
	{
		$attrib_name = trim($_GET["name"]);
		$pc_id = trim($_GET["pc_id"]);
				
		if($attrib_name!='')
		{
			$chk = GetXFromYID("select count(*) from attribute where vName='$attrib_name'");
			
			if(!$chk) // is a new class category
			{
				$attrib_id = NextID("iAttribID", "attribute");
				$txtrank = SetMinRank('attribute');
				
				$q = "insert into attribute values ($attrib_id, '$attrib_name', $txtrank, 'A')";
				$r = sql_query($q, 'AJX.138');

				$txtrank_pc = SetMinRank('prodcat_attrib','iPCatID='.$pc_id);
				$q_pc = "insert into prodcat_attrib values ($pc_id, $attrib_id, '$txtrank_pc', '', 'Y')";
				$r_pc = sql_query($q_pc, 'AJX.109');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKREMOVE_ATTRIB')
{
	if(isset($_GET["attrib_id"]) && isset($_GET['pc_id']))
	{
		$attrib_id = trim($_GET["attrib_id"]);
		$pc_id = trim($_GET["pc_id"]);
				
		if($attrib_id!='')
		{
			$q = "delete from prodcat_attrib where iPCatID=$pc_id and iAttribID=$attrib_id";
			$r = sql_query($q, 'AJX.138');
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKREMOVE_PRODUCTATTRIB')
{
	if(isset($_GET["attrib_id"]) && isset($_GET['p_id']))
	{
		$attrib_id = trim($_GET["attrib_id"]);
		$p_id = trim($_GET["p_id"]);
				
		if($attrib_id!='' && $p_id!='')
		{
			$q = "delete from product_attrib_assoc where iProdID=$p_id and iAttribID=$attrib_id";
			$r = sql_query($q, 'AJX.138');
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKREMOVE_PRODUCTCOLOR')
{
	if(isset($_GET["id"]) && isset($_GET['p_id']))
	{
		$id = trim($_GET["id"]);
		$p_id = trim($_GET["p_id"]);
				
		if($id!='' && $p_id!='')
		{
			$q = "delete from product_color_assoc where iProdID=$p_id and iPCID=$id";
			$r = sql_query($q, 'AJX.138');
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKREMOVE_PRODUCTCOLORIMAGE')
{
	if(isset($_GET["id"]) && isset($_GET['p_id']))
	{
		$id = trim($_GET["id"]);
		$p_id = trim($_GET["p_id"]);
				
		if($id!='' && $p_id!='')
		{
			$file_image = GetXFromYID("select vPic from product_color_image_assoc where iProdID=$p_id and iPCIID=$id");
			DeleteFile($file_image, PRODUCT_COLOR_IMAGE_UPLOAD);
			DeleteFile("sml_".$file_image, PRODUCT_COLOR_IMAGE_UPLOAD);
			DeleteFile("ts_".$file_image, PRODUCT_COLOR_IMAGE_UPLOAD);
					
			$q = "delete from product_color_image_assoc where iProdID=$p_id and iPCIID=$id";
			$r = sql_query($q, 'AJX.138');
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKASSOCIATE_ATTRIB_VAL')
{
	if(isset($_GET["attrib_id"]))
	{
		$attrib_id = trim($_GET["attrib_id"]);
		$pc_id = $_GET['pc_id'];
				
		if($attrib_id!='')
		{
			$chk = GetXFromYID("select count(*) from prodcat_attrib where iAttribID=".$attrib_id." and iPCatID=".$pc_id);
			
			if(!$chk) // is a new class category
			{
				$txtrank = SetMinRank('prodcat_attrib','iPCatID='.$pc_id);
				
				$q = "insert into prodcat_attrib values ($pc_id, $attrib_id, '$txtrank', '', 'Y')";
				$r = sql_query($q, 'AJX.109');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKADD_ATTRIB_VAL')
{
	if(isset($_GET["name"]))
	{
		$val_name = trim($_GET["name"]);
		$pc_id = $_GET['pc_id'];
		$a_id = $_GET['a_id'];
				
		if($val_name!='')
		{
			$chk = GetXFromYID("select count(*) from prodcat_attrib_dat where vName='$val_name' and iAttribID=".$a_id.' and iPCatID='.$pc_id);
			
			if(!$chk) // is a new class category
			{
				$attrib_val_id = NextID("iAttribDatID", "prodcat_attrib_dat");
				$txtrank = SetMinRank("prodcat_attrib_dat",'iAttribID='.$a_id.' and iPCatID='.$pc_id);

				$q = "insert into prodcat_attrib_dat values ($attrib_val_id, $a_id, '$pc_id', '$val_name', '$txtrank')";
				$r = sql_query($q, 'AJX.109');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKADD_PRODUCT_ATTRIB_VAL')
{
	if(isset($_GET["attrib_id"]) && isset($_GET['prod_id']))
	{
		$attrib_id = $_GET['attrib_id'];
		$prod_id = $_GET['prod_id'];
		$attribdat_id = trim($_GET["attribdat_id"]);
		$attrib_value = trim($_GET["attrib_value"]);
		$price_india = trim($_GET["price_india"]);
		$oprice_india = trim($_GET["oprice_india"]);
		$default =trim( $_GET['d_val']);
		
		$chk = GetXFromYID('select count(*) from product_attrib where iProdID='.$prod_id.' and iAttribID='.$attrib_id.' and iAttribDatID='.$attribdat_id.' and vValue="'.$attrib_value.'"');
		
		if(!$chk)
		{
			$prodattrib_id = NextID("iProdAttribID", "product_attrib");
			$q = "insert into product_attrib values ($prodattrib_id, $prod_id, $attrib_id, $attribdat_id, '$attrib_value', '$price_india', '$oprice_india', '$default', 'Y')";
			$r = sql_query($q,'AJX.679');

			if($default=='Y' && $price_india!=0)
			{
				$q_up = "update product set fPrice='".$price_india."', fOPrice='".$oprice_india."' where iProdID=".$prod_id;
				$r_up = sql_query($q_up,'UBP.611');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKADD_PRODUCT_ATTRIB')
{
	if(isset($_GET["prod_id"]) && isset($_GET['attrib_id']))
	{
		$attrib_id = $_GET['attrib_id'];
		$prod_id = $_GET['prod_id'];

		$chk = GetXFromYID('select count(*) from product_attrib_assoc where iProdID='.$prod_id.' and iAttribID='.$attrib_id);
		
		if(!$chk)
		{
			$txtrank = SetMinRank('product_attrib_assoc','iProdID='.$prod_id.' and iAttribID='.$attrib_id);
			$q = "insert into product_attrib_assoc values ($prod_id, $attrib_id, '$txtrank', 'N')";
			$r = sql_query($q,'AJX.679');
		}
		
		$result = '1';
	}
}
else if($response == 'QUICKADD_PRODUCT_COLOR')
{
	if(isset($_GET["prod_id"]) && isset($_GET['color_id']) && isset($_GET['size_id']) && isset($_GET['price']) && isset($_GET['offer_price']))
	{
		$size_id = $_GET['size_id'];
		$color_id = $_GET['color_id'];
		$prod_id = $_GET['prod_id'];
		$price = $_GET['price'];
		$offer_price = $_GET['offer_price'];

		$chk = GetXFromYID('select count(*) from product_color_assoc where iProdID='.$prod_id.' and iColorID='.$color_id.' and iProdAttribID='.$size_id);
		
		if(!$chk)
		{
			$pcid = NextID("iPCID","product_color_assoc");
			$txtrank = SetMinRank('product_color_assoc','iProdID='.$prod_id.' and iColorID='.$color_id);
			$q = "insert into product_color_assoc values ('$pcid', '$prod_id', '$color_id', '$price', '$offer_price', '$size_id', '$txtrank', 'N', 'A')";
			$r = sql_query($q,'AJX.679');
		}
		
		$result = '1';
	}
}
else if($response == 'PRODUCT_ATTRIB_DEFAULT')
{
	if(isset($_GET["d_val"]) && isset($_GET["pattrib_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$d_val = $_GET["d_val"];
		$p_id = $_GET["p_id"];
		$pattrib_id = $_GET["pattrib_id"];
		$attrib_id = $_GET["attrib_id"];
		
		$pp_str = GetIDString("select iProdAttribID from product_attrib where iProdID=".$p_id." and iAttribID=".$attrib_id);

		$q_u = "update product_attrib set cDefault='N' where iProdID=$p_id and iProdAttribID IN ($pp_str)";
		$r_u = sql_query($q_u, 'AJX.43');
		
		$q = "update product_attrib set cDefault='$d_val' where iProdAttribID=$pattrib_id";
		$r = sql_query($q, 'AJX.43');
		
		if($d_val=='Y')
		{
			$q_p = 'select fPrice, fOPrice from product_attrib where iProdID='.$p_id.' and iProdAttribID='.$pattrib_id;
			$r_p = sql_query($q_p,'FDP.3497');
			list($price,$offer_price) = sql_fetch_row($r_p);

			if($price!=0)
			{
				$q_up = "update product set fPrice='".$price."', fOPrice='".$offer_price."' where iProdID=".$p_id;
				$r_up = sql_query($q_up,'UBP.611');
			}
		}

		$result = '1';
	}
}
else if($response == 'PRODUCT_ATTRIB_STOCK')
{
	if(isset($_GET["d_val"]) && isset($_GET["pattrib_id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$d_val = $_GET["d_val"];
		$p_id = $_GET["p_id"];
		$pattrib_id = $_GET["pattrib_id"];
		$attrib_id = $_GET["attrib_id"];
		
		$pp_str = GetIDString("select iProdAttribID from product_attrib where iProdID=".$p_id." and iAttribID=".$attrib_id);

		$q = "update product_attrib set cStock='$d_val' where iProdAttribID=$pattrib_id";
		$r = sql_query($q, 'AJX.43');

		$result = '1';
	}
}
else if($response == 'EDIT_PRODUCT_ATTRIB_VAL')
{
	if(isset($_GET["pattrib_id"]))
	{
		$attrib_id = $_GET['attrib_id'];
		$prod_id = $_GET['prod_id'];
		$attribdat_id = trim($_GET["attribdat_id"]);
		$attrib_value = trim(db_input2($_GET["attrib_value"]));
		$price_india = trim($_GET["price_india"]);
		$oprice_india = trim($_GET["oprice_india"]);
		$pattrib_id = $_GET['pattrib_id'];

		$q_u = "update product_attrib set iAttribID='$attrib_id', iAttribDatID='$attribdat_id', vValue='$attrib_value', fPrice='$price_india', fOPrice='$oprice_india' where iProdID=$prod_id and iProdAttribID=$pattrib_id";
		$r_u = sql_query($q_u,'PSA_U.28');

		$default = GetXFromYID('select cDefault from product_attrib where iProdID='.$prod_id.' and iProdAttribID='.$pattrib_id);

		if($default=='Y' && $price_india!=0)
		{
			$q_up = "update product set fPrice='".$price_india."', fOPrice='".$oprice_india."' where iProdID=".$prod_id;
			$r_up = sql_query($q_up,'UBP.611');
		}

		$result = '1';
	}
}
else if($response == 'EDIT_ATTRIB_VAL')
{
	if(isset($_GET["attrib_id"]) && isset($_GET["attrib_datid"]) && isset($_GET["attrib_name"]))
	{
		$attrib_id = $_GET['attrib_id'];
		$attrib_datid = $_GET['attrib_datid'];
		$attrib_name = $_GET['attrib_name'];

		$q_u = "update prodcat_attrib_dat set vName='$attrib_name' where iAttribID=$attrib_id and iAttribDatID=$attrib_datid";
		$r_u = sql_query($q_u,'PSA_U.28');

		$result = '1';
	}
}
else if($response == 'QUICKASSOCIATE_PRODUCT')
{
	if(isset($_GET["p_cid"]) && isset($_GET['p_id']))
	{
		$p_cid = trim($_GET["p_cid"]);
		$p_id = $_GET['p_id'];
				
		if($p_cid!='')
		{
			$chk = GetXFromYID("select count(*) from product_assoc where iPPID=".$p_id." and iPCID=".$p_cid);
			
			if(!$chk) // is a new class category
			{
				$txtrank = SetMinRank('product_assoc','iPPID='.$p_id);
				
				$q = "insert into product_assoc values ($p_id, $p_cid, '$txtrank')";
				$r = sql_query($q, 'AJX.109');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'REMOVEPRODUCT_ASSOC')
{
	if(isset($_GET["p_cid"]) && isset($_GET['p_id']))
	{
		$p_cid = trim($_GET["p_cid"]);
		$p_id = $_GET['p_id'];
				
		if($p_cid!='')
		{
			$q = "delete from product_assoc where iPPID=$p_id and iPCID=$p_cid";
			$r = sql_query($q, 'AJX.109');
		}
		
		$result = '1';
	}
}
else if($response == 'GetProducts')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$result = FillData('', 'cmbprodid', 'COMBO', '0', 'iProductID,vName', 'product', 'iPTypeID='.$id.' and cStatus="A"', 'iRank');
		
	}
}

else if($response == 'QUICKADD_FLASHPRODUCT')
{
	if(isset($_GET["f_id"]) && isset($_GET["p_id"]) && isset($_GET["sale_price"]) && isset($_GET["o_price"]))
	{
		$f_id = trim($_GET["f_id"]);
		$p_id = trim($_GET["p_id"]);
		$sale_price = trim($_GET["sale_price"]);
		$o_price = trim($_GET["o_price"]);
				
		$exist = GetXFromYID('select count(*) from flash_dat where iFID='.$f_id.' and iProdID='.$p_id);		
		if(empty($exist) || $exist=='-1')
		{
			$dat_id = NextID("iFDatID", "flash_dat");

			$q = "insert into flash_dat values ($dat_id, '$f_id', $p_id, '$sale_price', '$o_price')";
			$r = sql_query($q, 'AJX.138');

			$result = '1';
		}
	}
}
else if($response == 'QUICKREMOVE_FLASHPRODUCT')
{
	if(isset($_GET['id']) && isset($_GET['f_id']))
	{
		$id = trim($_GET["id"]);
		$f_id = trim($_GET["f_id"]);
				
		if(!empty($id) && !empty($f_id))
		{
			$q = "delete from flash_dat where iFDatID=$id and iFID=$f_id";
			$r = sql_query($q, 'AJX.138');

			$result = '1';
		}
	}
}
else if($response == 'FLASH_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update flash set cStatus='$status' where iFID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~Flash Status Has Been Changed";
		}
	}
}
else if($response == 'COMPETITION_STATUS')
{
	if(isset($_GET["status"]) && isset($_GET["id"]))
	{
		$url = AJAX_INC_URL.'?response='.$response;
		$status = $_GET["status"];
		$id = $_GET["id"];

		$q = "update competition set cStatus='$status' where iCID=$id";
		$r = sql_query($q, 'AJX.43');

		if(sql_affected_rows())
		{
			$str = GetStatusImageString($url, $status, $id);	
			$result = "1~$str~Competition Status Has Been Changed";
		}
	}
}

elseif($response=='SWAP_OFFERSSECTION')
{
	if(isset($_GET['id_str']))
	{
		$id_str = $_GET['id_str'];
		$id_arr = explode(",",$id_str);
		$i=1;
		foreach($id_arr as $id)
		{
			if($id=='')
				continue;
				
			$q = "update offers_section set iRank='$i' where iOSecID='$id'";
			$r = sql_query($q,"AJX.1643");
			
			$i++;
		}
		$result = 1;
	}
}

elseif($response=='SWAP_PAGESECTION')
{
	if(isset($_GET['id_str']))
	{
		$id_str = $_GET['id_str'];
		$id_arr = explode(",",$id_str);
		$i=1;
		foreach($id_arr as $id)
		{
			if($id=='')
				continue;
				
			$q = "update homepage_section set iRank='$i' where iHPSecID='$id'";
			$r = sql_query($q,"AJX.1643");
			
			$i++;
		}
		$result = 1;
	}
}

else if($response == 'QUICKADD_PAGESECTIONPRODUCT')
{
	if(isset($_GET["h_id"]) && isset($_GET["p_id"]))
	{
		$h_id = trim($_GET["h_id"]);
		$p_id = trim($_GET["p_id"]);
				
		$exist = GetXFromYID('select count(*) from homepage_section_dat where iHPSecID='.$h_id.' and iProdID='.$p_id);		
		if(empty($exist) || $exist=='-1')
		{
			$dat_id = NextID("iHPSecDatID", "homepage_section_dat");

			$q = "insert into homepage_section_dat values ($dat_id, '$h_id', $p_id)";
			$r = sql_query($q, 'AJX.138');

			$result = '1';
		}
	}
}

else if($response == 'QUICKREMOVE_PAGESECTIONPRODUCT')
{
	if(isset($_GET['id']) && isset($_GET['h_id']))
	{
		$id = trim($_GET["id"]);
		$h_id = trim($_GET["h_id"]);
				
		if(!empty($id) && !empty($h_id))
		{
			$q = "delete from homepage_section_dat where iHPSecDatID=$id and iHPSecID=$h_id";
			$r = sql_query($q, 'AJX.138');

			$result = '1';
		}
	}
}
else if($response == 'QUICKASSOCIATE_PRODUCTTAG')
{
	if(isset($_GET["tag_id"]) && isset($_GET['p_id']))
	{
		$tag_id = trim($_GET["tag_id"]);
		$p_id = $_GET['p_id'];
				
		if($tag_id!='')
		{
			$chk = GetXFromYID("select count(*) from product_tag_assoc where iProdID=".$p_id." and iTagID=".$tag_id);
			if(!$chk) // is a new class category
			{
				$q = "insert into product_tag_assoc values ($p_id, $tag_id)";
				$r = sql_query($q, 'AJX.109');
			}
		}
		
		$result = '1';
	}
}
else if($response == 'REMOVEPRODUCTTAG_ASSOC')
{
	if(isset($_GET["tag_id"]) && isset($_GET['p_id']))
	{
		$tag_id = trim($_GET["tag_id"]);
		$p_id = $_GET['p_id'];
				
		if($tag_id!='')
		{
			$q = "delete from product_tag_assoc where iProdID=$p_id and iTagID=$tag_id";
			$r = sql_query($q, 'AJX.109');
		}
		
		$result = '1';
	}
}

else if($response == 'EDIT_PRODUCT_COLOR_ASSOC')
{
	if(isset($_GET['id']) && isset($_GET['prod_id']))
	{
		$id = $_GET['id'];
		$prod_id = $_GET['prod_id'];
		
		$q = 'select p.iColorID, p.fPrice, p.fOPrice, p.iProdAttribID, p.cDefault, p.cStatus, c.vName from product_color_assoc as p, color as c where p.iProdID='.$prod_id.' and p.iPCID='.$id.' and p.iColorID=c.iColorID order by p.iProdAttribID';
		$r = sql_query($q,'');
		if(sql_num_rows($r))
		{
			list($c_id,$c_price,$c_offerprice,$c_dat,$c_default,$c_status,$c_name) = sql_fetch_row($r);
			
			$str = '<td>'.$c_name.'</td>';
			$str .= '<td><input type="text" name="txtpca_price_'.$id.'" id="txtpca_price_'.$id.'" value="'.$c_price.'" class="mini_num" onblur="CheckRealNum(this);" /></td>';
			$str .= '<td><input type="text" name="txtpca_offerprice_'.$id.'" id="txtpca_offerprice_'.$id.'" value="'.$c_offerprice.'" class="mini_num" onblur="CheckRealNum(this);" /></td>';
			$str .= '<td>&nbsp;</td>';
			$str .= '<td>&nbsp;</td>';
			$str .= '<td><input type="button" name="btn_submit" value="Save" class="box button blue" onClick="SaveColorProductAsscoc(\''.$id.'\')"></td>';
			
			$result = $str;
		}
	}
}

else if($response == 'SAVE_PRODUCT_COLOR_ASSOC')
{
	if(isset($_GET["prod_id"]) && isset($_GET['id']) && isset($_GET['price']) && isset($_GET['offer_price']))
	{
		$id = $_GET['id'];
		$prod_id = $_GET['prod_id'];
		$price = $_GET['price'];
		$offer_price = $_GET['offer_price'];

		$q = "update product_color_assoc set fPrice='$price', fOPrice='$offer_price' where iPCID=$id and iProdID=$prod_id";
		$r = sql_query($q,'AJX.679');
		
		$result = '1';
	}
}

elseif($response=='SWAP_GIFTWRAPCARDS')
{
	if(isset($_GET['id_str']))
	{
		$id_str = $_GET['id_str'];
		$id_arr = explode(",",$id_str);
		$i=1;
		foreach($id_arr as $id)
		{
			if($id=='')
				continue;
				
			$q = "update giftwrap_cards set iRank='$i' where iGWCardID='$id'";
			$r = sql_query($q,"AJX.1643");
			
			$i++;
		}
		$result = 1;
	}
}

elseif($response=='SWAP_PRODUCTIMAGES')
{
	if(isset($_GET['id_str']) && isset($_GET['pID']))
	{
		$pID = $_GET['pID'];
		$id_str = $_GET['id_str'];
		$id_arr = explode(",",$id_str);
		$i=1;
		foreach($id_arr as $id)
		{
			if($id=='')
				continue;
				
			$q = "update product_images set iRank='$i' where iProdImageID='$id' and iProdID='$pID'";
			$r = sql_query($q,"AJX.1643");
			
			$i++;
		}
		$result = 1;
	}
}

echo $result;
exit;
?>