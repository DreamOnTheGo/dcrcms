<?php
include_once($WEB_CLASS.'article_class.php');
/**
* ��Ʒ������
* ��������и��¡����롢ɾ����Ʒ�ȷ���
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Product extends Article{
	/**
	 * Product�Ĺ��캯�� ���贫����
	 */
	 private $nopic;
	function __construct(){
		global $web_url;
		parent::__construct('{tablepre}product');
		$this->nopic=$web_url.'/include/images/nopic.png';
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
	 * ����AddClass,��Ӳ�Ʒ����
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $proclassinfo ����Ĳ�Ʒ���� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function AddClass($proclassinfo){
		//��Ӳ�Ʒ����
		$this->setTable('{tablepre}product_class');
		return parent::Add($proclassinfo);
	}
	/**
	 * ����GetClassList,���ز�Ʒ���б�
	 * ��������б����ݵ���������
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
	 * @return array
	 */
	function GetClassList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		$this->setTable('{tablepre}product_class');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * ����GetClassInfo,����ָ����Ʒ���������Ϣ
	 * ����ֵΪ�����Ʒ�����Ϣ(Array)
	 * @param string|int $id ��Ʒ���ID
	 * @param array $productClassinfo Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetClassInfo($id,$classinfo=array()){
		global $db;
		$this->setTable('{tablepre}product_class');
		return parent::GetInfo($classinfo,"id=$id");
	}
	/**
	 * ����UpdateClass,���²�Ʒ����Ϣ
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ��Ʒ���ID
	 * @param array $productClassinfo ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
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
	 * ����DeleteClass,ɾ��ָ��ID����Ĳ�Ʒ����
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
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
	 * ����GetClassName,���ز�Ʒ�����
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $pid ��Ʒ���ID
	 * @return string
	 */
	function GetClassName($pid){
		global $db;
		return $db->GetFieldValue('{tablepre}product_class','classname',"id=$pid");
	}
	/**
	 * ����AddProduct,��Ӳ�Ʒ
	 * ����ֵΪ�ĵ���ID,ʧ�ܷ���0
	 * @param string $table ����
	 * @param array $proinfo ��Ʒ���� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return int
	 */
	function Add($proinfo){
		//������͸��ӱ�ֿ���
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
	 * ����GetList,���ز�Ʒ�б�
	 * ��������б����ݵ���������
	 * @param string|int $classid ��Ʒ���ID
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $where ��������Ҫ��where ��id=1
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
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
	 * ����GetInfo,���ز�Ʒ��Ϣ
	 * ����ֵΪ����ĵ�����Ϣ(Array)
	 * @param string|int $aid ��ƷID
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetInfo($aid,$col=array()){
		global $db,$web_url;
		//Ҫ������ĿID
		if(!in_array('classid',$col)){
			array_push($col,'classid');
		}
		if(in_array('content',$col) || in_array('keywords',$col) || in_array('description',$col)){
			//���Ҫ�������� �����ڲ�ͬ�ı� ����Ҫ���⴦��
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
		//���ص�ǰ·��
		//�����Ŀ��Ϣ
		$proclassname=$this->GetClassName($newsInfo['classid']);
		$position='<a href="'.$web_url.'">��ҳ</a>>><a href="'.$web_url.'/product_list.php?id='.$newsInfo['classid'].'">'.$proclassname.'</a>>>'.$newsInfo['title'];
		$newsInfo['position']=$position;
		
		if(empty($newsInfo['logo'])){
			$newsInfo['logo']=$this->nopic;
		}else{
			$newsInfo['logo']=$web_url.'/uploads/product/'.$newsInfo['logo'];
		}
		return $newsInfo;
	}
	/**
	 * ����UpdateProduct,���²�Ʒ��Ϣ
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ��ƷID
	 * @param array $productinfo ��Ʒ���� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function Update($id,$productinfo){
		//������͸��ӱ�ֿ���
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
	 * ����DeleteProduct,ɾ����Ʒ
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//�����idarr�Ǹ�����
		//��ɾ������ͼ
		foreach($idarr as $value){
			$logo=$this->GetLogo($value);
			if(strlen($logo)>0){
				//����ͼƬ ��ɾ��
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
	 * ����DeleteProduct,���ز�Ʒ��LOGO
	 * �ɹ����ز�ƷLOGO ʧ�ܷ���''
	 * @param string|int $id ��ƷID
	 * @param boolean $emptyFillDefault �����ص�LOGOΪ��ʱ �ǲ��Ƿ�������ͼ
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