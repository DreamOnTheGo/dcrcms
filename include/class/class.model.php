<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 互动信息处理类
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0
 * @package class
 * @since 1.0.8
*/

require_once(WEB_CLASS . '/class.data.php');

class cls_model extends cls_data
{
	private $model_id;
	
	/**
	 * @param int $model_id 模型ID
	 * @return cls_model
	 */
	function __construct( $model_id = 0 )
	{
		parent::__construct('{tablepre}model');
		$this->model_id = $model_id;
	}	
	
	/**
	 * 设置类要操作的表
	 * @param string $table 表名
	 * @return true
	 */
	function set_table($table)
	{
		parent:: set_table($table);
	}
	
	/**
	 * 添加互动信息
	 * @param array $info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 返回值为文档的ID,失败返回0
	 */
	function add($info)
	{
		global $db_code;
		$this->set_table('{tablepre}model');
		
		if( parent::insert($info) )
		{
			//生成表
			global $db_tablepre;
			$creat_table_sql = 'CREATE TABLE  `' . $db_tablepre . $info['model_table_name'] . '` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(5) unsigned DEFAULT NULL,`add_time` int(12) unsigned,`update_time` int(12) unsigned,PRIMARY KEY (`id`))ENGINE=MyISAM DEFAULT CHARSET=' . $db_code . ';';
			return parent:: execute_none_query( $creat_table_sql );
		} else
		{
			return false;
		}
	}
	
	 /**
	 * 用来获取互动信息
	 * @param string $type 互动信息类型 0为全部 1为未读 2为已读
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @return array 返回这个列表数据
	 */
	function get_list( $canshu = array() )
	{
		$this->set_table('{tablepre}model');
				
		return parent::select_ex($canshu);
	}
	
	/**
	 * 删除指定ID数组的所有文章
	 * @param array $idarr 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean 成功返回true 失败返回false
	 */
	function delete($model_id)
	{
		$this->set_table('{tablepre}model');
		//删除表
		$model_info = $this->get_info( $model_id );
		
		$sql_alter = "drop table @#@{$model_info['model_table_name']}";
		
		parent::execute_none_query($sql_alter);
		
		$this->set_table('{tablepre}model');
		parent::delete_ex( "id=$model_id" );
		
		$this->set_table('{tablepre}model_field ');
		parent::delete_ex( "model_id=$model_id" );
		
		return true;
		
	}
	
	/**
	 * 获取指定ID的互动信息
	 * @param string|int $id 互动信息的ID
	 * @return array 成功返回id为$id的互动信息的内容 失败返回false
	 */ 
	function get_info( $id = 0 )
	{
		if( 0 == $id )
		{
			$id = $this->model_id;
		}
		$this->set_table('{tablepre}model');
		$canshu['where'] = "id=$id";
		$info = parent::select_one_ex($canshu);
		
		return $info;
	}
	
	/**
	 * 返回指定类型的信息的数量
	 * @param int $type 信息设置为的类型
	 * @return boolean 成功返回数量 失败返回false
	 */
	function get_num()
	{
		$model_info = $this->get_info( $this->model_id );
		$cls_data = cls_app:: get_d( '@#@' . $model_info['model_table_name'] );
		$info_sum = $cls_data->select_one_ex( array('col'=>'count(id) as sum', 'where'=>$where) );
		
		return $info_sum['sum'];
	}
	
	/**
	 * 获取指定ID的字段的信息
	 * @param string|int $id 字段ID
	 * @return array 成功返回id为$id的互动信息的内容 失败返回false
	 */ 
	function get_field_info($id)
	{
		$this->set_table('{tablepre}model_field');
		$canshu['where'] = "id=$id";
		$info = parent::select_one_ex($canshu);
		
		return $info;
	}
	
	/**
	 * 为互动表单增加字段
	 * @param array $field_info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function add_field($field_info)
	{
		$model_info = $this->get_info( $field_info['model_id'] );
		
		if($field_info['dtype'] == 'multitext')
		{
			$add_col_sql = "column `" . $field_info['field_name'] . "` MEDIUMTEXT";
		}else
		{
			if( ! strlen( $field_info['maxlength'] ) )
			{
				$field_info['maxlength'] = 200;
			}
			
			$add_col_sql = "column `" . $field_info['field_name'] . "` varchar(" . $field_info['maxlength'] . ") default ''";		
		}
		
		$sql_alter = "alter table {tablepre}" . $model_info['model_table_name'] . " add $add_col_sql";
		
		if( parent::execute_none_query($sql_alter) )
		{
			//return true;
			$this->set_table('{tablepre}model_field');
			
			return parent::insert($field_info);
		}else
		{
			
			return false;
		}
	}
	
	/**
	 * 更新互动表单字段
	 * @param int|string $id 在hudong_field的ID
	 * @param array $field_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update_field( $id, $field_info )
	{
		//修改字段
		$field_info_new = $this->get_field_info($id);
		$field_name = $field_info_new['field_name'];
		$model_info = $this->get_info( $field_info_new['model_id'] );
		if( empty($field_name) )
		{
			return false;
		}else
		{
			if($field_info['dtype'] == 'multitext')
			{
				$add_col_sql = "column `" . $field_name . "` MEDIUMTEXT";
			}else
			{
				$add_col_sql = "column `" . $field_name . "` varchar(" . $field_info['maxlength'] . ") not null default ''";
			}
			$sql_alter = "ALTER TABLE {tablepre}" . $model_info['model_table_name'] . " MODIFY $add_col_sql";
			parent::execute_none_query($sql_alter);

			$this->set_table('{tablepre}model_field');
			
			unset($field_info['id']);
			unset($field_info['add_time']);
			unset($field_info['model_id']);
			return parent::update($field_info, "id=$id");
		}
	}
	
	/**
	 * 删除互动表单字段
	 * @param int|string $id 在hudong_field的ID
	 * @return boolean 成功返回true 失败返回false
	 */
	function delete_field($id)
	{
		$field_info_new = $this->get_field_info($id);
		$field_name = $field_info_new['field_name'];
		$model_info = $this->get_info( $field_info_new['model_id'] );
		
		if( empty( $field_name ) )
		{
			return false;
		}else
		{
			$sql_alter = "ALTER TABLE {tablepre}" . $model_info['model_table_name'] . " DROP COLUMN `" . $field_name . "`";
			//die($sql_alter);
			if( parent::execute_none_query($sql_alter) )
			{			
				$this->set_table('{tablepre}model_field');
				return parent::delete($id);
			}else
			{
				return false;
			}
		}
	}
	
	/**
	 * 返回互动表单的自字义列
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @return array 成功返回互动表单的自字义列 失败返回false
	 */
	function get_filed_list( $model_id, $canshu = array() )
	{
		if( empty($canshu['order']) )
		{
			$canshu['order'] = 'order_id';
		}
		$canshu['where'] = "model_id=$model_id";
		$this->set_table('{tablepre}model_field');
		
		return parent::select_ex($canshu);
	}
	
	/**
	 * 返回格式化后的互动表单
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是orderid
	 * @return array 返回一个数组 其中arr['itemname']为表单提示文字 inputtxt为生成的input字段HTML
	 */
	function get_format_filed_list( $canshu = array() )
	{
		if( empty($canshu['order']) )
		{
			$canshu['order'] = 'orderid';
		}
		
		$field_list = $this->get_filed_list($canshu);
		$field_format_list = array();
		//加上默认的title
		foreach($field_list as $key=> $value)
		{			
			if($value['dtype'] == 'text')
			{
				$str_t = "<input class='txtbox' name='" . $value['fieldname'] . "' id='" . $value['fieldname'] . "' type='text' maxlength='" . $value['maxlength'] . "' value='" . $value['vdefault'] . "' />";
				$arr_t = array('itemname'=> $value['itemname'], 'inputtxt'=>$str_t);
				$field_format_list[] = $arr_t;
			}
			if($value['dtype'] == 'multitext')
			{
				$str_t = "<textarea name='" . $value['fieldname'] . "' id='" . $value['fieldname'] . "'>" . $value['vdefault'] . "</textarea>";
				$arr_t = array('itemname'=>$value['itemname'], 'inputtxt'=>$str_t);
				$field_format_list[] = $arr_t;
			}
			if($value['dtype'] == 'select')
			{
				$str_t = "<select name='" . $value['fieldname'] . "' id='" . $value['fieldname'] . "'>";
				$v_a = explode(',', $value['vdefault']);
				foreach($v_a as $v_v)
				{
					$str_t .= "<option value='$v_v'>$v_v</option>";
				}
				$str_t .= "</select>";
				$arr_t = array('itemname'=>$value['itemname'], 'inputtxt'=>$str_t);
				$field_format_list[] = $arr_t;
			}
			if($value['dtype'] == 'checkbox')
			{
				$v_a = explode(',', $value['vdefault']);
				$str_t = '';
				foreach($v_a as $v_v)
				{
					$str_t .= " <input type='checkbox' name='" . $value['fieldname'] . "[]' id='" . $value['fieldname'] . "[]' value='$v_v' />$v_v";
				}
				$arr_t = array('itemname'=>$value['itemname'], 'inputtxt'=>$str_t);
				$field_format_list[] = $arr_t;
			}
			if($value['dtype'] == 'radio')
			{
				$v_a = explode(',', $value['vdefault']);
				$str_t = '';
				$set_default = false;//是不是设置了默认值
				foreach($v_a as $v_v)
				{
					if($set_default)
					{
						$str_t .= "<input type='radio' name='" . $value['fieldname'] . "' id='" . $value['fieldname'] . "' value='$v_v' />$v_v";
					}else
					{
						$str_t .= "<input checked type='radio' name='" . $value['fieldname'] . "' id='" . $value['fieldname'] . "' value='$v_v' />$v_v";
						$set_default = true;
					}
				}
				$arr_t = array('itemname'=>$value['itemname'], 'inputtxt'=>$str_t);
				$field_format_list[] = $arr_t;
			}
		}
		
		return $field_format_list;
	}
	
	/**
	 * 根据ID返回指定的互动表单的filename[表单名]
	 * @param int|string $id 在hudong_field的ID
	 * @return string 根据ID返回指定的互动表单的filename[表单名]
	 */
	function get_field_name( $id )
	{
		//获取ID为$id的字段名field_name
		parent::set_table('{tablepre}model_field');
		$canshu = array('col'=>'field_name', 'where'=>"id=$id");
		$info = parent::select_one_ex( $canshu );
		
		return $info['field_name'];
	}
	
	/**
	 * 生成提交的表单 <form></form>这类的
	 * 返回值为生成的form的HTML代码
	 * @return string 生成提交的表单信息
	 */
	function get_field_form()
	{
		$form_info = $this->get_format_filed_list();
		$form_txt = '';
		$form_txt .= "<form method=\"post\" action=\"hudong.php?action=addorder\">\n";
		foreach($form_info as $key=>$value)
		{
			$form_txt .= $value['itemname'] . ":" . $value['inputtxt'] . "\n";
		}
		$form_txt .= "</form>\n";
		
		return $form_txt;
	}
}

?>