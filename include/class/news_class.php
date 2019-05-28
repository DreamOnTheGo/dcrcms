<?php
include_once($WEB_CLASS.'article_class.php');
/**
* ���Ŵ�����
* ��������и��¡����롢ɾ�����ŵȷ���
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class News extends Article{
	/**
	 * Article�Ĺ��캯�� ���贫����
	 */
	function __construct(){
		parent::__construct('{tablepre}news');
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
	 * ����AddClass,������ŷ���
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $classinfo ��������ŷ��� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function AddClass($classinfo){
		$this->setTable('{tablepre}news_class');
		return parent::Add($classinfo);
	}
	/**
	 * ����GetClassList,�����������б�
	 * ��������б����ݵ���������
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
	 * @return array
	 */
	function GetClassList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		$this->setTable('{tablepre}news_class');
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
	/**
	 * ����GetClassInfo,�������ŷ����������Ϣ
	 * ����ֵΪ�����Ʒ�����Ϣ(Array)
	 * @param string|int $id ���ŷ���ID
	 * @param array $newsClassinfo Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetClassInfo($id,$classinfo=array()){
		global $db;
		$this->setTable('{tablepre}news_class');
		return parent::GetInfo($classinfo,"id=$id");
	}
	/**
	 * ����UpdateClass,�������ŷ�����Ϣ
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ���ŷ���ID
	 * @param array $classinfo ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
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
	 * ����DeleteClass,ɾ�����ŷ���
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
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
	 * ����GetClassNum,�������ŷ�������
	 * �������ŷ�������
	 * @return int
	 */
	function GetClassNum(){
		$this->setTable('{tablepre}news_class');
		return parent::GetListCount();
	}
	/**
	 * ����GetClassName,�������������
	 * �ɹ��������� ʧ�ܷ���''
	 * @param string|int $nid �������ID
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
	 * ����GetInfo,���ص������ŵ���Ϣ����
	 * ������������
	 * @param string|int $aid �ĵ�ID
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetInfo($aid,$col=array()){
		$this->setTable('{tablepre}news');
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
		//���ص�ǰ·��
		//�����Ŀ��Ϣ
		$artclassname=$this->GetClassName($newsInfo['classid']);
		$position='<a href="'.$web_url.'">��ҳ</a>>><a href="news_list.php">��������</a>>><a href="'.$web_url.'/news_list.php?id='.$newsInfo['classid'].'">'.$artclassname.'</a>>>'.$newsInfo['title'];
		$newsInfo['position']=$position;
		
		if(empty($newsInfo['logo'])){
			$newsInfo['logo']=$this->nopic;
		}else{
			$newsInfo['logo']=$web_url.'/uploads/news/'.$newsInfo['logo'];
		}
		return $newsInfo;
	}
	/**
	 * ����AddNews,����һ������
	 * ����ֵΪ�ĵ���ID,ʧ�ܷ���0
	 * @param array $newsinfo ��������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return int
	 */
	function Add($newsinfo){
		$this->setTable('{tablepre}news');
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
	 * ����Update,����һ���ĵ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id ����ID
	 * @param array $newsinfo ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function Update($id,$newsinfo){		
		$this->setTable('{tablepre}news');
		//������͸��ӱ�ֿ���
		foreach($newsinfo as $key=>$value){
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
	 * ����UpdateClick,�����ĵ��ĵ����
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $aid ����ID
	 * @param string $jizhunclick ���µĻ�׼������Ĭ��Ϊclick
	 * @return boolean
	 */
	function UpdateClick($aid,$jizhunclick='click'){
		global $db;
		$sql="update {tablepre}news set $jizhunclick=$jizhunclick+1 where id=$aid";
		return $db->ExecuteNoneQuery($sql);
	}
	/**
	 * ����Delete,ɾ��ָ��ID���������
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		$this->setTable('{tablepre}news');
		//�����idarr�Ǹ����� Ҫɾ����ID����
		if(parent::Del($idarr)){
			$this->setTable('{tablepre}news_addon');
			return parent::Del($idarr,'aid');
		}else{
			return false;
		}
	}
	/**
	 * ����GetLogo,�������ŵ�LOGO
	 * �ɹ�����LOGO ʧ�ܷ���''
	 * @param string|int $id ID
	 * @param boolean $emptyFillDefault �����ص�LOGOΪ��ʱ �ǲ��Ƿ�������ͼ
	 * @return string
	 */
	function GetLogo($id,$emptyFillDefault=true){
		global $db;
		$sql="select logo from {tablepre}news where id=$id";
		$db->GetOne($sql);
		$logo=$db->f('logo');
		if(strlen($logo)==0 && $emptyFillDefault){
			$logo=$this->nopic;
		}
		return $logo;
	}
	/**
	 * ����GetList,���������б�
	 * ���ط��������б�
	 * @param string|int $classid ��������
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param int $issystem �ǲ���ϵͳ���� 0Ϊ���ط�ϵͳ���� 1Ϊ����ϵͳ���� 2��ʾȫ������
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $whereoption ����
	 * @return array
	 */
	function GetList($classid,$col=array(),$start='',$listnum='',$order='istop desc,id desc',$whereoption=''){
		$this->setTable('{tablepre}news');
		if($classid!=0){
			$where="classid=$classid";
		}
		if(!empty($whereoption)){
			if(!empty($where)){
				$where.=' and'.$whereoption;
			}else{
				$where=$whereoption;
			}
		}
		$arr=parent::GetList($col,$start,$listnum,$where,$order);
		
		$a_sum=count($arr);
		for($i=0;$i<$a_sum;$i++){
			if(empty($arr[$i]['logo'])){
				$arr[$i]['logo']=$this->nopic;
			}else{
				$arr[$i]['logo']=$web_url.'/uploads/news/'.$arr[$i]['logo'];
				//echo $proinfo['logo'];
			}
			$arr[$i]['innerkey']=$i+1; //�ڲ�ʹ�õ��±�ֵ
			$arr[$i]['url']="news.php?id=".$arr[$i]['id'];
		}
		return $arr;
	}
	function GetNewsCount($classid){
		$this->setTable('{tablepre}news');
		if($classid!=0){
			$where='classid='.$classid;
		}
		return parent::GetListCount($where);
	}
}
?>