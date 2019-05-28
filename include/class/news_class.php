<?php
include_once($WEB_CLASS.'article_class.php');
/**
* 新闻处理类
* 这个类中有更新、插入、删除新闻等方法
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class News extends Article{
	/**
	 * Article的构造函数 无需传参数
	 */
	function __construct(){
		parent::__construct('{tablepre}news');
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
	 * 函数AddClass,添加新闻分类
	 * 成功返回true 失败返回false
	 * @param array $classinfo 插入的新闻分类 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function AddClass($classinfo){
		$this->setTable('{tablepre}news_class');
		return parent::Add($classinfo);
	}
	/**
	 * 函数GetClassList,返回新闻类列表
	 * 返回这个列表数据的数组类型
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @return array
	 */
	function GetClassList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		$this->setTable('{tablepre}news_class');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * 函数GetClassInfo,返回新闻分类的数据信息
	 * 返回值为这个产品类的信息(Array)
	 * @param string|int $id 新闻分类ID
	 * @param array $newsClassinfo 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array
	 */
	function GetClassInfo($id,$classinfo=array()){
		global $db;
		$this->setTable('{tablepre}news_class');
		return parent::GetInfo($classinfo,"id=$id");
	}
	/**
	 * 函数UpdateClass,更新新闻分类信息
	 * 成功返回true 失败返回false
	 * @param string|int $id 新闻分类ID
	 * @param array $classinfo 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function UpdateClass($id,$classinfo=array()){
		$this->setTable('{tablepre}news_class');
		if(parent::Update($classinfo,"id=$id")){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 函数DeleteClass,删除新闻分类
	 * 成功返回true 失败返回false
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean
	 */
	function DeleteClass($idarr){
		$this->setTable('{tablepre}news_class');
		if(parent::Del($idarr)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 函数GetClassNum,返回新闻分类数量
	 * 返回新闻分类数量
	 * @return int
	 */
	function GetClassNum(){
		$this->setTable('{tablepre}news_class');
		return parent::GetListCount();
	}
	/**
	 * 函数GetClassName,返回新闻类别名
	 * 成功返回类名 失败返回''
	 * @param string|int $nid 新闻类别ID
	 * @return string
	 */
	function GetClassName($nid){
		global $db;
		if(empty($nid) || $nid==0){
			return '';
		}else{
			return $db->GetFieldValue('{tablepre}news_class','classname',"id=$nid");
		}
	}
	/**
	 * 函数GetInfo,返回单个新闻的信息内容
	 * 返回新闻数据
	 * @param string|int $aid 文档ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array
	 */
	function GetInfo($aid,$col=array()){
		global $db,$web_url;
		//要返回栏目ID
		if(!in_array('classid',$col)){
			array_push($col,'classid');
		}
		if(in_array('content',$col) || in_array('keywords',$col) || in_array('description',$col)){
			//如果要返回内容 内容在不同的表 所以要另外处理
			foreach($col as $key=>$colName){
				if($col[$key]=='content' || $col[$key]=='keywords' ||  $col[$key]=='description'){
					if($col[$key]=='content'){
						$col_another[]='content';
					}elseif($col[$key]=='keywords'){
						$col_another[]='keywords';
					}elseif($col[$key]=='description'){
						$col_another[]='description';
					}
					unset($col[$key]);
				}
			}			 
			 
			$this->setTable("{tablepre}news");
			$newsInfo_1=parent::GetInfo($col,"id=$aid");
			$this->setTable("{tablepre}news_addon");
			$newsInfo_2=parent::GetInfo($col_another,"aid=$aid");
			if(!is_array($newsInfo_1) || !is_array($newsInfo_2)){
				return false;
			}else{
				$newsInfo=array_merge($newsInfo_1,$newsInfo_2);
			}
		}else{
			$newsInfo=parent::GetInfo($col,"id=$aid");
		}
		//返回当前路径
		//获得栏目信息
		$artclassname=$this->GetClassName($newsInfo['classid']);
		$position='<a href="'.$web_url.'">首页</a>>><a href="'.$web_url.'/news_list.php?id='.$newsInfo['classid'].'">'.$artclassname.'</a>>>'.$newsInfo['title'];
		$newsInfo['position']=$position;
		return $newsInfo;
	}
	/**
	 * 函数AddNews,插入一个新闻
	 * 返回值为文档的ID,失败返回0
	 * @param array $newsinfo 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int
	 */
	function Add($newsinfo){
		foreach($newsinfo as $key=>$value){
			if($key=='content' || $key=='keywords' ||  $key=='description'){
				$col_addon[$key]=$value;
			}else{
				$col_main[$key]=$value;
			}
		}
		
		$this->setTable('{tablepre}news');
		$aid=parent::Add($col_main);
		
		if($aid){
			$col_addon['aid']=$aid;
			$this->setTable('{tablepre}news_addon');
			return parent::Add($col_addon);
		}else{
			return false;
		}
	}
	/**
	 * 函数Update,更新一个文档
	 * 成功返回true 失败返回false
	 * @param string|int $id 新闻ID
	 * @param array $newsinfo 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function Update($id,$newsinfo){
		//把主表和附加表分开来
		foreach($newsinfo as $key=>$value){
			if($key=='content' || $key=='keywords' ||  $key=='description'){
				$col_addon[$key]=$value;
			}else{
				$col_main[$key]=$value;
			}
		}
		
		if(parent::Update($col_main,"id=$id")){
			$this->setTable('{tablepre}news_addon');
			if(parent::Update($col_addon,"aid=$id")){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	 * 函数UpdateClick,更新文档的点击数
	 * 成功返回true 失败返回false
	 * @param string|int $aid 新闻ID
	 * @param string $jizhunclick 更新的基准列名，默认为click
	 * @return boolean
	 */
	function UpdateClick($aid,$jizhunclick='click'){
		global $db;
		$sql="update {tablepre}$table set $jizhunclick=$jizhunclick+1 where id=$aid";
		return $db->ExecuteNoneQuery($sql);
	}
	/**
	 * 函数Delete,删除指定ID数组的新闻
	 * 成功返回true 失败返回false
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//这里的idarr是个数组 要删除的ID数组
		if(parent::Del($idarr)){
			$this->setTable('{tablepre}news_addon');
			return parent::Del($idarr,'aid');
		}else{
			return false;
		}
	}
	/**
	 * 函数GetList,调用新闻列表
	 * 返回返回新闻列表
	 * @param string|int $classid 新闻类型
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param int $issystem 是不是系统文章 0为返回非系统文章 1为返回系统文章 2表示全部文章
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @return array
	 */
	function GetList($classid,$col=array(),$start='',$listnum='',$order='addtime desc'){
		if($classid!=0){
			$where="classid=$classid";
		}
		$arrlist=parent::GetList($col,$start,$listnum,$where,$order);
		foreach($arrlist as $key=>$value){
			$arrlist[$key]['url']="news.php?id=".$value['id'];
		}
		return $arrlist;
	}
	function GetNewsCount($classid){
		if($classid!=0){
			$where='classid='.$classid;
		}
		return parent::GetListCount($where);
	}
}
?>