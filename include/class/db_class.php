<?php
/**
* ���ݿ⴦��
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class DB{
	private $pdo;
	
	private $db_type;
	private $host;
	private $name;
	private $pass;
	private $table;
	private $ut;
	private $conn;
	
	private $result;
	private $rs;
	/**
	 * DB�Ĺ��캯��
	 * �ɹ�����һ�����ӵ�resource
 	 * @param string $db_type ���ݿ�����
 	 * @param string $host ���ݿ��ַ
	 * @param string $name ���ݿ��û���
	 * @param string $pass ���ݿ�����
	 * @param string $table ���ݿ���
	 * @param string $ut ���ݿ����
	 * @return resource
	 */
	function __construct($db_type,$host,$name,$pass,$table,$ut){
		$this->db_type=$db_type;
		$this->host=$host;
		$this->name=$name;
		$this->pass=$pass;
		$this->table=$table;	
		$this->ut=$ut;	
		if(!$this->conn){
			$this->connect();
		}
	}
	/**
	 * ����connect �������ݿ�ĺ���
	 * �������Ϊ���Զ����ã����������ֶ�����
	 * @return null
	 */
	function connect(){
		if($this->db_type=='1'){
			try{
				$db_path=WEB_DATA.$this->host;
				$this->pdo=new PDO("sqlite:".$db_path);
			}catch(PDOException $e) {
    			echo '����ʧ��: '.$e->getMessage();
			}
		}else if($this->db_type=='2'){
			if(!$this->conn){
				$this->conn=mysql_connect($this->host,$this->name,$this->pass)or die('�������ݿ�ʧ�ܣ������������ݿ�����');
			}else{
				return false;
			}
			mysql_select_db($this->table,$this->conn) or die('ѡ�����ݿ�ʧ��,�������ݿ�['.$this->table.']�Ƿ񴴽�');
			mysql_query("SET NAMES '$this->ut'");
		}
	}
	/**
	 * ����option ȫ�ִ���sql���,DB���ÿ��sql���ִ��ǰҪͨ�������������
	 * ���ش�����sql���
	 * @param string $sql Ҫ�����sql���
	 * @return string
	 */
	function option($sql){
		global $tablepre;
		$sql=str_replace('{tablepre}',$tablepre,$sql);//�滻����
		$sql=$this->SafeSql($sql);//��ȫ����sql
		return $sql;
	}
	/**
	 * ����Execute,ִ��$sql
	 * ����ִ�н����������DB->Next('colname')��������ȡֵ
	 * @param string $sql Ҫִ�е�sql���
	 * @param int $result_type ���ؼ�¼�������� Ĭ��ΪMYSQL_ASSOC
	 * @return boolean
	 */
	function Execute($sql,$result_type=MYSQL_ASSOC){
		$sql=$this->option($sql);
		//echo $sql;
		if(strlen($sql)>0){
			unset($this->result);
			if($this->db_type=='1'){
				$arr_t=$this->pdo->query($sql);
				$this->result=$arr_t->fetchAll(); 
				//$this->result=$arr_t;
				unset($arr_t);
			}elseif($this->db_type=='2'){
				if($arr_t=mysql_query($sql)){
				}else{
					global $web_tiaoshi;
					if($web_tiaoshi=='1'){die('ִ��sql��['.$sql.']ʱʧ�ܣ���������SQL���'.mysql_error());}
				}				
				$arr=array();
				while($row=mysql_fetch_array($arr_t,$result_type)){
					$arr[]=$row;
				}
				$this->result=$arr;
				unset($arr_t);
				unset($arr);
			}
			return $this->result;
		}else{
			return false;
		}
	}
	/**
	 * ����ExecuteNoneQuery,ִ��һ����Ҫ���ؽ����$sql ��update insert
	 * �ɹ�����true ʧ�ܷ���false;
	 * @param string $sql Ҫִ�е�sql���
	 * @return boolean
	 */
	function ExecuteNoneQuery($sql){
		$sql=$this->option($sql);
		if(!empty($sql)){
			if($this->db_type=='1'){
				$this->pdo->exec($sql);
				$err_no=$this->pdo->errorCode();
				return $err_no==0;
			}elseif($this->db_type=='2'){
				return mysql_query($sql);
			}
		}else{
			return false;
		}
	}
	/**
	 * ����GetOne,ִ�з���һ�н��
	 * �ɹ����ؼ�¼�� ʧ�ܷ���false;
	 * @param string $sql Ҫִ�е�sql���
	 * @param int $result_type ���ؼ�¼�������� Ĭ��ΪMYSQL_ASSOC
	 * @return boolean
	 */
	function GetOne($sql,$result_type=MYSQL_ASSOC){
		if(!empty($sql))
		{
			if(!eregi("limit",$sql)){
				$sql=eregi_replace("[,;]$",'',trim($sql))." limit 0,1;";
			}
		}
		$this->Execute($sql,$result_type);
		return current($this->result);
	}
	/**
	 * ����Next,�������ؼ�¼�� ͬʱ��������һ��
	 * �ɹ����ؼ�¼�� ʧ�ܷ���false;
	 * @return resource|boolean
	 */
	function Next(){
		unset($this->rs);
		if(!$this->result){return false;}
		$rs=current($this->result);
		if(is_array($rs) && count($rs)>0){
			next($this->result);
			$this->rs=$rs;
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ����f,�������ؼ�¼����ָ���ֶε�ֵ
	 * �ɹ�����ֵ ʧ�ܷ���false;
	 * @return string|boolean
	 */
	function f($name){
		if(is_array($this->rs)){
            return $this->rs[$name];
        }else{
            return false;
        }
	}
	/**
	 * ����GetArray,�������ؼ�¼����������ʽ
	 * �ɹ����� ʧ�ܷ���false;
	 * @return array
	 */
	function GetArray(){	
		return $this->result;
	}
	/**
	 * ����GetRsNum,�������ؼ�¼���ļ�¼��
	 * �ɹ���¼�� ʧ�ܷ���0;
	 * @return int
	 */
	function GetRsNum(){
		if(!$this->result){
			return 0;
		}else{
			return count($this->result);
		}
	}
	/**
	 * ����GetColArray,���ص�ǰ��¼�����б��� ����select a,b from c �򷵻�����array('a','b')
	 * �ɹ���¼����array ʧ�ܷ���0;
	 * @return array
	 */
	function GetColArray(){
		$arr_t=$this->result;
		foreach($arr_t as $key=>$value){
			array_push($arr_t,$key);	
			
		}
		return $arr_t;
	}
	/**
	 * ����GetFieldValue,��ȡָ����ָ���ֶε�ֵ
	 * �ɹ������ֶ�ֵ ʧ�ܷ���false;
	 * @param string $tableName ����
	 * @param string $fieldName �ֶ���
	 * @param string $whereSql ����
	 * @return string
	 */
	function GetFieldValue($tableName,$fieldName,$whereSql=''){	
		if(strlen($whereSql)>0){
			$sql="select $fieldName from $tableName where $whereSql";
		}else{
			$sql="select $fieldName from $tableName";
		}
		$arr_t=$this->GetOne($sql,MYSQL_NUM);	
		return $arr_t[0];
	}
	/**
	 * ����HasRs,��ȡ�ǲ����������¼
	 * �ɹ�����true ʧ�ܷ���false;
	 * @param string $tableName ����
	 * @param string $fieldName �ֶ���
	 * @param string $whereSql ����
	 * @return boolean
	 */
	function HasRs($sql){
		$t_arr=$this->GetOne($sql,MYSQL_NUM);	
		return is_array($t_arr);
	}
	/**
	 * ����GetInsertId,ȡ����һ��INSERT ���������� ID
	 * �ɹ�����ֵ ʧ�ܷ���false;
	 * @return int
	 */
	function GetInsertId(){
		if($this->db_type=='1'){
			return $this->pdo->lastInsertId();
		}elseif($this->db_type=='2'){
			return @mysql_insert_id();
		}
	}
	/**
	 * ����GetTableCol,����һ�����������
	 * �ɹ����������е�array ʧ�ܷ���false;
	 * @param string $tableName ����
	 * @return array
	 */
	function GetTableCol($tableName){
		//����һ�����������
		$sql="show columns from $tableName";
		$result=mysql_query($sql);
		$t_arr=array();
		while($rs=mysql_fetch_array($result)){
			$t_arr[]=$rs['Field'];
		}
		return $t_arr;
	}
	/**
	 * ����GetVersion,���ص�ǰ���ݿ�İ汾
	 * @return string
	 */
	function GetVersion(){
		//������ݿ�汾��Ϣ
		$version = mysql_query("SELECT VERSION();",$this->conn);
		$row = mysql_fetch_array($version);
		$mysqlVersions = explode('.',trim($row[0]));
		$mysqlVersion = $mysqlVersions[0].".".$mysqlVersions[1];
		return $mysqlVersion;
	}
	/**
	 * ����CloseDB,�رյ�ǰ���ݿ�����
	 * @return boolean
	 */
	function CloseDB(){
		@mysql_free_result($this->result);
		@mysql_close($this->conn);
	}
	/**
	 * ����SafeSql,�����˳���
	 * ����һ��sql��䰲ȫ������sql
	 * @param string $db_string Ҫ�����sql���
	 * @param string $querytype Ҫ�����sql��������
	 * @return string
	 */
	function SafeSql($db_string,$querytype='select'){
		//var_dump($db_string);
		//������SQL���
		if(empty($db_string)){
			return false;
		}
		while (true){			
			$pos = strpos($db_string, '\'', $pos + 1);
			if ($pos === false)
			{
				break;
			}
			$clean .= substr($db_string, $old_pos, $pos - $old_pos);
			while (true)
			{
				$pos1 = strpos($db_string, '\'', $pos + 1);
				$pos2 = strpos($db_string, '\\', $pos + 1);
				if ($pos1 === false)
				{
					break;
				}
				elseif ($pos2 == false || $pos2 > $pos1)
				{
					$pos = $pos1;
					break;
				}
				$pos = $pos2 + 1;
			}
			$clean .= '$s$';
			$old_pos = $pos + 1;
		}
		$clean .= substr($db_string, $old_pos);
		$clean = trim(strtolower(preg_replace(array('~\s+~s' ), array(' '), $clean)));

		//�ϰ汾��Mysql����֧��union�����õĳ�����Ҳ��ʹ��union������һЩ�ڿ�ʹ���������Լ����
		if (strpos($clean, 'union') !== false && preg_match('~(^|[^a-z])union($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="union detect";
		}

		//�����汾�ĳ�����ܱȽ��ٰ���--,#������ע�ͣ����Ǻڿ;���ʹ������
		elseif (strpos($clean, '/*') > 2 || strpos($clean, '--') !== false || strpos($clean, '#') !== false)
		{
			$fail = true;
			$error="comment detect";
		}

		//��Щ�������ᱻʹ�ã����Ǻڿͻ������������ļ���down�����ݿ�
		elseif (strpos($clean, 'sleep') !== false && preg_match('~(^|[^a-z])sleep($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="slown down detect";
		}
		elseif (strpos($clean, 'benchmark') !== false && preg_match('~(^|[^a-z])benchmark($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="slown down detect";
		}
		elseif (strpos($clean, 'load_file') !== false && preg_match('~(^|[^a-z])load_file($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="file fun detect";
		}
		elseif (strpos($clean, 'into outfile') !== false && preg_match('~(^|[^a-z])into\s+outfile($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="file fun detect";
		}

		//�ϰ汾��MYSQL��֧���Ӳ�ѯ�����ǵĳ��������Ҳ�õ��٣����ǺڿͿ���ʹ��������ѯ���ݿ�������Ϣ
		elseif (preg_match('~\([^)]*?select~s', $clean) != 0)
		{
			$fail = true;
			$error="sub select detect";
		}
		if (!empty($fail))
		{
			fputs(fopen($log_file,'a+'),"$userIP||$getUrl||$db_string||$error\r\n");
			exit("<font size='5' color='red'>Safe Alert: Request Error step 2!</font>");
		}
		else
		{
			return $db_string;
		}
	}
}
?>