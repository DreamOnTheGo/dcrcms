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
	 * 返回单个数据表的数据 主要是insert数据 版本号>=1.0.4
 	 * @param string $table_name 要返回的表
 	 * @param int $space 一个数据文件的大小 默认为2M
	 * @return array 数据的分割数组 比如12000分为两个数据 array('insert into sdfds...','insert into sdfds...')结果用result_arr返回
	 */
	function get_table_data($table_name, &$result_arr, $space=1000000)
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
}
?>