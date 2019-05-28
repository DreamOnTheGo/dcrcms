<?php
include_once($WEB_CLASS.'article_class.php');
/**
* 产品处理类
* 这个类中有更新、插入、删除产品等方法
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Product extends Article{
	/**
	 * Product的构造函数 无需传参数
	 */
	 private $nopic;
	function __construct(){
		global $web_url;
		parent::__construct('{tablepre}product');
		$this->nopic=$web_url.'/include/images/nopic.png';
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
	 * 函数AddClass,添加产品分类
	 * 成功返回true 失败返回false
	 * @param array $proclassinfo 插入的产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function AddClass($proclassinfo){
		//添加产品分类
		$this->setTable('{tablepre}product_class');
		return parent::Add($proclassinfo);
	}
	/**
	 * 函数GetClassList,返回产品类列表
	 * 返回这个列表数据的数组类型
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @return array
	 */
	function GetClassList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		$this->setTable('{tablepre}product_class');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * 函数GetClassInfo,返回指定产品类的数据信息
	 * 返回值为这个产品类的信息(Array)
	 * @param string|int $id 产品类的ID
	 * @param array $productClassinfo 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array
	 */
	function GetClassInfo($id,$classinfo=array()){
		global $db;
		$this->setTable('{tablepre}product_class');
		return parent::GetInfo($classinfo,"id=$id");
	}
	/**
	 * 函数UpdateClass,更新产品类信息
	 * 成功返回true 失败返回false
	 * @param string|int $id 产品类的ID
	 * @param array $productClassinfo 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function UpdateClass($id,$productClassinfo=array()){
		$this->setTable('{tablepre}product_class');
		if(parent::Update($productClassinfo,"id=$id")){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 函数DeleteClass,删除指定ID数组的产品分类
	 * 成功返回true 失败返回false
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean
	 */
	function DeleteClass($idarr){
		$this->setTable('{tablepre}product_class');
		if(parent::Del($idarr)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 函数GetClassName,返回产品类别名
	 * 成功返回true 失败返回false
	 * @param string|int $pid 产品类别ID
	 * @return string
	 */
	function GetClassName($pid){
		global $db;
		return $db->GetFieldValue('{tablepre}product_class','classname',"id=$pid");
	}
	/**
	 * 函数AddProduct,添加产品
	 * 返回值为文档的ID,失败返回0
	 * @param string $table 表名
	 * @param array $proinfo 产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int
	 */
	function Add($proinfo){
		//把主表和附加表分开来
		$this->setTable('{tablepre}product');
		foreach($proinfo as $key=>$value){
			if($key=='content' || $key=='keywords' ||  $key=='description'){
				$col_addon[$key]=$value;
			}else{
				$col_main[$key]=$value;
			}
		}
		$aid=parent::Add($col_main);
		
		if($aid){
			$col_addon['aid']=$aid;
			$this->setTable('{tablepre}product_addon');
			parent::Add($col_addon);
			return $aid;
		}else{
			return false;
		}
		exit;
	}
	/**
	 * 函数GetList,返回产品列表
	 * 返回这个列表数据的数组类型
	 * @param string|int $classid 产品类别ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @param string $where 条件，不要带where 如id=1
	 * @param string $order 排序，不要带order 如updatetime desc
	 * @param string $start 开始ID
	 * @param string $listnum 返回记录数
	 * @return array
	 */
	function GetList($classid,$col=array(),$start='',$listnum='',$order='istop desc,id desc'){
		$this->setTable('{tablepre}product');
		global $web_url;
		$classid=(int)$classid;
		if($classid!=0){
			$where.="classid=$classid";
		}
		$proinfo=parent::GetList($col,$start,$listnum,$where,$order);
		$proCount=count($proinfo);
		for($i=0;$i<$proCount;$i++){
			if(empty($proinfo[$i]['logo'])){
				$proinfo[$i]['logo']=$this->nopic;
			}else{
				$proinfo[$i]['logo']=$web_url.'/uploads/product/'.$proinfo[$i]['logo'];
				//echo $proinfo['logo'];
			}			
			$proinfo[$i]['url']="product.php?id=".$proinfo[$i]['id'];
		}
		return $proinfo;
	}
	/**
	 * 函数GetInfo,返回产品信息
	 * 返回值为这个文档的信息(Array)
	 * @param string|int $aid 产品ID
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
			 
			$newsInfo_1=parent::GetInfo($col,"id=$aid");			
			$this->setTable("{tablepre}product_addon");
			$newsInfo_2=parent::GetInfo($col_another,"aid=$aid");
			if(!is_array($newsInfo_1) ||!is_array($newsInfo_2)){
				return false;
			}else{
				$newsInfo=array_merge($newsInfo_1,$newsInfo_2);
			}
		}else{
			$newsInfo=parent::GetInfo($aid,$col);
		}
		//返回当前路径
		//获得栏目信息
		$proclassname=$this->GetClassName($newsInfo['classid']);
		$position='<a href="'.$web_url.'">首页</a>>><a href="'.$web_url.'/product_list.php?id='.$newsInfo['classid'].'">'.$proclassname.'</a>>>'.$newsInfo['title'];
		$newsInfo['position']=$position;
		
		if(empty($newsInfo['logo'])){
			$newsInfo['logo']=$this->nopic;
		}else{
			$newsInfo['logo']=$web_url.'/uploads/product/'.$newsInfo['logo'];
		}
		return $newsInfo;
	}
	/**
	 * 函数UpdateProduct,更新产品信息
	 * 成功返回true 失败返回false
	 * @param string|int $id 产品ID
	 * @param array $productinfo 产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean
	 */
	function Update($id,$productinfo){
		//把主表和附加表分开来
		foreach($productinfo as $key=>$value){
			if($key=='content' || $key=='keywords' ||  $key=='description'){
				$col_addon[$key]=$value;
			}else{
				$col_main[$key]=$value;
			}
		}
		
		if(parent::Update($col_main,"id=$id")){
			if(is_array($col_addon) && count($col_addon)>0){
				$this->setTable('{tablepre}news_addon');
				if(parent::Update($col_addon,"aid=$id")){
					return true;
				}else{
					return false;
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	/**
	 * 函数DeleteProduct,删除产品
	 * 成功返回true 失败返回false
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//这里的idarr是个数组
		//先删除缩略图
		foreach($idarr as $value){
			$logo=$this->GetLogo($value);
			if(strlen($logo)>0){
				//存在图片 就删除
				$file=WEB_DR."/uploads/product/".$logo;
				@unlink($file);
			}
		}
		if(parent::Del($idarr)){
			$this->setTable('{tablepre}product_addon');
			return parent::Del($idarr,'aid');
		}else{
			return false;
		}
	}
	/**
	 * 函数DeleteProduct,返回产品的LOGO
	 * 成功返回产品LOGO 失败返回''
	 * @param string|int $id 产品ID
	 * @param boolean $emptyFillDefault 当返回的LOGO为空时 是不是返回缩略图
	 * @return string
	 */
	function GetLogo($id,$emptyFillDefault=true){
		global $db;
		$sql="select logo from {tablepre}product where id=$id";
		$db->GetOne($sql);
		$logo=$db->f('logo');
		if(strlen($logo)==0 && $emptyFillDefault){
			$logo=$this->nopic;
		}
		return $logo;
	}
}
?>