<?php
/*******************************************************************************
* cdr.server.php

* CDR 系统后台文件
* cdr showed script

* 功能描述
	提供 cdr 查询脚本

* Function Desc
		init				初始化页面元素
		showGrid			显示grid
		createGrid			生成grid的HTML代码
		searchFormSubmit    根据提交的搜索信息重构显示页面

********************************************************************************/

require_once ("db_connect.php");
require_once ('cdr.grid.inc.php');
require_once ('include/xajaxGrid.inc.php');
require_once ('include/astercrm.class.php');
require_once ('include/common.class.php');
require_once ("cdr.common.php");

/**
*  initialize page elements
*
*/

function init(){
	global $locate;

	$objResponse = new xajaxResponse();
	$objResponse->addAssign("divNav","innerHTML",common::generateManageNav($skin));
	$objResponse->addAssign("divCopyright","innerHTML",common::generateCopyright($skin));
	$objResponse->addScript("xajax_showGrid(0,".ROWSXPAGE.",'','','')");

	return $objResponse;
}

/**
*  show grid HTML code
*  @param	start		int			record start
*  @param	limit		int			how many records need
*  @param	filter		string		the field need to search
*  @param	content		string		the contect want to match
*  @param	divName		string		which div grid want to be put
*  @param	order		string		data order
*  @param	stype		string		the matching type for search 
*  @return	objResponse	object		xajax response object
*/

function showGrid($start = 0, $limit = 1,$filter = null, $content = null, $order = null, $divName = "grid", $ordering = "",$stype = null){
	$html .= createGrid($start, $limit,$filter, $content, $stype, $order, $divName, $ordering);
	$objResponse = new xajaxResponse();
	$objResponse->addClear("msgZone", "innerHTML");
	$objResponse->addAssign($divName, "innerHTML", $html);

	return $objResponse;
}


/**
*  generate grid HTML code
*  @param	start		int			record start
*  @param	limit		int			how many records need
*  @param	filter		string		the field need to search
*  @param	content		string		the contect want to match
*  @param	stype		string		the matching type for search 
*  @param	divName		string		which div grid want to be put
*  @param	order		string		data order
*  @return	html		string		grid HTML code
*/

function createGrid($start = 0, $limit = 1, $filter = null, $content = null, $order = null, $divName = "grid", $ordering = "",$stype=array()){
	global $locate,$config;
	if($config['system']['useHistoryCdr'] == 1) $table='historycdr';
	else $table='mycdr';
//	echo $config['system']['useHistoryCdr'];
//	echo $table;exit;
	$_SESSION['ordering'] = $ordering;
	if($filter == null || $content == null || (!is_array($content) && $content == 'Array') || (!is_array(filter) && $filter == 'Array')){
		$content = null;
		$filter = null;
		$numRows =& Customer::getNumRows($table);
		$arreglo =& Customer::getAllRecords($start,$limit,$order,'',$table);
	}else{
		foreach($content as $value){
			if(trim($value) != ""){  //搜索内容有值
				$flag = "1";
				break;
			}
		}
		foreach($filter as $value){
			if(trim($value) != ""){  //搜索条件有值
				$flag2 = "1";
				break;
			}
		}
		foreach($stype as $value){
			if(trim($value) != ""){  //搜索方式有值
				$flag3 = "1";
				break;
			}
		}
		if($flag != "1" || $flag2 != "1" ){  //无值	
			$order = null;
			$numRows =& Customer::getNumRows($table);
			$arreglo =& Customer::getAllRecords($start,$limit,$order,'',$table);
		}elseif($flag3 != 1 ){  //未选择搜索方式
			$order = "calldate";
			$numRows =& Customer::getNumRowsMore($filter, $content,$table);
			$arreglo =& Customer::getRecordsFilteredMore($start, $limit, $filter, $content, $order,$table);
		}else{
			$order = "calldate";
			$numRows =& Customer::getNumRowsMorewithstype($filter, $content,$stype,$table);
			$arreglo =& Customer::getRecordsFilteredMorewithstype($start, $limit, $filter, $content, $stype,$order,$table);
		}
	}	

	// Editable zone

	// Databse Table: fields
	$fields = array();
	$fields[] = 'calldate';
	$fields[] = 'src';
	$fields[] = 'dst';
	$fields[] = 'duration';
	$fields[] = 'billsec';
	$fields[] = 'disposition';
	$fields[] = 'credit';
	$fileds[] = 'destination';
	$fileds[] = 'memo';

	// HTML table: Headers showed
	$headers = array();
	$headers[] = $locate->Translate("Calldate");
	$headers[] = $locate->Translate("Src");
	$headers[] = $locate->Translate("Dst");
	$headers[] = $locate->Translate("Duration");
	$headers[] = $locate->Translate("Billsec");
	$headers[] = $locate->Translate("Disposition");
	$headers[] = $locate->Translate("credit");
	$headers[] = $locate->Translate("destination");
	$headers[] = $locate->Translate("memo");

	// HTML table: hearders attributes
	$attribsHeader = array();
	$attribsHeader[] = 'width="13%"';
	$attribsHeader[] = 'width="10%"';
	$attribsHeader[] = 'width="13%"';
	$attribsHeader[] = 'width="10%"';
	$attribsHeader[] = 'width="10%"';
	$attribsHeader[] = 'width="12%"';
	$attribsHeader[] = 'width="10%"';
	$attribsHeader[] = 'width="12%"';
	$attribsHeader[] = 'width="10%"';

	// HTML Table: columns attributes
	$attribsCols = array();
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';
	$attribsCols[] = 'style="text-align: left"';

	// HTML Table: If you want ascendent and descendent ordering, set the Header Events.
	$eventHeader = array();
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","calldate","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","src","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","dst","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","duration","'.$divName.'","ORDERING");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","billsec","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","disposition","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","credit","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","destination","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	$eventHeader[]= 'onClick=\'xajax_showGrid(0,'.$limit.',"'.$filter.'","'.$content.'","memo","'.$divName.'","ORDERING","'.$stype.'");return false;\'';
	
	// Select Box: type table.
	$typeFromSearch = array();
	$typeFromSearch[] = 'like';
	$typeFromSearch[] = 'equal';
	$typeFromSearch[] = 'more';
	$typeFromSearch[] = 'less';

	// Selecct Box: Labels showed on searchtype select box.
	$typeFromSearchShowAs = array();
	$typeFromSearchShowAs[] = 'like';
	$typeFromSearchShowAs[] = '=';
	$typeFromSearchShowAs[] = '>';
	$typeFromSearchShowAs[] = '<';

	// Select Box: fields table.
	$fieldsFromSearch = array();
	$fieldsFromSearch[] = 'src';
	$fieldsFromSearch[] = 'calldate';
	$fieldsFromSearch[] = 'dst';
	$fieldsFromSearch[] = 'billsec';
	$fieldsFromSearch[] = 'disposition';
	$fieldsFromSearch[] = 'credit';
	$fieldsFromSearch[] = 'destination';
	$fieldsFromSearch[] = 'memo';

	// Selecct Box: Labels showed on search select box.
	$fieldsFromSearchShowAs = array();
	$fieldsFromSearchShowAs[] = $locate->Translate("src");
	$fieldsFromSearchShowAs[] = $locate->Translate("calldate");
	$fieldsFromSearchShowAs[] = $locate->Translate("dst");
	$fieldsFromSearchShowAs[] = $locate->Translate("billsec");
	$fieldsFromSearchShowAs[] = $locate->Translate("disposition");
	$fieldsFromSearchShowAs[] = $locate->Translate("credit");
	$fieldsFromSearchShowAs[] = $locate->Translate("destination");
	$fieldsFromSearchShowAs[] = $locate->Translate("memo");

	// Create object whit 5 cols and all data arrays set before.
	$tableGrid = new ScrollTable(9,$start,$limit,$filter,$numRows,$content,$order);
	$tableGrid->setHeader('title',$headers,$attribsHeader,$eventHeader,$edit=false,$delete=false,$detail=false);
	$tableGrid->setAttribsCols($attribsCols);
	$tableGrid->addRowSearchMore($table,$fieldsFromSearch,$fieldsFromSearchShowAs,$filter,$content,$start,$limit,0,$typeFromSearch,$typeFromSearchShowAs,$stype);

	while ($arreglo->fetchInto($row)) {
	// Change here by the name of fields of its database table
		$rowc = array();
		$rowc[] = $row['id'];
		$rowc[] = $row['calldate'];
		$rowc[] = $row['src'];
		$rowc[] = $row['dst'];
		$rowc[] = $row['duration'];
		$rowc[] = $row['billsec'];
		$rowc[] = $row['disposition'];
		$rowc[] = $row['credit'];
		$rowc[] = $row['destination'];
		$rowc[] = $row['memo'];
		$tableGrid->addRow($table,$rowc,false,false,false,$divName,$fields);
 	}
 	
 	// End Editable Zone
 	
 	$html = $tableGrid->render();
 	
 	return $html;
}


function searchFormSubmit($searchFormValue,$numRows,$limit,$id,$type){
	global $locate,$db;
	$objResponse = new xajaxResponse();
	$searchField = array();
	$searchContent = array();
	$searchType = array();
	$searchContent = $searchFormValue['searchContent'];  //搜索内容 数组
	$searchField = $searchFormValue['searchField'];      //搜索条件 数组
	$searchType =  $searchFormValue['searchType'];			//搜索方式 数组
	$divName = "grid";
	if($type == "delete"){
		$res = '';
		if ($res){
			$html = createGrid($searchFormValue['numRows'], $searchFormValue['limit'],$searchField, $searchContent, $searchField, $divName, "",$searchType);
			$objResponse = new xajaxResponse();
			$objResponse->addAssign("msgZone", "innerHTML", $locate->Translate("delete_rec")); 
		}else{
			$objResponse->addAssign("msgZone", "innerHTML", $locate->Translate("rec_cannot_delete")); 
		}
	}else{
		$html = createGrid($numRows, $limit,$searchField, $searchContent,  $searchField[count($searchField)-1], $divName, "",$searchType);
	}
	$objResponse->addClear("msgZone", "innerHTML");
	$objResponse->addAssign($divName, "innerHTML", $html);
	return $objResponse->getXML();
}

$xajax->processRequests();
?>