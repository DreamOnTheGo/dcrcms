<?php
session_start();
set_time_limit(0);
include "../include/common.inc.php";
include "adminyz.php";
//本页为操作新闻的页面
if('query' == $action)
{
    $sql = trim(stripslashes($str_sql));
	if( empty($sql) )die('sql不能为空');
    if(preg_match("/drop(.*)table/i", $sql) || preg_match("/drop(.*)database/i", $sql))
    {
        die("<span style=color:red>权限不够：删除'数据表'、'数据库'的语句不允许在这里执行。</span>");
    }
    //如果是查询语句
    if(preg_match("/^select /i", $sql))
    {
		$db->Execute($sql);
		$result = $db->GetArray();
		if($result)
		{
			echo '发现共'.$db->GetRsNum().'记录<br><hr color=green>';
			$j = 0;
			foreach($result as $t_result)
			{
				$j++;
				if($j > 100)
				{
					break;
				}
				foreach($t_result as $key=>$value)
				{
					echo "<font color='red'>{$key}：</font>{$value}<br/>\r\n";
				}
				echo '<hr>';
			}
			die('执行完毕');
		}else
		{
			die('<span style=color:red>抱歉 没有记录</span>');
		}
    }
    
	//普通的SQL语句
    $sql = str_replace("\r","",$sql);
    $arr_sql = preg_split("/;[ \t]{0,}\n/",$sql);
	$nerrCode = "";
	$chenggong_num = 0;
	$shibai_num = 0;
	foreach($arr_sql as $sql)
    {
		$sql = trim($sql);
		if($sql=="")
		{
			continue;
		}
		if($db->ExecuteNoneQuery($sql))
        {
            $chenggong_num++;
			echo '<span class="color:green">执行'.$sql.'成功<br></span>';
		}
		else
		{
			$shibai_num++;
			echo '<span class="color:red">执行'.$sql.'失败.原因是'.$db->GetDbError().'<br></span>';
		}
	}
	echo "成功{$chenggong_num}个SQL语句！<br>失败{$shibai_num}个SQL语句！";
    exit();
}else{
	ShowMsg('非法参数',2,array(),'提示信息',false);
}
?>