<?php
include_once($WEB_CLASS.'article_class.php');
/**
* ������Ϣ������
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class HuDong extends Article{
	/**
	 * HuDong�Ĺ��캯�� ���贫����
	 */
	function __construct(){
		parent::__construct('{tablepre}hudong');
	}
	/**
	 * ����setTable,������Ҫ�����ı�
	 * @param string $table ����
	 * @return true
	 */
	function setTable($table){
		parent::setTable($table);
	}
	/**
	 * ����Add,��ӻ�����Ϣ
	 * ����ֵΪ�ĵ���ID,ʧ�ܷ���0
	 * @param array $info ��������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return int
	 */
	function Add($info){
		$fieldList=$this->GetFiledList(array('fieldname','dtype'));
		foreach($fieldList as $value){
			$field_t.=$value['fieldname'].',';
			if($value['dtype']=='checkbox'){
				if(is_array($info[$value['fieldname']])){
					$value_t.="'".implode(',',$info[$value['fieldname']])."',";
				}else{
					$value_t.="'',";
				}
			}else{
				$value_t.="'".$info[$value['fieldname']]."',";
			}
		}
		if(substr($field_t,strlen($field_t)-1,strlen($field_t))==','){
			$field_t=substr($field_t,0,strlen($field_t)-1);
			$value_t=substr($value_t,0,strlen($value_t)-1);
		}
		$sql="insert into {tablepre}hudong($field_t) values($value_t)";
		//echo $sql;
		global $db;
		$db->ExecuteNoneQuery($sql);
		return $db->GetInsertId();
	}
	 /**
	 * ����GetList,������ȡ������Ϣ
	 * ��������б����ݵ���������
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $type ������Ϣ���� 0Ϊȫ�� 1Ϊδ�� 2Ϊ�Ѷ�
	 * @param string $where ��������Ҫ��where ��id=1
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
	 * @return array
	 */
	function GetList($col=array(),$type=0,$start='',$listnum='',$order='updatetime desc'){
		$type=(int)$type;
		if($type!=0){
			$where="type=$type";
		}
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * ����Delete,ɾ��ָ��ID�������������
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//�����idarr�Ǹ�����
		return parent::Del($idarr);		
	}
	/**
	 * ����GetInfo,��ȡָ��ID�Ļ�����Ϣ
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ������Ϣ��ID
	 * @return array
	 */
	function GetInfo($id){		
		$where="id=$id";
		$fieldList=$this->GetFiledList(array('fieldname'));
		foreach($fieldList as $value){
			$col[]=$value['fieldname'];
		}
		$col[]='title';
		$col[]='updatetime';
		$col[]='id';
		$col[]='type';
		$this->setTable('{tablepre}hudong');
		return parent::GetInfo($col,$where);
	}
	/**
	 * ����UpdateType,���»�����Ϣ������ 1Ϊ�Ѷ� 2Ϊδ��
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ������Ϣ��ID
	 * @param int $type ��Ϣ����Ϊ������
	 * @return boolean
	 */
	function UpdateType($id,$type){
		return parent::Update(array('type'=>$type),"id=$id");
	}
	/**
	 * ����GetNum,����ָ�����͵���Ϣ������
	 * �ɹ��������� ʧ�ܷ���false
	 * @param int $type ��Ϣ����Ϊ������
	 * @return boolean
	 */
	function GetNum($type=0){
		$type=(int)$type;
		if($type!=0){
			$where="type=$type";
		}
		return parent::GetListCount($where);
	}
	/**
	 * ����AddField,Ϊ�����������ֶ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $fieldInfo ��������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function AddField($fieldInfo){
		//�����ֶε�hudong��ȥ
		global $db;
		if($fieldInfo['dtype']=='multitext'){
			$addcolsql="column `".$fieldInfo['fieldname']."` MEDIUMTEXT";
		}else{
			$addcolsql="column `".$fieldInfo['fieldname']."` varchar(".$fieldInfo['maxlength'].") not null default ''";
		}
		$sqlAlter="alter table {tablepre}hudong add $addcolsql";
		if($db->ExecuteNoneQuery($sqlAlter)){
			//return true;
			$this->setTable('{tablepre}hudong_field');
			return parent::Add($fieldInfo);
		}else{
			return false;
		}
	}
	/**
	 * ����UpdateField,���»������ֶ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param int|string $id ��hudong_field��ID
	 * @param array $fieldInfo ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function UpdateField($id,$fieldInfo){
		//�޸��ֶ�
		global $db;
		$fieldname=$this->GetFieldName($id);
		if(empty($fieldname)){
			return false;
		}else{
			if($fieldInfo['dtype']=='multitext'){
				$addcolsql="column `".$fieldInfo['fieldname']."` MEDIUMTEXT";
			}else{
				$addcolsql="column `".$fieldInfo['fieldname']."` varchar(".$fieldInfo['maxlength'].") not null default ''";
			}
			$sqlAlter="ALTER TABLE {tablepre}hudong MODIFY $addcolsql";
			//echo $sqlAlter;
			if($db->ExecuteNoneQuery($sqlAlter)){
				$this->setTable('{tablepre}hudong_field');
				return parent::Update($fieldInfo,"id=$id");
			}else{
				return false;
			}
		}
	}
	/**
	 * ����DeleteField,ɾ���������ֶ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param int|string $id ��hudong_field��ID
	 * @return boolean
	 */
	function DeleteField($id){
		global $db;
		$fieldname=$this->GetFieldName($id);
		if(empty($fieldname)){
			return false;
		}else{
			$sqlAlter="ALTER TABLE {tablepre}hudong DROP COLUMN `".$fieldname."`";
			//echo $sqlAlter;
			if($db->ExecuteNoneQuery($sqlAlter)){
				$this->setTable('{tablepre}hudong_field');
				return parent::Del(array($id));
			}else{
				return false;
			}
		}
	}
	/**
	 * ����GetFiledList,���ػ���������
	 * �ɹ�����true ʧ�ܷ���false	 
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��	 
	 * @return array
	 */
	function GetFiledList($col=array(),$start='',$listnum='',$order='orderid,updatetime desc'){
		$this->setTable('{tablepre}hudong_field');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * ����GetFormatFiledList,���ظ�ʽ����Ļ�����
	 * ����һ������ ����arr['itemname']Ϊ����ʾ���� inputtxtΪ���ɵ�input�ֶ�HTML
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarray()ʱ����ȫ���ֶ�
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��	 
	 * @return array
	 */
	function GetFormatFiledList($col=array(),$start='',$listnum='',$order='orderid'){
		$fieldList=$this->GetFiledList($col,$start,$listnum,$order);
		$fieldFormatList=array();
		//����Ĭ�ϵ�title
		foreach($fieldList as $key=>$value){
			if($value['dtype']=='text'){
				$str_t="<input name='".$value['fieldname']."' id='".$value['fieldname']."' type='text' maxlength='".$value['maxlength']."' value='".$value['vdefault']."' />";
				$arr_t=array('itemname'=>$value['itemname'],'inputtxt'=>$str_t);
				$fieldFormatList[]=$arr_t;
			}
			if($value['dtype']=='multitext'){
				$str_t="<textarea name='".$value['fieldname']."' id='".$value['fieldname']."'>".$value['vdefault']."</textarea>";
				$arr_t=array('itemname'=>$value['itemname'],'inputtxt'=>$str_t);
				$fieldFormatList[]=$arr_t;
			}
			if($value['dtype']=='select'){
				$str_t="<select name='".$value['fieldname']."' id='".$value['fieldname']."'>";
				$v_a=explode(',',$value['vdefault']);
				foreach($v_a as $v_v){
					$str_t.="<option value='$v_v'>$v_v</option>";
				}
				$str_t.="</select>";
				$arr_t=array('itemname'=>$value['itemname'],'inputtxt'=>$str_t);
				$fieldFormatList[]=$arr_t;
			}
			if($value['dtype']=='checkbox'){
				$v_a=explode(',',$value['vdefault']);
				$str_t='';
				foreach($v_a as $v_v){
					$str_t.=" <input type='checkbox' name='".$value['fieldname']."[]' id='".$value['fieldname']."[]' value='$v_v' />$v_v";
				}
				$arr_t=array('itemname'=>$value['itemname'],'inputtxt'=>$str_t);
				$fieldFormatList[]=$arr_t;
			}
			if($value['dtype']=='radio'){
				$v_a=explode(',',$value['vdefault']);
				$str_t='';
				$setDefault=false;//�ǲ���������Ĭ��ֵ
				foreach($v_a as $v_v){
					if($setDefault){
						$str_t.="<input type='radio' name='".$value['fieldname']."' id='".$value['fieldname']."' value='$v_v' />$v_v";
					}else{
						$str_t.="<input checked type='radio' name='".$value['fieldname']."' id='".$value['fieldname']."' value='$v_v' />$v_v";
						$setDefault=true;
					}
				}
				$arr_t=array('itemname'=>$value['itemname'],'inputtxt'=>$str_t);
				$fieldFormatList[]=$arr_t;
			}
		}
		//echo '<pre>';
		//print_r($fieldFormatList);
		//echo '</pre>';
		return $fieldFormatList;
	}
	/**
	 * ����GetFieldName,����ID����ָ���Ļ�������filename[����]
	 * ���ر���
	 * @param int|string $id ��hudong_field��ID
	 * @return string
	 */
	function GetFieldName($id){
		//��ȡIDΪ$id���ֶ���fieldname
		global $db;
		return $db->GetFieldValue('{tablepre}hudong_field','fieldname',"id=$id");
	}
	/**
	 * ����GetFieldInfo,���ص�����������
	 * ����ֵΪ����ĵ�����Ϣ(Array)
	 * @param int|string $id ��hudong_field��ID
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarray()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetFieldInfo($id,$col=array()){
		$where="id=$id";
		parent::setTable('{tablepre}hudong_field');
		return parent::GetInfo($col,$where);
	}
	/**
	 * ����GetFieldForm,�����ύ�ı���Ϣ
	 * ����ֵΪ���ɵ�form��HTML����
	 * @return string
	 */
	function GetFieldForm(){
		$formInfo=$this->GetFormatFiledList();
		$formTxt='';
		$formTxt.="<form method=\"post\" action=\"hudong.php?action=addorder\">\n";
		foreach($formInfo as $key=>$value){
			$formTxt.=$value['itemname'].":".$value['inputtxt']."\n";
		}
		$formTxt.="</form>\n";
		return $formTxt;
	}
}
?>