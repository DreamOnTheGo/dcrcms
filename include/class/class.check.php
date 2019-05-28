<?php

defined('IN_DCR') or exit('No permission.');

/**
 * 程序信息的类，比如获取一个编辑器 获取程序信息等全局工厂模式的类.
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0.0
 * @date:   20130808
 * @package class
 * @since 1.0.8
*/

class cls_check
{   
    /**
     * 检测是不是空字符串
     * @param string|array $fields 要检测的变量名，比如你要检测$a,$b是不是为空，可以看fields为array( $a, $b )
     * @return true
     */
    public static function check_empty( $fields )
    {
        $is_ok = false;
        $fields_list = is_array( $fields ) ? $fields : array( $fields );
        foreach( $fields_list as $var )
        {
            if( empty( $var ) )
            {
                $is_empty = true;
            }
               
        }
       
        return $is_ok;
    }   
   
    /**
     * 检测字符串是不是在指定长度内
     * @param string|array $fields 要检测的变量名，比如你要检测$a,$b是不是为空，可以看fields为array( $a, $b )
     * @param int $min_len 最小长度
     * @param int $max_len 最大长度
     * @return true
     */
    public static function check_length( $fields, $min_len, $max_len )
    {
        $is_ok = false;       
        $fields_list = is_array( $fields ) ? $fields : array( $fields );

        foreach( $fields_list as $var )
        {
            if( strlen( $var ) >= $max_len || strlen( $var ) <= $min_len )
            {
                $is_ok = true;
            }
               
        }       
       
        return $is_ok;
    }
   
}

?>