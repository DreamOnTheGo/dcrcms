<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 操作目录类
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v2.0
 * @package class
 * @since 1.0.8
*/
class cls_dir
{
	private $text;
	private $current_dir;//当前目录 或者文件
	
	/**
	 * @param string $c_dir 目录名 结尾不要带/
	 */
	function __construct($c_dir = ''){
		dir($c_dir);
		$this->current_dir = $c_dir;
	}
	
	/**
	 * 函数set_current_dir,设置当前操作目录
	 * @param string $current_dir 目录名
	 * @return boolean 返回true
	 */	
	function set_current_dir($current_dir = '')
	{
		$this-> current_dir = $current_dir;
	}
	
	/**
	 * 清空目录
	 * @param string $dir_name 目录名 这个参数主要是内部选代用
	 * @param array $no_delele_file 保留不删除的文件
	 * @return boolean 成功返回true 失败:如果返回r1 表示目录不存在 r2为文件不可写 r3表示不是目录
	 */
	function clear_dir($dir_name = '', $no_delele_file = array())
	{
		if(empty($dir_name))
		{
			$dir_name = $this-> current_dir;
		}
		if(is_dir($dir_name))
		{
			if($handle = opendir($dir_name))
			{
				while(false !== ($item = readdir($handle)))
				{
					if($item != "." && $item != ".."){
						if(is_dir($item))
						{
							$this-> clear_dir($dir_name . '/' . $item, $no_delele_file);
						}else{
							if(!in_array($item, $no_delele_file))
							{
								@unlink($dir_name . '/' . $item);
							}
						}
					}
				}
				closedir( $handle );
				return 'r1';
			}else{
				closedir( $handle );
				return 'r2';
			}
		}else{
			return 'r3';
		}
	}
	
	/**
	 * 返回一个目录的文件列表 注意 这个只能返回一级目录
	 * @return array 成功返回文件列表,失败返回false
	 */
	function get_file_list()
	{
		$dir_name = $this-> current_dir;
		$file_list = array();
		$row = 0;
		if(is_dir($dir_name))
		{
			if($handle = opendir($dir_name))
			{
				while(false !== ($item = readdir($handle)))
				{
					//echo $item;
					if($item!= "." && $item!= "..")
					{
						if(is_dir($dir_name . '/' . $item))
						{
						}else{
							$file_list[$row]['path'] = $dir_name . '/' . $item;
							$file_list[$row]['filename'] = $item;
							$row++;
						}
					}
				}
			}else{
			closedir( $handle );
			}
		}else{
		}
		
		return $file_list;
	}
	
	/**
	 * 返回一个目录下的目录列表 注意 这个只能返回一级目录
	 * @return array 成功返回目录列表,失败返回false
	 */
	function get_dir_list()
	{
		$dir_name = $this->current_dir;
		$file_list = array();
		$row = 0;
		if(is_dir($dir_name))
		{
			if($handle = opendir($dir_name))
			{
				while(false !== ($item = readdir($handle)))
				{
					//echo $item;
					if($item !=  "." && $item != "..")
					{
						if(is_dir($dir_name . '/' . $item))
						{
							$file_list[$row]['path'] = $dir_name . '/' .$item;
							$file_list[$row]['filename'] = $item;
							$row++;
						}else{
						}
					}
				}
			}else{
			closedir( $handle );
			}
		}else{
		}
		
		return $file_list;
	}
	/**
	 * 删除一个目录
	 * @return true
	 */
	function delete_dir($dir = '')
	{
		if(empty($dir))
		{
			$dir = $this-> current_dir;
		}
		$dir_name = $dir;//调试时用的 
		if($this->is_empty_dir($dir_name))
		{
			@rmdir($dir_name);//直接删除 
		}else
		{			
			if($handle = opendir($dir_name))
			{
				while(false !== ($item=readdir($handle)))
				{
					if($item !=  "." && $item != "..")
					{
						$path_dir = $dir_name . '/' . $item;
						if(is_dir($path_dir)){
							if($this-> is_empty_dir($path_dir))
							{
								rmdir($path_dir);//直接删除 
							}else{
								$this-> delete_dir($path_dir); 
							}
						}else{
							unlink($path_dir);
						}
					}
				}
				closedir( $handle );
			}else{
				closedir( $handle );
			}
			@rmdir($dir_name);//直接删除 
      	}
	}
	
	/**
	 * 判断是不是空目录
	 * @return true|false
	 */
	function is_empty_dir($path_dir)
	{
		if(empty($path_dir))
		{
			$path_dir = $this-> current_dir;
		}
		if(empty($path_dir))
		{
			return true;
		}
		$dhandle = opendir($path_dir); 
		$i = 0; 
   		while($t = readdir($dhandle)){
			$i++;
		}
		
		return $i>2;
	}
}

?>