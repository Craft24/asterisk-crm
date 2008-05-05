<?
/*******************************************************************************
* survey.grid.inc.php
* survey操作类
* Customer class

* @author			Solo Fu <solo.fu@gmail.com>
* @classVersion		1.0
* @date				18 Oct 2007

* Functions List

	getAllRecords				获取所有记录
	getRecordsFiltered			获取记录集
	getNumRows					获取记录集条数
	formAdd						生成添加survey的HTML语句
	insertNewSurvey				保存survey
	insertNewOption				保存option
	setSurveyEnable				设定survey的可用情况

* Revision 0.0456  2007/11/6 20:30:00  last modified by solo
* Desc: remove function deleteSurvey

* Revision 0.045  2007/10/18 13:30:00  last modified by solo
* Desc: page created

********************************************************************************/
require_once 'db_connect.php';
require_once 'survey.common.php';
require_once 'include/astercrm.class.php';

class Customer extends astercrm
{

	/**
	*  Obtiene todos los registros de la tabla paginados.
	*
	*  	@param $start	(int)	Inicio del rango de la p&aacute;gina de datos en la consulta SQL.
	*	@param $limit	(int)	L&iacute;mite del rango de la p&aacute;gina de datos en la consultal SQL.
	*	@param $order 	(string) Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res 	(object) Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/
	function &getAllRecords($start, $limit, $order = null, $creby = null){
		global $db;

		$sql = "SELECT survey.*, groupname FROM survey LEFT JOIN astercrm_accountgroup ON astercrm_accountgroup.groupid = survey.groupid ";

		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$sql .= " ";
		}else{
			$sql .= " WHERE survey.groupid = ".$_SESSION['curuser']['groupid']." ";
		}

		if($order == null){
			$sql .= " ORDER BY cretime DESC LIMIT $start, $limit";//.$_SESSION['ordering'];
		}else{
			$sql .= " ORDER BY $order ".$_SESSION['ordering']." LIMIT $start, $limit";
		}

		Customer::events($sql);
		$res =& $db->query($sql);
		return $res;
	}

	/**
	*  Obtiene todos registros de la tabla paginados y aplicando un filtro
	*
	*  @param $start		(int) 		Es el inicio de la p&aacute;gina de datos en la consulta SQL
	*	@param $limit		(int) 		Es el limite de los datos p&aacute;ginados en la consultal SQL.
	*	@param $filter		(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $content 	(string)	Contenido a filtrar en la conslta SQL.
	*	@param $order		(string) 	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $res		(object)	Objeto que contiene el arreglo del resultado de la consulta SQL.
	*/

	function &getRecordsFilteredMore($start, $limit, $filter, $content, $order,$table, $ordering = ""){
		global $db;

		$i=0;
		$joinstr='';
		foreach ($content as $value){
			$value=trim($value);
			if (strlen($value)!=0 && strlen($filter[$i]) != 0){
				$joinstr.="AND $filter[$i] like '%".$value."%' ";
			}
			$i++;
		}

		$sql = "SELECT survey.*, groupname FROM survey LEFT JOIN astercrm_accountgroup ON astercrm_accountgroup.id = survey.groupid WHERE ";
		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$sql .= " 1 ";
		}else{
			$sql .= " survey.groupid = ".$_SESSION['curuser']['groupid']." ";
		}

		if ($joinstr!=''){
			$joinstr=ltrim($joinstr,'AND'); //去掉最左边的AND
			$sql .= " AND ".$joinstr."  "
					." ORDER BY ".$order
					." ".$_SESSION['ordering']
					." LIMIT $start, $limit $ordering";
		}
		Customer::events($sql);
		$res =& $db->query($sql);
		return $res;
	}

	function &getNumRowsMore($filter = null, $content = null,$table){
		global $db;
		
			$i=0;
			$joinstr='';
			foreach ($content as $value){
				$value=trim($value);
				if (strlen($value)!=0 && strlen($filter[$i]) != 0){
					$joinstr.="AND $filter[$i] like '%".$value."%' ";
				}
				$i++;
			}

			$sql = "SELECT COUNT(*) FROM survey LEFT JOIN astercrm_accountgroup ON astercrm_accountgroup.id = survey.groupid WHERE ";
			if ($_SESSION['curuser']['usertype'] == 'admin'){
				$sql .= " ";
			}else{
				$sql .= " survey.groupid = ".$_SESSION['curuser']['groupid']." AND ";
			}

			if ($joinstr!=''){
				$joinstr=ltrim($joinstr,'AND'); //去掉最左边的AND
				$sql .= " ".$joinstr;
			}else {
				$sql .= " 1";
			}
		Customer::events($sql);
		$res =& $db->getOne($sql);
//		print $sql;
//		print "\n";
//		print $res;
//		exit;
		return $res;
	}


	/**
	*  Devuelte el numero de registros de acuerdo a los par&aacute;metros del filtro
	*
	*	@param $filter	(string)	Nombre del campo para aplicar el filtro en la consulta SQL
	*	@param $order	(string)	Campo por el cual se aplicar&aacute; el orden en la consulta SQL.
	*	@return $row['numrows']	(int) 	N&uacute;mero de registros (l&iacute;neas)
	*/
	
	function &getNumRows($filter = null, $content = null){
		global $db;
		
		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$sql = " SELECT COUNT(*) FROM survey LEFT JOIN astercrm_accountgroup ON astercrm_accountgroup.id = survey.groupid";
		}else{
			$sql = " SELECT COUNT(*) FROM survey LEFT JOIN astercrm_accountgroup ON astercrm_accountgroup.id = survey.groupid WHERE survey.groupid = ".$_SESSION['curuser']['groupid']." ";
		}

		Customer::events($sql);
		$res =& $db->getOne($sql);
		return $res;		
	}
	
	function formAdd($surveyid = 0){
		global $locate;
		$html = '
				<!-- No edit the next line -->
				<form method="post" name="f" id="f">
				
				<table border="1" width="100%" class="adminlist" id="tblSurvey">
				';

		$html .= '<tr><td colspan=2>
					'. $locate->Translate("survey_title") .'
				</td></tr>';

		if ($surveyid == 0){
			$html .= '<tr><td colspan=2>
						<input type="text" size="50" maxlangth="100" id="surveyname" name="surveyname"/>
					 </td></tr>';
			$html .= '<tr><td colspan=2>
						'. $locate->Translate("Survey Note") .'
					</td></tr>';
			$html .= '<tr><td colspan=2>
						<input type="text" size="50" maxlangth="254" id="surveynote" name="surveynote"/></textarea>
					 </td></tr>';
			$enable_html = '<tr>
								<td colspan=2>
								<input type="radio" value="1" id="radEnable" name="radEnable" checked>'.$locate->Translate("enable").'
								<input type="radio" value="0" id="radEnable" name="radEnable">'.$locate->Translate("disable").'
								</td>
							 </tr>';
		}else{
			$survey = Customer::getRecord($surveyid,'survey');
	   	$nameCell = "TitleCol";

			$html .= '<tr><td colspan="2" id="'.$nameCell.'" style="cursor: pointer;"  onDblClick="xajax_editField(\'survey\',\'surveyname\',\''.$nameCell.'\',\''.$survey['surveyname'].'\',\''.$survey['id'].'\');return false">'.$survey['surveyname'].'<input type="hidden" id="surveyid" name="surveyid" value="'.$surveyid.'"/></td></tr>';

	   	$nameCell = "NoteCol";
			$html .= '<tr><td colspan=2>
						'. $locate->Translate("Survey Note") .'
					</td></tr>';
			$html .= '<tr><td colspan="2" id="'.$nameCell.'" style="cursor: pointer;"  onDblClick="xajax_editField(\'survey\',\'surveynote\',\''.$nameCell.'\',\''.$survey['surveynote'].'\',\''.$survey['id'].'\');return false">'.$survey['surveynote'].'&nbsp;</td></tr>';
			if ($survey['enable'] == 1)
				$enable_html = '<tr>
								<td colspan=2>
								<input type="radio" value="1" id="radEnable" name="radEnable" checked>'.$locate->Translate("enable").'
								<input type="radio" value="0" id="radEnable" name="radEnable">'.$locate->Translate("disable");
			else
				$enable_html = '<tr>
								<td colspan=2>
								<input type="radio" value="1" id="radEnable" name="radEnable" >'.$locate->Translate("enable").'
								<input type="radio" value="0" id="radEnable" name="radEnable" checked>'.$locate->Translate("disable");
			$enable_html .= '<input type="button" onclick="xajax_setSurvey(xajax.getFormValues(\'f\'));return false;" value="'.$locate->Translate("update").'">
								</td>
							 </tr>';

		}

		$options = Customer::getOptions($surveyid);

		if ($options){
			$ind = 0;
			while	($options->fetchInto($row)){
				$nameRow = "formDivRow".$row['id'];
			   	$nameCell = $nameRow."Col".$ind;
				
				$html .= '<tr id="'.$nameRow.'" >'."\n";

				$html .= '
					<td align="left" width="25%">'. $locate->Translate("option") .'(<a href="?" onclick="xajax_delete(\''.$row['id'].'\',\'surveyoptions\');var myRowIndex = document.getElementById(\''.$nameRow.'\').rowIndex;document.getElementById(\'tblSurvey\').deleteRow(myRowIndex+1);document.getElementById(\'tblSurvey\').deleteRow(myRowIndex);return false;"><img src="skin/default/images/trash.png"></a>)'.'
					</td><td id="'.$nameCell.'" style="cursor: pointer;"  onDblClick="xajax_editField(\'surveyoptions\',\'surveyoption\',\''.$nameCell.'\',\''.$row['surveyoption'].'\',\''.$row['id'].'\');return false">'.$row['surveyoption'].'</td></tr>
					<tr>
						<td align="left" width="25%">'.$locate->Translate("Option Note").'</td>
						<td id="'.$nameCell.'_note" style="cursor: pointer;"  onDblClick="xajax_editField(\'surveyoptions\',\'optionnote\',\''.$nameCell.'_note\',\''.$row['optionnote'].'\',\''.$row['id'].'\');return false">'.$row['optionnote'].'</td>
					</tr>
					<tr><td colspan="2" height="1" bgcolor="#ccc"></td></tr>
					';
				$ind++;

			}
		}

		$html .= '<tr><td colspan=2>
					'.$locate->Translate("option").'
				 </td></tr>';

		$html .= '<tr><td colspan=2>'.$locate->Translate("Title").': 
					<input type="text" size="50" maxlength="50" id="surveyoption" name="surveyoption"/>
				 </td></tr>';
		$html .= '<tr><td colspan=2>'.$locate->Translate("Note").': 
					<input type="text" size="50" maxlength="254" id="optionnote" name="optionnote"/>
					<input type="button" value="'.$locate->Translate("add_record").'" onclick="addOption(\'f\');return false;">
				 </td></tr>';

		$html .= $enable_html;

if ($_SESSION['curuser']['usertype'] == 'admin'){
		$res = Customer::getGroups();
		$groupoptions .= '<select name="groupid" id="groupid">';
		while ($row = $res->fetchRow()) {
				$groupoptions .= '<option value="'.$row['groupid'].'"';
				if ($survey['groupid']  == $row['groupid'])
					$groupoptions .= ' selected';
				$groupoptions .='>'.$row['groupname'].'</option>';
		}
		$groupoptions .= '</select>';
}else{
		$groupoptions .= $_SESSION['curuser']['group']['groupname'].'<input id="groupid" name="groupid" type="hidden" value="'.$_SESSION['curuser']['groupid'].'">';
}


		$html .= '
					<tr>
						<td align="left" width="25%">'.$locate->Translate("Group Name").'</td>
						<td>'.$groupoptions.'</td>
					</tr>';
		$html .= '
				</table>
				</form>
				';
		return $html;
	}

	function insertNewSurvey($f){
		global $db;
		if ($f['radEnable'] == 1)
			Customer::setSurveyEnable(0,1,$f['groupid']);
		$sql= "INSERT INTO survey SET "
				."surveyname='".$f['surveyname']."', "
				."enable='".$f['radEnable']."', "
				."surveynote='".$f['surveynote']."', "
				."groupid='".$f['groupid']."', "
				."cretime=now(), "
				."creby='".$_SESSION['curuser']['username']."'";
		astercrm::events($sql);
		$res =& $db->query($sql);
		$surveyid = mysql_insert_id();
		return $surveyid;
	}

	function setSurveyEnable($surveyid,$surveyenable = 1,$groupid = 0){
		//$table,$field,$value,$id
		if ($surveyid == 0){
			global $db;
			$sql = "UPDATE survey SET enable = 0 WHERE groupid = $groupid";
			$res = $db->query($sql);
		}else{
			$res = astercrm::updateField('survey','enable',$surveyenable,$surveyid);
		}
		return;
	}
	
	function insertNewOption($f,$surveyid){
		global $db;
		
		$sql= "INSERT INTO surveyoptions SET "
				."surveyoption='".$f['surveyoption']."', "
				."optionnote='".$f['optionnote']."', "
				."surveyid='".$surveyid."', "
				."cretime=now(), "
				."creby='".$_SESSION['curuser']['username']."'";
		astercrm::events($sql);
		$res =& $db->query($sql);
		$optionid = mysql_insert_id();
		return $optionid;
	}
}
?>