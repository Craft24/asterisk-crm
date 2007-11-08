<?php
/*******************************************************************************
* surveydetail.php
* 调查信息结果界面
* survey result interface

* Function Desc
	survey management

* Page elements
* div:		
									divNav
									formDiv	
									grid
									msgZone
									divSurveyStatistc
									divCopyright
* javascript function:		
									init	


* Revision 0.045  2007/10/1 12:55:00  modified by solo
* Desc: create page
* 描述: 建立
********************************************************************************/

require_once('surveyresult.common.php');
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
		}
		
		function searchFormSubmit(numRows,limit){
			//alert(xajax.getFormValues("searchForm"));
			xajax_searchFormSubmit(xajax.getFormValues("searchForm"),numRows,limit);
			return false;
		}
		//-->
		</SCRIPT>

		<script language="JavaScript" src="js/astercrm.js"></script>
		<script type="text/javascript" src="js/dragresize.js"></script>
		<script type="text/javascript" src="js/dragresizeInit.js"></script>

	<LINK href="skin/default/css/dragresize.css" type=text/css rel=stylesheet>
	<LINK href="skin/default/css/style.css" type=text/css rel=stylesheet>

	</head>
	<body onload="init();">
	<div id="divNav"></div>
	<br>
	<table width="100%" border="0" style="background: #F9F9F9; padding: 0px;">
		<tr>
			<td style="padding: 0px;">
				<fieldset>
					<div id="formDiv" class="formDiv"></div>
					<div id="grid" align="center"> </div>
					<div id="msgZone" name="msgZone" align="left"> </div>
					<div id="divSurveyStatistc" align="divSurveyStatistc"> </div>
				</fieldset>
			</td>
		</tr>
	</table>
	<div id="divCopyright"></div>
	</body>
</html>