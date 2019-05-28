<?php
include_once($WEB_CLASS.'article_class.php');
/**
* ��ҳ�洦���࣬����̨�Ĺ�˾���ϴ���
* ��������и��¡����롢ɾ�����ŵȷ���
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Single extends Article{
	/**
	 * Article�Ĺ��캯�� ���贫����
	 */
	function __construct(){
		parent::__construct('{tablepre}single');
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
	 * ����GetInfo,���ص������ŵ���Ϣ����
	 * ������������
	 * @param string|int $aid �ĵ�ID
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @return array
	 */
	function GetInfo($aid,$col=array()){
		$newsInfo=parent::GetInfo($col,"id=$aid");
		$newsInfo['position']='<a href="'.$web_url.'">��ҳ</a>>>'.$newsInfo['title'];
		return $newsInfo;
	}
	/**
	 * ����Add,����һ����ҳ��
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $singleinfo ��������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return int
	 */
	function Add($singleinfo){		
		return parent::Add($singleinfo);
	}
	/**
	 * ����Update,����һ���ĵ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string|int $id �ĵ�ID
	 * @param array $singleInfo ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @return boolean
	 */
	function Update($id,$singleInfo){
		return parent::Update($singleInfo,"id=$id");
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
		$sql="update {tablepre}single set $jizhunclick=$jizhunclick+1 where id=$aid";
		return $db->ExecuteNoneQuery($sql);
	}
	/**
	 * ����Delete,ɾ��ָ��ID����ĵ�ҳ��
	 * �ɹ�����true ʧ�ܷ���false
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
	 * @return boolean
	 */
	function Delete($idarr){
		//�����idarr�Ǹ����� Ҫɾ����ID����
		return parent::Del($idarr);
	}
	/**
	 * ����GetList,���õ�ҳ���б�
	 * ���ط��������б�
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
	 * @return array
	 */
	function GetList($col=array(),$start='',$listnum='',$order='updatetime desc'){
		return parent::GetList($col,$start,$listnum,$where,$order);
	}
}
?>