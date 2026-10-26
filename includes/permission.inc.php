<?php
function GetUserPermissionArr($user_id, $user_level = '9')
{
	$arr = array('ATTRIB'=>'A', 'PROD_CAT'=>'A', 'PRODUCT'=>'A', 'SLIDES'=>'A', 'NEWS'=>'A', 'STATIC'=>'A', 'CFG'=>'X');
	
	if(empty($user_id) && is_numeric($user_id) && empty($user_level) && is_numeric($user_level))
		$arr = array('ATTRIB'=>'A', 'PROD_CAT'=>'A', 'PRODUCT'=>'A', 'SLIDES'=>'A', 'NEWS'=>'A', 'STATIC'=>'A', 'CFG'=>'A');
	else if($user_level=='3')
		$arr = array('ATTRIDB'=>'A', 'BRAND'=>'A', 'PROD'=>'A', 'COUP'=>'A', 'ORD'=>'A', 'SLIDES'=>'A', 'USP_BAR'=>'A', 'STATIC'=>'A', 'CFG'=>'X');
		
	return $arr;
}

function IsModuleAccessible($module)
{
	global $sess_user_access;
	$status = false;
	
	if(is_numeric($module) || (isset($sess_user_access[$module]) && $sess_user_access[$module]!='X'))
		$status = true;

	return $status;
}

function GetModulePermission($_file_module)
{
	global $sess_user_access;	
	$permission = (isset($sess_user_access[$_file_module]))? $sess_user_access[$_file_module]: 'X';
	return $permission;
}

function SetPageAccess($flag='')
{
	global $logged, $_file_module;

	if(!$logged || !IsModuleAccessible($_file_module))
	{
		if($flag=='INCLUDE')
		{
			echo INVALID_ACCESS;
			exit;
		}
		else
			GetOut();
	}
	
	$module_access = GetModulePermission($_file_module);

	if($flag == 'EDIT' && !IsThisModuleEdit($module_access))
		GoHome(MODULE_EDIT_DENIED);
		
	return $module_access;
}

function IsModuleView()
{
	global $module_access;
	return ($module_access!='X')? true: false;
}

function IsModuleEdit()
{
	global $module_access;
	return true; // ($module_access=='A')? true: false;
}

function IsThisModuleEdit($module_access)
{	
	return ($module_access=='A')? true: false;
}

function ConfirmLocID($loc_id)
{
	if(!empty($loc_id) && $loc_id != SYS_LOCID)
		GoHome();
}
?>
