<?php
/*******************************************************************************
* contact.common.php
* contact参数信息文件
* contact parameter file

* 功能描述
	检查用户权限
	初始化语言变量
	初始化xajax类
	预定义xajaxGrid中需要使用的一些参数

* Function Desc
	authority
	initialize localization class
	initialize xajax class
	define xajaxGrid parameters

registed function:
*	call these function by xajax_ + funcionname
*	such as xajax_init()

	init				init html page
	showGrid
	add					show contact add form
	edit				show contact edit form
	delete				delete a contact
	save				save contact information
	update				update contact information
	editField			change table cell to input box
	updateField			update editField when it lost focus
	showDetail			show contact information
	showContact			show contact information 
	showCustomer		show customer information
	showNote			show note information 
	surveyAdd			show survey add form
	saveSurvey			save survey result
	confirmCustomer
	confirmContact

* Revision 0.0456  2007/10/25 15:20:00  modified by solo
* Desc: add confirmCustomer,confirmContact function

* Revision 0.045  2007/10/23 21:50:00  modified by solo
* Desc: add surveyAdd,saveSurvey function

* Revision 0.045  2007/10/22 16:45:00  modified by solo
* Desc: delete importCSV,export function

* Revision 0.045  2007/10/18 14:16:00  modified by solo
* Desc: change localization file to astercrm

* Revision 0.045  2007/10/18 13:20:00  modified by solo
* Desc: comment added

* Revision 0.0443  2007/09/29 15:25:00  modified by solo
* Desc: page create
* 描述: 页面建立

********************************************************************************/

header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: post-check=0, pre-check=0',false);
header('Pragma: no-cache');
session_cache_limiter('public, no-store');

session_set_cookie_params(0);
if (!session_id()) session_start();
setcookie('PHPSESSID', session_id());


if ($_SESSION['curuser']['extension'] == '' or  $_SESSION['curuser']['usertype'] != 'admin') 
	header("Location: portal.php");

require_once ("include/xajax.inc.php");
require_once ('include/localization.class.php');

$GLOBALS['locate']=new Localization($_SESSION['curuser']['country'],$_SESSION['curuser']['language'],'astercrm');

$xajax = new xajax("contact.server.php");

$xajax->registerFunction("init");
$xajax->registerFunction("showGrid");
$xajax->registerFunction("add");
$xajax->registerFunction("edit");
$xajax->registerFunction("delete");
$xajax->registerFunction("save");
$xajax->registerFunction("update");
$xajax->registerFunction("editField");
$xajax->registerFunction("updateField");
$xajax->registerFunction("showDetail");
$xajax->registerFunction("showContact");
$xajax->registerFunction("showCustomer");
$xajax->registerFunction("showNote");
$xajax->registerFunction("saveSurvey");
$xajax->registerFunction("surveyAdd");
$xajax->registerFunction("confirmCustomer");
$xajax->registerFunction("confirmContact");
$xajax->registerFunction("searchFormSubmit");


define(LOG_ENABLED, $config['system']['log_enabled']); // Enable debuggin
define(FILE_LOG, $config['system']['log_file_path']);  // File to debug.
//define(ENABLE_CONTACT, $config['system']['enable_contact']);  // Enable contact
define(ROWSXPAGE, 5); // Number of rows show it per page.
define(MAXROWSXPAGE, 25);  // Total number of rows show it when click on "Show All" button.
?>