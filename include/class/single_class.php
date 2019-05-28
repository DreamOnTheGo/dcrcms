<?php
defined('IN_DCR') or exit('No permission.'); 

include_once('article_class.php');
/**
* 单页面处理类，即后台的公司资料处理
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Single extends Article{
	/**
	 * Article的构造函数 无需传参数
	 */
	function __construct(){
		parent::__construct('{tablepre}single');
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
	 * 函数GetInfo,返回单个资料的信息内容
	 * @param string|int $aid 文档ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array 返回单个资料
	 */
	function GetInfo($aid,$col=array()){
		$newsInfo=parent::GetInfo($col,"id=$aid");
		$newsInfo['position']='<a href="'.$web_url.'">首页</a>>>'.$newsInfo['title'];
		return $newsInfo;
	}
	/**
	 * 函数Add,插入一个单页面
	 * @param array $singleinfo 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 成功返回true 失败返回false
	 */
	function Add($singleinfo){		
		return parent::Add($singleinfo);
	}
	/**
	 * 函数Update,更新一个文档
	 * @param string|int $id 文档ID
	 * @param array $singleInfo 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function Update($id,$singleInfo){
		return parent::Update($singleInfo,"id=$id");
	}
	/**
	 * 函数UpdateClick,更新文档的点击数
	 * @param string|int $aid 新闻ID
	 * @param string $jizhunclick 更新的基准列名，默认为click
	 * @return boolean 成功返回true 失败返回false
	 */
	function UpdateClick($aid,$jizhunclick='click'){
		global $db;
		$sql="update {tablepre}single set $jizhunclick=$jizhunclick+1 where id=$aid";
		return $db->ExecuteNoneQuery($sql);
	}
	/**
	 * 函数Delete,删除指定ID数组的单页面
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean 成功返回true 失败返回false
	 */
	function Delete($idarr){
		return parent::Del($idarr);
	}
	/**
	 * 函数GetList,调用单页面列表
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @return array 返回新闻列表
	 */
	function GetList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
}
?>