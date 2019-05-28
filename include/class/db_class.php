<?php
/**
* 数据库处理
* @author 我不是稻草人 www.cntaiyn.cn
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
	 * DB的构造函数
	 * 成功返回一个连接的resource
 	 * @param string $db_type 数据库类型
 	 * @param string $host 数据库地址
	 * @param string $name 数据库用户名
	 * @param string $pass 数据库密码
	 * @param string $table 数据库名
	 * @param string $ut 数据库编码
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
	 * 函数connect 连接数据库的函数
	 * 这个方法为类自动调用，不用我们手动调用
	 * @return null
	 */
	function connect(){
		if($this->db_type=='1'){
			try{
				$db_path=WEB_DATA.$this->host;
				$this->pdo=new PDO("sqlite:".$db_path);
			}catch(PDOException $e) {
    			echo '连接失败: '.$e->getMessage();
			}
		}else if($this->db_type=='2'){
			if(!$this->conn){
				$this->conn=mysql_connect($this->host,$this->name,$this->pass)or die('连接数据库失败，请检查您的数据库配置');
			}else{
				return false;
			}
			mysql_select_db($this->table,$this->conn) or die('选择数据库失败,请检查数据库['.$this->table.']是否创建');
			mysql_query("SET NAMES '$this->ut'");
		}
	}
	/**
	 * 函数option 全局处理sql语句,DB类的每个sql语句执行前要通过这个来处理下
	 * 返回处理后的sql语句
	 * @param string $sql 要处理的sql语句
	 * @return string
	 */
	function option($sql){
		global $tablepre;
		$sql=str_replace('{tablepre}',$tablepre,$sql);//替换表名
		$sql=$this->SafeSql($sql);//安全处理sql
		return $sql;
	}
	/**
	 * 函数Execute,执行$sql
	 * 返回执行结果，我们用DB->Next('colname')函数来获取值
	 * @param string $sql 要执行的sql语句
	 * @param int $result_type 返回记录集的类型 默认为MYSQL_ASSOC
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
					if($web_tiaoshi=='1'){die('执行sql：['.$sql.']时失败，请检查您的SQL语句'.mysql_error());}
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
	 * 函数ExecuteNoneQuery,执行一个不要返回结果的$sql 如update insert
	 * 成功返回true 失败返回false;
	 * @param string $sql 要执行的sql语句
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
	 * 函数GetOne,执行返回一行结果
	 * 成功返回记录集 失败返回false;
	 * @param string $sql 要执行的sql语句
	 * @param int $result_type 返回记录集的类型 默认为MYSQL_ASSOC
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
	 * 函数Next,用来返回记录集 同时滚动到下一条
	 * 成功返回记录集 失败返回false;
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
	 * 函数f,用来返回记录集中指定字段的值
	 * 成功返回值 失败返回false;
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
	 * 函数GetArray,用来返回记录集的数组形式
	 * 成功数组 失败返回false;
	 * @return array
	 */
	function GetArray(){	
		return $this->result;
	}
	/**
	 * 函数GetRsNum,用来返回记录集的记录数
	 * 成功记录数 失败返回0;
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
	 * 函数GetColArray,返回当前记录集的列表名 比如select a,b from c 则返回数组array('a','b')
	 * 成功记录集的array 失败返回0;
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
	 * 函数GetFieldValue,获取指定表指定字段的值
	 * 成功返回字段值 失败返回false;
	 * @param string $tableName 表名
	 * @param string $fieldName 字段名
	 * @param string $whereSql 条件
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
	 * 函数HasRs,获取是不是有这个记录
	 * 成功返回true 失败返回false;
	 * @param string $tableName 表名
	 * @param string $fieldName 字段名
	 * @param string $whereSql 条件
	 * @return boolean
	 */
	function HasRs($sql){
		$t_arr=$this->GetOne($sql,MYSQL_NUM);	
		return is_array($t_arr);
	}
	/**
	 * 函数GetInsertId,取得上一步INSERT 操作产生的 ID
	 * 成功返回值 失败返回false;
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
	 * 函数GetTableCol,返回一个表的所有列
	 * 成功返回所有列的array 失败返回false;
	 * @param string $tableName 表名
	 * @return array
	 */
	function GetTableCol($tableName){
		//返回一个表的所有列
		$sql="show columns from $tableName";
		$result=mysql_query($sql);
		$t_arr=array();
		while($rs=mysql_fetch_array($result)){
			$t_arr[]=$rs['Field'];
		}
		return $t_arr;
	}
	/**
	 * 函数GetVersion,返回当前数据库的版本
	 * @return string
	 */
	function GetVersion(){
		//获得数据库版本信息
		$version = mysql_query("SELECT VERSION();",$this->conn);
		$row = mysql_fetch_array($version);
		$mysqlVersions = explode('.',trim($row[0]));
		$mysqlVersion = $mysqlVersions[0].".".$mysqlVersions[1];
		return $mysqlVersion;
	}
	/**
	 * 函数CloseDB,关闭当前数据库连接
	 * @return boolean
	 */
	function CloseDB(){
		@mysql_free_result($this->result);
		@mysql_close($this->conn);
	}
	/**
	 * 函数SafeSql,语句过滤程序
	 * 返回一个sql语句安全处理后的sql
	 * @param string $db_string 要处理的sql语句
	 * @param string $querytype 要处理的sql语句的类型
	 * @return string
	 */
	function SafeSql($db_string,$querytype='select'){
		//var_dump($db_string);
		//完整的SQL检查
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

		//老版本的Mysql并不支持union，常用的程序里也不使用union，但是一些黑客使用它，所以检查它
		if (strpos($clean, 'union') !== false && preg_match('~(^|[^a-z])union($|[^[a-z])~s', $clean) != 0)
		{
			$fail = true;
			$error="union detect";
		}

		//发布版本的程序可能比较少包括--,#这样的注释，但是黑客经常使用它们
		elseif (strpos($clean, '/*') > 2 || strpos($clean, '--') !== false || strpos($clean, '#') !== false)
		{
			$fail = true;
			$error="comment detect";
		}

		//这些函数不会被使用，但是黑客会用它来操作文件，down掉数据库
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

		//老版本的MYSQL不支持子查询，我们的程序里可能也用得少，但是黑客可以使用它来查询数据库敏感信息
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