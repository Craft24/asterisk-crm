<?php
/*******************************************************************************
* upload.php
* 上传excel文件
* upload excel file
* 功能描述
* Function Desc
	上传csv、xls格式文件


* Revision 0.045  2007/10/22 13:34:00  modified by yunshida
* Desc: 
* 描述: 取消了使用模板

* Revision 0.045  2007/10/22   modified by yunshida
* Desc: page create
* 描述: 页面建立
  
********************************************************************************/
header("content-type:text/html;charset=utf-8");
session_start();
require_once ('include/localization.class.php');
require_once ("include/excel.class.php");
include_once('config.php');

$GLOBALS['locate']=new Localization($_SESSION['curuser']['country'],$_SESSION['curuser']['language'],'import');
if(isset($_POST['CHECK']) && trim($_POST['CHECK']) == '1'){
	$upload_msg = '';
	$upload_type = $_FILES['excel']['type'];
	$is_vaild = 0;
	if ( "application/vnd.ms-excel" == $upload_type)
	{
		$file_name = $_FILES['excel']['name'];
		$type = substr($file_name,-4);
		if (move_uploaded_file($_FILES['excel']['tmp_name'], $config['system']['upload_excel_path'] . $_FILES['excel']['name'])) 
		{
			$upload_msg =$locate->Translate('file').' '.$_FILES['excel']['name'].' '.$locate->Translate('uploadsuccess')."!<br />";
			if($type == '.csv'){
				$handleup = fopen($config['system']['upload_excel_path'] . $_FILES['excel']['name'],"r");
				$row = 0;
				while($data = fgetcsv($handleup, 1000, ",")){
				   $row++;
				}
				if($row > 8){
					$upload_msg .= " <font>".$locate->Translate('have').' '.$row.' '.$locate->Translate('default')."</font>";
				}else{
					$upload_msg .= " <font>".$locate->Translate('have').' '.$row.' '.$locate->Translate('recrod')."</font>";
				}
			}elseif($type == '.xls'){
				Read_Excel_File($config['system']['upload_excel_path'] . $_FILES['excel']['name'],$return);
				$xlsrow = count($return[Sheet1]);
				if($xlsrow > 8){
					$upload_msg .= " <font>".$locate->Translate('have').' '.$xlsrow.' '.$locate->Translate('default')."</font>";
				}else{
					$upload_msg .= " <font>".$locate->Translate('have').' '.$xlsrow.' '.$locate->Translate('recrod')."</font>";
				}
			}
				$_SESSION['filename'] = $_FILES['excel']['name'];  //新传的文件名做为session
		} 
		else 
		{
			$upload_msg = $locate->Translate('failed');  //失败提示
		}
	}else{
		$upload_msg .= $locate->Translate('cantup');  //失败提示
	}
}
else
{
	$upload_msg = $locate->Translate('failed');
}

?>
<SCRIPT LANGUAGE="JavaScript">
	var msg = "<? echo $upload_msg; ?><br />";
	window.parent.document.getElementById("divMessage").innerHTML = msg;//msg;
	window.parent.showDivMainRight();
</SCRIPT>