<?php
/**
* ���´���Ļ��࣬һ�����´�����඼��Ϊ�������.
* ��������и��¡����롢ɾ���ĵ� ���л�ȡ���ݵȷ���
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Article{
	private $table; //�����ı���
	/**
	 * Article�Ĺ��캯�� ���贫����
	 * @param string $table ���������Ҫ�����ı���
	 * @return Article
	 */
	function __construct($table){
		$this->table=$table;
	}
	/**
	 * ����setTable,������Ҫ�����ı�
	 * ˵�� ���������Ҫ�����Ĳ��ǹ��캯���������õı�����Ҫͨ������������ñ�������ܽ�����һ������
	 * @param string $table ����
	 * @return true
	 */
	protected function setTable($table){
		$this->table=$table;
	}
	/**
	 * ����GetList,ʵ�ֶԱ������ݵĵ���(�б�����)
	 * ��������б����ݵ���������
	 * @param string $table ����
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $where ��������Ҫ��where ��id=1
	 * @param string $order ���򣬲�Ҫ��order ��updatetime desc
	 * @param string $start ��ʼID
	 * @param string $listnum ���ؼ�¼��
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
		$sql="select $cols from ".$this->table." $where $order $limit";
		$db->Execute($sql);
		$t_list=$db->GetArray();
		return $t_list;				
	}
	/**
	 * ����GetInfo,���ص����ĵ�������
	 * ����ֵΪ����ĵ�����Ϣ(Array)
	 * @param string $table ����
	 * @param array $col Ҫ���ص��ֶ��� ����Ҫ����id,titleΪ��array('id','title') ���Ϊarrya()ʱ����ȫ���ֶ�
	 * @param string $where ��������Ҫ��where ��id=1
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
	 * ����Add,����һ���ĵ�
	 * ����ֵΪ�ĵ���ID,ʧ�ܷ���0
	 * @param string $table ����
	 * @param array $info ��������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
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
	 * ����Update,����һ���ĵ�
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string $table ����
	 * @param array $info ���µ����� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
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
	 * ����Del,ɾ��ָ��ID�������������
	 * �ɹ�����true ʧ�ܷ���false
	 * @param string $table ����
	 * @param array $idarr ɾ����ID���� ����Ҫɾ��IDΪ1��2��3���ĵ� ��Ϊ��array(1,2,3)
	 * @param string $jizhuncol ɾ���Ļ�׼������Ĭ��ΪID ��ɾ��ID=1���ĵ� Ҫɾ��aid=1���ĵ������ֵΪ'aid'
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
	 * ����GetListCount,����ָ���ĵ��������ĵ���
	 * �ɹ��򷵻ؼ�¼�� ʧ�ܷ���0
	 * @param string $table ����
	 * @param array $where ����
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