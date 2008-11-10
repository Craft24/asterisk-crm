<?php
/*******************************************************************************
* checkout.common.php
* checkout参数信息文件
* checkout parameter file

* 功能描述

* Function Desc
	authority
	initialize localization class
	initialize xajax class
	define xajaxGrid parameters

registed function:
*	call these function by xajax_ + funcionname
*	such as xajax_init()

	init					init html page

* Revision 0.01  2007/11/21 15:25:00  modified by solo
* Desc: page created

********************************************************************************/

header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: post-check=0, pre-check=0',false);
header('Pragma: no-cache');
session_cache_limiter('public, no-store');

session_set_cookie_params(0);
if (!session_id()) session_start();
setcookie('PHPSESSID', session_id());


if ($_SESSION['curuser']['usertype'] != 'admin' && $_SESSION['curuser']['usertype'] != 'reseller' && $_SESSION['curuser']['usertype'] != 'groupadmin' && $_SESSION['curuser']['usertype'] != 'operator') {
	header("Location: systemstatus.php");
}
require_once ('include/localization.class.php');

$GLOBALS['locate']=new Localization($_SESSION['curuser']['country'],$_SESSION['curuser']['language'],'checkout');

require_once ("include/xajax.inc.php");

$xajax = new xajax("checkout.server.php");
$xajax->waitCursorOff();

$xajax->registerFunction("init");
$xajax->registerFunction("listCDR");
$xajax->registerFunction("checkOut");
$xajax->registerFunction("setGroup");
$xajax->registerFunction("setClid");
?>