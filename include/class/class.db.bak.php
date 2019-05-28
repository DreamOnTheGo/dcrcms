<?php
defined('IN_DCR') or exit('No permission.'); 

/**
* 数据库备份还原类 只针对mysql 不支持sqlite
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class cls_db_bak
{
	private $db;
	private $table_list;
	/**
	 * cls_db_bak的构造函数 初始化一个DB进去
	 */
	function __construct($db=null)
	{
		if(is_null($db)){
			global $db;
			$this->db=$db;
		}else{
			$this->db=$db;			
		}
	}
	/**
	 * 获取一个数据库里的表
 	 * @param boolean $is_system_table 为true时获取全部表 为false时获取企业站系统表 这个参数目前不支持 以后留用
	 * @return array 成功返回数据库睛的指定条件表
	 */
	function get_table_list($is_system_table = true)
	{
		$sql = 'show tables';
		$table_list = array();
		$table_arr = $this->db->execute($sql, MYSQL_NUM);
		foreach($table_arr as $table)
		{
			array_push($table_list, $table[0]);
		}
		
		return $table_list;
	}
	
	/**
	 * 设置本类要操作的表
 	 * @param array $talbe_list 要操作的表
	 * @return boolean(true)
	 */
	function set_tables($table_list)
	{
		$this->table_list = $table_list;
	}
	
	/**
	 * 获取表的创建语句 版本号>=1.0.4
 	 * @param boolean $is_add_drop 是否添加drop table语句
	 * @return array 成功返回表的创建语句
	 */
	function get_create_table_sql($is_add_drop = true)
	{
		$t_str='';
		//
		foreach($this->table_list as $table_name){
			if($is_add_drop){
				$drop_sql="DROP TABLE IF EXISTS `$table_name`;";
				$t_str.=$drop_sql."\r\n";
			}
			$sql = 'show create table '.$table_name;
			$table_create_arr = $this->db->execute($sql,MYSQL_NUM);
			$t_str .= $table_create_arr[0][1].";\r\n\r\n";
			//echo $t_str;
		}
		return $t_str;
	}
	/**
	 * 返回单个数据表的数据 主要是insert数据 版本号>=1.0.4 1.0.9及1.0.9后废弃
 	 * @param string $table_name 要返回的表
 	 * @param int $space 一个数据文件的大小 默认为2M
	 * @return array 数据的分割数组 比如12000分为两个数据 array('insert into sdfds...','insert into sdfds...')结果用result_arr返回
	 */
	function get_table_data($table_name, &$result_arr, $space = 1000000)
	{
		$c_index = 0;
		$sql_bak = "select * from $table_name";
		$table_cols = $this->db->get_table_col($table_name);
		foreach($table_cols as $col)
		{
			$cols .= $col.',';
		}
		$cols =substr($cols,0,strlen($cols)-1);
		$r = $this->db->execute($sql_bak);
		foreach($r as $value)
		{
			$insert_sql = "insert into $table_name($cols) values(";
			foreach($table_cols as $col)
			{
				$insert_sql .= "'".addslashes($value[$col])."',";
			}
			$insert_sql = substr($insert_sql,0,strlen($insert_sql)-1);
			$insert_sql .= ");";
			if(strlen($result_arr[$c_index])>=$space)++$c_index;
			$result_arr[$c_index].=$insert_sql."\r\n";
		}
		
		return true;
	}
    
	/**
	 * 把记录写到文件里
 	 * @version>1.0.9
 	 * @param string $table_name 要返回的表
 	 * @param int $space 一个数据文件的大小 默认为2M
	 * @return true;
	 */
	function write_table_data_to_file($table_name, $space = 2000000)
	{
		//这里为了大数据的备份，我们要用最原始的操作
		//INSERT INTO `shop_yz` (`id`) VALUES(99974),(99975)
		$sql = 'select * from ' . $table_name;
		$table_cols = $this->db->get_table_col($table_name);
		$col_name_list = implode($table_cols, '`,`');
		$col_name_list = '`' . $col_name_list . '`';

		$conn = $this->db->get_conn();
		$rs = mysql_query('select * from ' . $table_name, $conn);
		$insert_sql_txt = ''; //插入语句
		$file_index = 0;
		$cur_index = 0; //当前操作到的数据是第几条
		$rs_num = mysql_num_rows($rs);
		if( $rs_num == 0 )
		{
			return false;
		}
		while($row = mysql_fetch_row($rs))
		{
			foreach( $row as $row_key=> $row_value)
			{
				$row[$row_key] = addslashes( $row_value );
			}
			
			$insert_sql = implode($row, "','");
			$insert_sql = "('" . $insert_sql . "'),\r\n";
			$insert_sql_txt .= $insert_sql;
			if( (strlen($insert_sql_txt) > $space) && ($cur_index < $rs_num - 1) )
			{
				//超大的文件了

				$insert_sql_txt = substr( $insert_sql_txt, 0, strlen($insert_sql_txt) - 3 ); //去除字符串尾的'\r\n,' 才能加上';' 哦耶！
				$insert_sql_txt = "insert into $table_name ($col_name_list) values\r\n" . $insert_sql_txt . ';';
				$this->write_data_to_file($insert_sql_txt, $table_name, $file_index);
				$insert_sql = '';
				$insert_sql_txt = '';
				$file_index ++ ;
			}
			$cur_index ++;
		}

		$insert_sql_txt = substr( $insert_sql_txt, 0, strlen($insert_sql_txt) - 3 ); //去除字符串尾的'\r\n,' 才能加上';' 哦耶！
		$insert_sql_txt = "insert into $table_name ($col_name_list) values\r\n" . $insert_sql_txt . ';';
		$this->write_data_to_file($insert_sql_txt, $table_name, $file_index);
	}	
    
	/**
	 * 把备份内容写文件
 	 * @version>1.0.9
 	 * @param string $insert_sql_txt sql内容
 	 * @param string $table_name 要返回的表
 	 * @param int $file_index 文件标记
	 * @return true;
	 */
	function write_data_to_file($insert_sql_txt, $table_name, $file_index){		
		require_once(WEB_CLASS . '/class.file.php');

		$data_file_name = WEB_MYSQL_BAKDATA_DIR . '/' .$table_name . '_' . $file_index . '_' 
						  . substr( md5(time() . mt_rand(1000, 5000) ), 0, 16) . '.txt';
		$cls_file = new cls_file($data_file_name);
		$cls_file->set_text($insert_sql_txt);
		$cls_file-> write();	
		echo "$table_name(分卷$file_index)备份成功<br>";
	}
}
?>