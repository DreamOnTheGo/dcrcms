<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS . "/class.config.php";
include "adminyz.php";

$config = new cls_config();

$msg = array();//信息

//本页为操作新闻的页面
if( $action == 'cfg_watermark' )
{
    //上传水印图片
    include_once( WEB_CLASS . "/class.upload.php" );
    $cls_uploads = new cls_upload( 'web_watermark_logo_new' );
    $cls_uploads->upload( WEB_INCLUDE . "/watermark/", 'watermark.gif', array(), array() );
    unset($cls_uploads);
   
    $web_watermark_type_new == 0 && $web_watermark_type_new=0.0;
    $config_arr = array(
                     'web_watermark_type'=> $web_watermark_type_new,
                     'web_watermark_txt'=> $web_watermark_txt_new,
                     'web_watermark_weizhi'=> $web_watermark_weizhi_new
                     );
                     
    $rs = $config->modify($config_arr);
    if($rs == 'r1')
    {
        $msg[] = '更新配置失败：配置项目请填写完整！';
        show_msg($msg,2);   
    }
    if($rs == 'r2')
    {
        $msg[] = '更新配置成功';
        show_msg($msg);   
    }
    if($rs == 'r3')
    {
        $msg[] = '更新配置失败：未知错误！';
        show_msg($msg,2);   
    }
   
}
?>