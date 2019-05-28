<?php
include_once($WEB_CLASS.'article_class.php');
/**
* 互动信息处理类
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class HuDong extends Article{
	/**
	 * HuDong的构造函数 无需传参数
	 */
	function __construct(){
		parent::__construct('{tablepre}hudong');
	}
	/**
	 * 函数setTable,设置类要操作的表
	 * @param string $table 表名
	 * @return true
	 */
	function setTable($table){
		parent::setTable($table);
	}
	/**
	 * 函数Add,添加互动信息
	 * 返回值为文档的ID,失败返回0
	 * @param array $info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
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
	 * 函数GetList,用来获取互动信息
	 * 返回这个列表数据的数组类型
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $type 互动信息类型 0为全部 1为未读 2为已读
	 * @param string $where 条件，不要带where 如id=1
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
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
	 * 函数Delete,删除指定ID数组的所有文章
	 * 成功返回true 失败返回false
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//这里的idarr是个数组
		return parent::Del($idarr);		
	}
	/**
	 * 函数GetInfo,获取指定ID的互动信息
	 * 成功返回true 失败返回false
	 * @param string|int $id 互动信息的ID
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
	 * 函数UpdateType,更新互动信息的类型 1为已读 2为未读
	 * 成功返回true 失败返回false
	 * @param string|int $id 互动信息的ID
	 * @param int $type 信息设置为的类型
	 * @return boolean
	 */
	function UpdateType($id,$type){
		return parent::Update(array('type'=>$type),"id=$id");
	}
	/**
	 * 函数GetNum,返回指定类型的信息的数量
	 * 成功返回数量 失败返回false
	 * @param int $type 信息设置为的类型
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
	 * 函数AddField,为互动表单增加字段
	 * 成功返回true 失败返回false
	 * @param array $fieldInfo 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function AddField($fieldInfo){
		//增加字段到hudong中去
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
	 * 函数UpdateField,更新互动表单字段
	 * 成功返回true 失败返回false
	 * @param int|string $id 在hudong_field的ID
	 * @param array $fieldInfo 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function UpdateField($id,$fieldInfo){
		//修改字段
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
	 * 函数DeleteField,删除互动表单字段
	 * 成功返回true 失败返回false
	 * @param int|string $id 在hudong_field的ID
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
	 * 函数GetFiledList,返回互动表单的列
	 * 成功返回true 失败返回false	 
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数	 
	 * @return array
	 */
	function GetFiledList($col=array(),$start='',$listnum='',$order='orderid,updatetime desc'){
		$this->setTable('{tablepre}hudong_field');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * 函数GetFormatFiledList,返回格式化后的互动表单
	 * 返回一个数组 其中arr['itemname']为表单提示文字 inputtxt为生成的input字段HTML
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为array()时返回全部字段
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数	 
	 * @return array
	 */
	function GetFormatFiledList($col=array(),$start='',$listnum='',$order='orderid'){
		$fieldList=$this->GetFiledList($col,$start,$listnum,$order);
		$fieldFormatList=array();
		//加上默认的title
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
				$setDefault=false;//是不是设置了默认值
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
	 * 函数GetFieldName,根据ID返回指定的互动表单的filename[表单名]
	 * 返回表单名
	 * @param int|string $id 在hudong_field的ID
	 * @return string
	 */
	function GetFieldName($id){
		//获取ID为$id的字段名fieldname
		global $db;
		return $db->GetFieldValue('{tablepre}hudong_field','fieldname',"id=$id");
	}
	/**
	 * 函数GetFieldInfo,返回单个表单的数据
	 * 返回值为这个文档的信息(Array)
	 * @param int|string $id 在hudong_field的ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为array()时返回全部字段
	 * @return array
	 */
	function GetFieldInfo($id,$col=array()){
		$where="id=$id";
		parent::setTable('{tablepre}hudong_field');
		return parent::GetInfo($col,$where);
	}
	/**
	 * 函数GetFieldForm,返回提交的表单信息
	 * 返回值为生成的form的HTML代码
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