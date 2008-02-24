<?
/*******************************************************************************
* rate.grid.inc.php

* @author			Solo Fu <solo.fu@gmail.com>
* @classVersion		1.0
* @date				18 Oct 2007

* Functions List


* Revision 0.01  2007/11/21 13:15:00  last modified by solo
* Desc: page created

********************************************************************************/

require_once 'db_connect.php';
require_once 'rate.common.php';
require_once 'include/astercrm.class.php';


class Customer extends astercrm
{

	/**
	*  Inserta un nuevo registro en la tabla.
	*
	*	@param $f	(array)		Arreglo que contiene los datos del formulario pasado.
	*	@return $res	(object) 	Devuelve el objeto con la respuesta de la sentencia SQL ejecutada del INSERT.

	*/
	
	function insertNewRate($f){
		global $db;
		$f = astercrm::variableFiler($f);
		$sql= "INSERT INTO myrate SET "
				."dialprefix='".$f['dialprefix']."', "
				."numlen='".$f['numlen']."', "
				."destination='".$f['destination']."', "
				."rateinitial ='".$f['rateinitial']."',"
				."initblock='".$f['initblock']."',"			
				."billingblock='".$f['billingblock']."',"
				."connectcharge='".$f['connectcharge']."', "
				."addtime= now(), "
				."groupid='".$f['groupid']."' ";

		Customer::events($sql);
		$res =& $db->query($sql);
		return $res;
	}

	function updateRateRecord($f){
		global $db;
		$f = astercrm::variableFiler($f);
		
		$sql= "UPDATE myrate SET "
				."dialprefix='".$f['dialprefix']."', "
				."numlen='".$f['numlen']."', "
				."destination='".$f['destination']."', "
				."rateinitial ='".$f['rateinitial']."',"
				."initblock='".$f['initblock']."',"			
				."billingblock='".$f['billingblock']."',"
				."addtime= now(),"
				."connectcharge='".$f['connectcharge']."' "
				."WHERE id='".$f['id']."'";
//		print $sql;
//		exit;
		astercrm::events($sql);
		$res =& $db->query($sql);
		return $res;
	}

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
		
		$sql = "SELECT myrate.*, groupname FROM myrate  LEFT JOIN accountgroup ON accountgroup.id = myrate.groupid WHERE ";

		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$sql .= " 1 ";
		}else{
			$sql .= " groupid = ".$_SESSION['curuser']['groupid']." ";
		}

//		if ($creby != null)
//			$sql .= " WHERE note.creby = '".$_SESSION['curuser']['username']."' ";
			

		if($order == null){
			$sql .= " LIMIT $start, $limit";//.$_SESSION['ordering'];
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
		
		$sql = "SELECT * FROM myrate WHERE ";

		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$sql .= " 1 ";
		}else{
			$sql .= " groupid = ".$_SESSION['curuser']['groupid']." ";
		}

		if ($joinstr!=''){
			$joinstr=ltrim($joinstr,'AND'); //去掉最左边的AND
			$sql .= " AND ".$joinstr." "
					." ORDER BY ".$order
					." ".$_SESSION['ordering']
					." LIMIT $start, $limit $ordering";
		}
		
		Customer::events($sql);
		$res =& $db->query($sql);
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
			$sql = "SELECT COUNT(*) AS numRows FROM myrate ";
		}else{
		$sql = "SELECT COUNT(*) AS numRows FROM myrate WHERE groupid = '".$_SESSION['curuser']['groupid']."' ";
		}

		Customer::events($sql);
		$res =& $db->getOne($sql);
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
			$sql = "SELECT COUNT(*) AS numRows FROM myrate WHERE";
			if ($_SESSION['curuser']['usertype'] == 'admin'){
				$sql .= " 1 ";
			}else{
				$sql .= " groupid = ".$_SESSION['curuser']['groupid']." ";
			}

			if ($joinstr!=''){
				$joinstr=ltrim($joinstr,'AND'); //去掉最左边的AND
				$sql .= " AND ".$joinstr." ";
			}

		Customer::events($sql);
		$res =& $db->getOne($sql);
		return $res;
	}


	function formAdd(){
		global $locate;

		$group = astercrm::getGroupList();

		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$options .= '<select id="groupid" name="groupid">';
			while	($group->fetchInto($row)){
				$options .= "<OPTION value='".$row['id']."'>".$row['groupname']."</OPTION>";
			}
			$options .= '</select>';
		}else{
			while	($group->fetchInto($row)){
				if ($row['id'] == $_SESSION['curuser']['groupid']){
					$options .= $row['groupname'].'<input type="hidden" value="'.$row['id'].'" name="groupid" id="groupid">';
					break;
				}
			}
		}


	$html = '
			<!-- No edit the next line -->
			<form method="post" name="f" id="f">
			
			<table border="1" width="100%" class="adminlist">
				<tr>
					<td nowrap align="left">'.'dialprefix'.'</td>
					<td align="left"><input type="text" id="dialprefix" name="dialprefix" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'length'.'</td>
					<td align="left"><input type="text" id="numlen" name="numlen" size="10" maxlength="10" value="0"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'destination'.'</td>
					<td align="left"><input type="text" id="destination" name="destination" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'connectcharge'.'</td>
					<td align="left"><input type="text" id="connectcharge" name="connectcharge" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'initblock'.'</td>
					<td align="left"><input type="text" id="initblock" name="initblock" size="25" maxlength="100"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'rateinitial'.'</td>
					<td align="left"><input type="text" id="rateinitial" name="rateinitial" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'billingblock'.'</td>
					<td align="left"><input type="text" id="billingblock" name="billingblock" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'Group'.'</td>
					<td align="left">'.$options.'</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<button id="submitButton" onClick=\'xajax_save(xajax.getFormValues("f"));return false;\'>'.'Continue'.'</button>
					</td>
				</tr>

			 </table>
			';

		$html .='
			</form>
			'.'obligatory_fields'.'
			';
		
		return $html;
	}

	/**
	*  Imprime la forma para editar un nuevo registro sobre el DIV identificado por "formDiv".
	*
	*	@param $id		(int)		Identificador del registro a ser editado.
	*	@return $html	(string) Devuelve una cadena de caracteres que contiene la forma con los datos 
	*									a extraidos de la base de datos para ser editados 
	*/
	
	function formEdit($id){
		global $locate;
		$rate =& Customer::getRecordByID($id,'myrate');
		$group = astercrm::getGroupList();

		if ($_SESSION['curuser']['usertype'] == 'admin'){
			$options .= '<select id="groupid" name="groupid">';
			while	($group->fetchInto($row)){
				if ($row['id'] == $rate['groupid']){
					$options .= "<OPTION value='".$row['id']."' selected>".$row['groupname']."</OPTION>";
				}else{
					$options .= "<OPTION value='".$row['id']."'>".$row['groupname']."</OPTION>";
				}
			}
			$options .= '</select>';
		}else{
			while	($group->fetchInto($row)){
				if ($row['id'] == $_SESSION['curuser']['groupid']){
					$options .= $row['groupname'].'<input type="hidden" value="'.$row['id'].'" name="groupid" id="groupid">';
					break;
				}
			}
		}

		$html = '
			<!-- No edit the next line -->
			<form method="post" name="f" id="f">
			
			<table border="1" width="100%" class="adminlist">
				<tr>
					<td nowrap align="left">'.'dialprefix'.'</td>
					<td align="left"><input type="hidden" id="id" name="id" value="'. $rate['id'].'"><input type="text" id="dialprefix" name="dialprefix" size="25" maxlength="30" value="'.$rate['dialprefix'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'length'.'</td>
					<td align="left"><input type="text" id="numlen" name="numlen" size="10" maxlength="10" value="'.$rate['numlen'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'destination'.'</td>
					<td align="left"><input type="text" id="destination" name="destination" size="25" maxlength="30" value="'.$rate['destination'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'connectcharge'.'</td>
					<td align="left"><input type="text" id="connectcharge" name="connectcharge" size="20" maxlength="20" value="'.$rate['connectcharge'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'."initblock".'</td>
					<td align="left"><input type="text" id="initblock" name="initblock" size="25" maxlength="100" value="'.$rate['initblock'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'rateinitial'.'</td>
					<td align="left"><input type="text" id="rateinitial" name="rateinitial" size="25" maxlength="30" value="'.$rate['rateinitial'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'."billingblock".'</td>
					<td align="left"><input type="text" id="billingblock" name="billingblock" size="25" maxlength="30" value="'.$rate['billingblock'].'"></td>
				</tr>
				<tr>
					<td nowrap align="left">'.'Group'.'</td>
					<td align="left">'.$options.'</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<button id="submitButton" onClick=\'xajax_update(xajax.getFormValues("f"));return false;\'>'."Continue".'</button>
					</td>
				</tr>

			 </table>
			';

			

		$html .= '
				</form>
				'."obligatory_fields".'
				';

		return $html;
	}
}
?>
