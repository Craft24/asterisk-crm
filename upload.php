<?php
header("content-type:text/html;charset=utf-8");
session_start();
require_once ('include/Localization.php');
$GLOBALS['locate']=new Localization($_SESSION['curuser']['country'],$_SESSION['curuser']['language'],'csv');

include_once('config.php');

if(isset($_POST['CHECK']) && trim($_POST['CHECK']) == '1'){
	$upload_msg = $_FILES['image']['type'];
	$mime = explode(",", UPLOAD_IMAGE_MIME);
	$is_vaild = 0;
	
	foreach ($mime as $type){
		if($_FILES['image']['type'] == $type){
			$is_vaild = 1;
			//break;
		}
	}

	//if ($is_vaild && $_FILES['image']['size']<=UPLOAD_IMAGE_SIZE && $_FILES['image']['size']>0)
	//{
		if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_IMAGE_PATH . $_FILES['image']['name'])) 
		{
			$upload_msg =$locate->Translate('file').$_FILES['image']['name']."$locate->Translate('uploadsuccess')！<br />";
			$handleup = fopen(UPLOAD_IMAGE_PATH . $_FILES['image']['name'],"r");
			$row = 0;
			while($data = fgetcsv($handleup, 1000, ",")){
			   $row++;
			}
			$upload_msg .= " <font color='red'>$locate->Translate('have')".$row."$locate->Translate('default')</font>";
			//$upload_msg .= '<br />';
			//$upload_msg .= 'vv'.$data;
			$_SESSION['filename'] = $_FILES['image']['name'];  //新传的文件名做为session
			//$upload_msg =$_SESSION['filename'];
		} 
		else 
		{
			$upload_msg = $locate->Translate('failed');
		}
}
/*}
else
{
	$upload_msg = "上传文件失败，可能是文件超过". UPLOAD_IMAGE_SIZE_KB ."KB、或者文件文件为空、或文件格式不正确";
}*/

if($upload_msg != "")
	$upload_js_function="callbackMessage(\"$upload_msg\");";
else
	$upload_js_function="";


include("template.php");

$t=new Template('./template/');
$t->caching = false;
//$t->unknowns = "keep";
$t->left_delimiter = "[##";
$t->right_delimiter = "##]";

$t->set_file("upload", "upload.tpl");
$t->set_var(array("upload_js_function"=> $upload_js_function));
$t->parse("uploadout","upload");
$t->p("uploadout");
?>