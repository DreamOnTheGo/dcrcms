<?php
/**
* 文章处理的基类，一般文章处理的类都以为这个父类.
* 这个类中有更新、插入、删除文档 还有获取数据等方法
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Article{
	private $table; //操作的表名
	/**
	 * Article的构造函数 无需传参数
	 * @param string $table 这个文章类要操作的表名
	 * @return Article
	 */
	function __construct($table){
		$this->table=$table;
	}
	/**
	 * 函数setTable,设置类要操作的表
	 * 说明 如果子类中要操作的不是构造函数的里设置的表名则要通过这个函数设置表名后才能进行下一步操作
	 * @param string $table 表名
	 * @return true
	 */
	protected function setTable($table){
		$this->table=$table;
	}
	/**
	 * 函数GetList,实现对表里数据的调用(列表数据)
	 * 返回这个列表数据的数组类型
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $where 条件，不要带where 如id=1
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @return array
	 */
	function GetList($col=array(),$start='',$listnum='',$where='',$order=''){
		global $db;
		if(is_array($col) && count($col)>0){
			$cols=implode(',',$col);
		}else{
			$cols='*';
		}
		if(strlen($where)>0){
			$where='where '.$where;
		}
		if(strlen($order)>0){
			$order='order by '.$order;
		}
		if(strlen($start)>0 && strlen($listnum)>0){
			$limit="limit $start,$listnum";
		}
		//echo $where;
		$sql="select $cols from ".$this->table." $where $order $limit";
		//echo $sql;
		$db->Execute($sql);
		$t_list=$db->GetArray();
		return $t_list;				
	}
	/**
	 * 函数GetListBySql,用SQL直接实现对表里数据的调用(列表数据)
	 * 返回这个列表数据的数组类型
	 * @param string $sql 操作的SQL
	 * @return array
	 */
	function GetListBySql($sql){
		global $db;
		$db->Execute($sql);
		$t_list=$db->GetArray();
		return $t_list;				
	}
	/**
	 * 函数GetInfo,返回单个文档的数据
	 * 返回值为这个文档的信息(Array)
	 * @param string $table 表名
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $where 条件，不要带where 如id=1
	 * @return array
	 */
	function GetInfo($col=array(),$where=''){
		global $db;
		if(is_array($col) && count($col)>0){
			$cols=implode(',',$col);
		}else{
			$cols='*';
		}
		if(strlen($where)>0){
			$where='where '.$where;
		}
		$sql="select $cols from ".$this->table." $where";
		//echo $sql;
		$t_r=$db->Execute($sql);
		$t_r=$db->GetArray();
		return $t_r[0];
	}
	/**
	 * 函数Add,插入一个文档
	 * 返回值为文档的ID,失败返回0
	 * @param string $table 表名
	 * @param array $info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int
	 */
	function Add($info){
		foreach($info as $key=>$value){
			$keylist.=$key.',';
			$valuelist.="'$value',";
		}
		if(substr($keylist,strlen($keylist)-1,strlen($keylist))==','){
			$keylist=substr($keylist,0,strlen($keylist)-1);
			$valuelist=substr($valuelist,0,strlen($valuelist)-1);
		}
		$sql="insert into ".$this->table."($keylist) values($valuelist)";
		//echo $sql;
		global $db;
		$db->ExecuteNoneQuery($sql);
		return $db->GetInsertId();
	}
	/**
	 * 函数Update,更新一个文档
	 * 成功返回true 失败返回false
	 * @param string $table 表名
	 * @param array $info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function Update($info=array(),$where){
		foreach($info as $key=>$value){
			$updateStr.="$key='$value',";
		}
		$updateStr=substr($updateStr,0,strlen($updateStr)-1);
		$sql="update ".$this->table." set $updateStr where $where";
		global $db;
		if(strlen($updateStr)>0){
			if($db->ExecuteNoneQuery($sql)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	 * 函数Del,删除指定ID数组的所有文章
	 * 成功返回true 失败返回false
	 * @param string $table 表名
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @param string $jizhuncol 删除的基准列名，默认为ID 如删除ID=1的文档 要删除aid=1的文档则这个值为'aid'
	 * @return boolean
	 */
	function Del($idarr,$jizhuncol='id'){
		if(is_array($idarr)){
			$idarr=implode(',',$idarr);
		}else{
			return false;
		}
		if(!empty($idarr)){
			global $db;
			$sql="delete from ".$this->table." where $jizhuncol in($idarr)";
			if($db->ExecuteNoneQuery($sql)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	 * 函数GetListCount,返回指定文档条件的文档数
	 * 成功则返回记录数 失败返回0
	 * @param string $table 表名
	 * @param array $where 条件
	 * @return int
	 */
	function GetListCount($where=''){
		if(strlen($where)>0){
			$where='where '.$where;
		}
		global $db;
		$sqlNum="select id from ".$this->table." $where";
		//echo $sqlNum;
		$db->Execute($sqlNum);
		$pageNum=$db->GetRsNum();
		return $pageNum;
	}
}
?>