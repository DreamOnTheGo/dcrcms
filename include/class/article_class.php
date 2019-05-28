<?php
defined('IN_DCR') or exit('No permission.'); 

/**
* 数据库的处理类，一般数据库处理的类都以为这个父类
* 这个类中有更新、插入、删除文档 还有获取数据等方法
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Article{
	private $table; //操作的表名
    private $last_sql;//最后操作的sql
	/**
	 * Article的构造函数
	 * @param string $table 这个文章类要操作的表名
	 * @return Article 返回一个Article实例
	 */
	function __construct($table){
		$this->table=$table;
	}
	/**
	 * 函数setTable,设置类要操作的表
	 * @param string $table 表名
	 * @return true 返回ture
	 */
	protected function setTable($table){
		$this->table=$table;
	}
	
	/**
	 * 函数GetLastSql,返回art类最后操作的sql
	 * @return string
	 */
    function GetLastSql()
    {
        return $this->last_sql;
    }
	
	/**
	 * 函数SetLastSql,设置art类最后操作的sql
	 * @param string $sql sql
	 * @return true
	 */
    private function SetLastSql($sql)
    {
        $this->last_sql=$sql;
    }
	/**
	 * 函数GetList,实现对表里数据的调用(列表数据)
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @param string $where 条件，不要带where 如id=1
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @return array 根据参数返回的数据库信息列表
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
        $this->SetLastSql($sql);
		$db->Execute($sql);
		$t_list=$db->GetArray();
		return $t_list;				
	}
	/**
	 * 函数GetListBySql,用SQL直接实现对表里数据的调用(列表数据)
	 * @param string $sql 操作的SQL
	 * @return array 根据$sql返回的数据库信息列表
	 */
	function GetListBySql($sql){
		global $db;
		$db->Execute($sql);
        $this->SetLastSql($sql);
		$t_list=$db->GetArray();
		return $t_list;				
	}
	/**
	 * 函数GetInfo,返回单个文档的数据
	 * @param string $table 表名
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $where 条件，不要带where 如id=1
	 * @param string $orderby 排序，可以通过这个来获取一条
	 * @return array 返回值为这个文档的信息(Array)
	 */
	function GetInfo($col=array(),$where='',$orderby=''){
		global $db;
		if(is_array($col) && count($col)>0){
			$cols=implode(',',$col);
		}else{
			$cols='*';
		}
		if(strlen($where)>0){
			$where='where '.$where;
		}
		if(strlen($orderby)>0){
			$orderby='order by '.$orderby;
		}
		$sql="select $cols from ".$this->table." $where $orderby";
		//echo $sql.'<br>';
		/*$t_r=$db->Execute($sql);
		$t_r=$db->GetArray();
		return $t_r[0];*/
		//1.0.5版改成只返回一条的记录 因为GetInfo只要一条结果
        $this->SetLastSql($sql);
		$info=$db->GetOne($sql);
		return $info;
	}
	/**
	 * 函数Add,插入一个文档
	 * @param string $table 表名
	 * @param array $info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 返回值为文档的ID,失败返回0
	 */
	function Add($info){
		foreach($info as $key=>$value){
			$keylist.='`'.$key.'`,';
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
        $this->SetLastSql($sql);
		return $db->GetInsertId();
	}
	/**
	 * 函数Update,更新一个文档
	 * @param array $info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @param string $where 更新条件
	 * @return boolean 更新成功返回true 失败返回false
	 */
	function Update($info=array(),$where){
		foreach($info as $key=>$value){
			$updateStr.="`$key`='$value',";
		}
		$updateStr=substr($updateStr,0,strlen($updateStr)-1);
		$sql="update ".$this->table." set $updateStr where $where";
		global $db;
		if(strlen($updateStr)>0){
			if($db->ExecuteNoneQuery($sql)){
	       		$this->SetLastSql($sql);
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
	 * @param array $idarr 删除的文档ID 可以是数组 比如array('1','2') 也可以用是字符串 但要以,分隔 比如1,2,3
	 * @param string $jizhuncol 删除的基准列名，默认为ID 如删除ID=1的文档 要删除aid=1的文档则这个值为'aid'
	 * @return boolean 成功返回true 失败返回false
	 */
	function Del($idarr,$jizhuncol='id'){
		if(is_array($idarr)){
			$idarr=implode(',',$idarr);
		}
		
		if(!empty($idarr)){
			global $db;
			$sql="delete from ".$this->table." where $jizhuncol in($idarr)";
       		$this->SetLastSql($sql);
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
	 * @param array $where 条件
	 * @return int 成功则返回记录数 失败返回0
	 */
	function GetListCount($where=''){
		if(strlen($where)>0){
			$where='where '.$where;
		}
		global $db;
		$sql="select id from ".$this->table." $where";
		//echo $sqlNum;
		$db->Execute($sql);
	    $this->SetLastSql($sql);
		$pageNum=$db->GetRsNum();
		return $pageNum;
	}
}
?>