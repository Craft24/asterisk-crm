<?php
/*******************************************************************************
* clidcdr.php

* clidcdr查询界面文件
* clid interface

* 功能描述
	提供clidcdr查询界面

* Page elements

* div:							
				divNav				show management function list
				grid				show CDR grid
				msgZone				show action result
				divCopyright		show copyright

* javascript function:		

				init				page onload function			 

********************************************************************************/

require_once('clidcdr.common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?php $xajax->printJavascript('include/'); ?>
		<meta http-equiv="Content-Language" content="utf-8" />
		<SCRIPT LANGUAGE="JavaScript">
		<!--

			function init(){
				xajax_init();
				dragresize.apply(document);
			}

		function searchFormSubmit(numRows,limit,id,type){
			//alert(xajax.getFormValues("searchForm"));
			xajax_searchFormSubmit(xajax.getFormValues("searchForm"),numRows,limit,id,type);
			return false;
		}

		//-->
		</SCRIPT>
		<script type="text/javascript" src="js/dragresize.js"></script>
		<script type="text/javascript" src="js/dragresizeInit.js"></script>
		<script type="text/javascript" src="js/astercrm.js"></script>
		<LINK href="skin/default/css/style.css" type=text/css rel=stylesheet>
		<LINK href="skin/default/css/dragresize.css" type=text/css rel=stylesheet>

	</head>
	<body onload="init();">
		<div id="divNav"></div><br>
	<table width="100%" border="0" style="background: #F9F9F9; padding: 0px;">
		<tr>
			<td style="padding: 0px;">
				<fieldset>
		<div id="formDiv"  class="formDiv drsElement" 
			style="left: 450px; top: 50px;"></div>
		<div id="grid" name="grid" align="center"> </div>
		<div id="msgZone" name="msgZone" align="left"> </div>
				</fieldset>
			</td>
		</tr>
	</table>

		<div id="divCopyright"></div>
	</body>
</html>
