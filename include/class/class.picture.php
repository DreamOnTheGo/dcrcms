<?php

defined('IN_DCR') or exit('No permission.');

/**
 * 图片处理类
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0.3
 * @package class
 * @since 1.0.8
*/

class cls_picture
{
   
    var $pic_path;//图片路径   
    var $pic_type; //图片类型
    var $pic_mime; //图片MIME
    var $pic_width;//图片宽
    var $pic_height;//图片高
    var $pic_ext;//图片扩展名
    var $create_resource;//图片创建function
    var $pic_resource;//图片resource
   
    /**
     * cls_picture的构造函数
     * @param string $pic_path 要处理的图片路径
     * @return cls_picture 返回一个cls_picture实例
     */
    function __construct($pic_path)
    {
        $this->pic_path = $pic_path;
        $this->get_info();   
    }
       
    /**
     * get_info,获取图片信息
     * @return true 返回ture
     */
    function get_info()
    {
        if( !file_exists($this->pic_path) )
        {           
            return false;
        }
        /*
        处理原图片的信息,先检测图片是否存在,不存在则给出相应的信息
        */
        @$pic_info = getimagesize($this->pic_path);
        if( !$pic_info )
        {
            return false;
        }       
       
        //得到原图片的信息类型、宽度、高度
        $this->pic_mime = $pic_info['mime'];
        $this->pic_width = $pic_info[0];
        $this->pic_height = $pic_info[1];
       
        //创建图片
        switch($pic_info[2])
        {
           case 1:
            $this->create_resource = imagecreatefromgif($this->pic_path);
            $this->pic_type = "imagegif";
            $this->pic_ext = "gif";
            break;
           case 2:
            $this->create_resource = imagecreatefromjpeg($this->pic_path);
            $this->pic_type = "imagejpeg";
            $this->pic_ext = "jpeg";
            break;
           case 3:
            $this->create_resource = imagecreatefrompng($this->pic_path);
            $this->pic_type = "imagepng";
            $this->pic_ext = "png";
            imagesavealpha($this->create_resource, true);
            break;
        }
    }
   
    /**
     * get_gd_version,获取GD版本号 这里是修改自ecshop的获取方法
     * @return int 返回值可能为0,1,2
     */
    function get_gd_version()
    {
        static $gd_version = -1;

        if ($gd_version >= 0)
        {
            return $gd_version;
        }

        if (!extension_loaded('gd'))
        {
            $gd_version = 0;
        }
        else
        {
            // 尝试使用gd_info函数
            if (PHP_VERSION >= '4.3')
            {
                if (function_exists('gd_info'))
                {
                    $ver_info = gd_info();
                    preg_match('/\d/', $ver_info['GD Version'], $match);
                    $gd_version = $match[0];
                }
                else
                {
                    if (function_exists('imagecreatetruecolor'))
                    {
                        $gd_version = 2;
                    }
                    elseif (function_exists('imagecreate'))
                    {
                        $gd_version = 1;
                    }
                }
            }
            else
            {
                if (preg_match('/phpinfo/', ini_get('disable_functions')))
                {
                    /* 如果phpinfo被禁用，无法确定gd版本 */
                    $gd_version = 1;
                }
                else
                {
                  // 使用phpinfo函数
                   ob_start();
                   phpinfo(8);
                   $info = ob_get_contents();
                   ob_end_clean();
                   $info = stristr($info, 'gd version');
                   preg_match('/\d/', $info, $match);
                   $gd_version = $match[0];
                }
             }
        }

        return $gd_version;
     }
   
    /**
     * 函数zoom,对图片进行缩放
     * @param array $col 缩放参数 (type=1为按比例缩放 bili为缩放比例) (type=2时为按指定大小缩放 width为宽 height为高
     * @return true
     */
    function zoom($zoom_info = array())
    {
        if($zoom_info['type'] == 2)
        {
            $zoom_width = $zoom_info['width'];
            $zoom_height = $zoom_info['height'];
        }else if($zoom_info['type'] == 1)
        {
            $zoom_width = $this->pic_width * $zoom_info['bili'];
            $zoom_height = $this->pic_height * $zoom_info['bili'];
        }
   
        $this->pic_resource = imagecreatetruecolor($zoom_width, $zoom_height);
       
        //保持 透明值
        imagealphablending( $this->pic_resource, false );
        imagesavealpha($this->pic_resource,true);
       
        $white = imagecolorallocate($this->pic_resource, 255, 255, 255);
        imagefilledrectangle( $this->pic_resource, 0, 0, $zoom_width, $zoom_height, $white );
        //这里 如果gb版本在2以上用imagecopyresampled可以获取更高的像素 其它只能用imagecopyresized
        $func_resize = 'imagecopyresized';
        if($this->get_gd_version() == 2)
        {
            $func_resize = 'imagecopyresampled';
        }
        $func_resize( $this->pic_resource, $this->create_resource, 0, 0, 0, 0, $zoom_width, $zoom_height, $this->pic_width, $this->pic_height );
    }

    /**
     * 函数mark_text,文字水印
     * @param string $watermark_txt 水印文字
     * @param string|int $weizhi 水印位置 1为左上 2为右上 3为左下 4为右下 5为中
     * @param string|int $txt_color 文字颜色 以,分隔每个RGB颜色 如:123,123,123 FF,FF,FF
     * @param string|int $font_size 文字大小
     * @param string $font_path 文字字体
     * @return true
     */
    function watermark_text( $watermark_txt, $font_path, $weizhi = 1,$txt_color = '00,00,00',$font_size = 12 )
    {
        global $web_code;
       
        if( !file_exists($font_path) ) die('字体文件不存在,文字水印失败');
       
        $watermark_txt_space = 5;//文字跟边上的距离
        $this->pic_resource = imagecreatetruecolor($this->pic_width, $this->pic_height);
        if('utf-8' != $web_code)
        {
            $watermark_txt = iconv($web_code, 'utf-8', $watermark_txt);
        }
        $txt_info = imagettfbbox($font_size, 0, $font_path, $watermark_txt);       
        $txt_len = strlen($watermark_txt);
        $txt_width = $txt_info[2] - $txt_info[6];
        $txt_height = $txt_info[3] - $txt_info[7];
               
        //$x $y 文字位置
        switch($weizhi)
        {
            case 1:
                $x = $watermark_txt_space;
                $y = $txt_height;
                break;
            case 2:
                $x = $this->pic_width - $txt_width - $watermark_txt_space;
                $y = $txt_height;
                break;
            case 3:
                $x = $watermark_txt_space;
                $y = $this->pic_height - $watermark_txt_space;
                break;
            case 4:
                $x = $this->pic_width - $txt_width - $watermark_txt_space;
                $y = $this->pic_height - $watermark_txt_space;
                break;
            default:
                $x = ($this->pic_width - $txt_width) / 2;
                $y = ($this->pic_height - $txt_height) / 2;
                break;
        }
        imagesettile( $this->pic_resource, $this->create_resource );
        imagefilledrectangle( $this->pic_resource, 0, 0, $this->pic_width, $this->pic_height, IMG_COLOR_TILED );
        $arr_color = explode(',', $txt_color);
        $t_txt = imagecolorallocate( $this->pic_resource, $arr_color[0], $arr_color[1], $arr_color[2] );
        imagettftext( $this->pic_resource, $font_size, 0, $x, $y, $t_txt, $font_path, $watermark_txt );
    }

    /**
     * 函数watermark_picture,图片水印
     * @param string $watermark_path 水印图片路径
     * @param string|int $weizhi 水印位置 1为左上 2为右上 3为左下 4为右下 5为中
     * @return true
     */
    function watermark_picture( $watermark_path, $weizhi = 1 ){       
        /*
        获取水印图片的信息
        */
       
        if( !file_exists($watermark_path) ) die('水印图片不存在,图片水印失败');
       
        $watermark_pic_space = 3;//水印图片跟边上的距离
        @$watermark_info = getimagesize($watermark_path);
        if(!$watermark_info)
        {
            return false;
        }
        $watermark_width = $watermark_info[0];
        $watermark_height = $watermark_info[1];
        //创建水印图片
        switch($watermark_info[2])
        {
           case 1:
            $watermark_creat = imagecreatefromgif($watermark_path);
            $watermark_type = "gif";
            break;
           case 2:
            $watermark_creat = imagecreatefromjpeg($watermark_path);
            $watermark_type = "jpg";
            break;
           case 3:
            $watermark_creat = imagecreatefrompng($watermark_path);
            $watermark_type = "png";
            break;
        }
       
        $this->new_pic_resource = $this->create_resource;
        if($watermark_width > $this->pic_width)
        {
           $create_width = $watermark_width - 0;
        }else
        {
           $create_width = $this->pic_width;
        }
        if($watermark_height>$this->pic_height)
        {
           $create_height = $watermark_height - 0;
        }else{
           $create_height = $this->pic_height;
        }
       
        $new_pic_resource = imagecreatetruecolor($create_width, $create_height);
        $white = imagecolorallocate( $new_pic_resource, 255, 255, 255 );

        imagecopy( $new_pic_resource, $this->create_resource, 0, 0, 0, 0,$this->pic_width,$this->pic_height );
       
        //$x $y 水印图片位置
        switch($weizhi)
        {
            case 1:
                $x = $watermark_pic_space;
                $y = $watermark_pic_space;
                break;
            case 2:
                $x = $this->pic_width - $watermark_width - $watermark_pic_space;
                $y = $watermark_pic_space;
                break;
            case 3:
                $x = $watermark_pic_space;
                $y = $this->pic_height - $watermark_height - $watermark_pic_space;
                break;
            case 4:
                $x = $this->pic_width - $watermark_width - $watermark_pic_space;
                $y = $this->pic_height - $watermark_height - $watermark_pic_space;
                break;
            default:
                $x = ($this->pic_width - $watermark_width) / 2;
                $y = ($this->pic_height - $watermark_height) / 2;
                break;
        }
        imagecopy( $new_pic_resource, $watermark_creat, $x, $y, 0, 0,$watermark_width,$watermark_height );
        $this->pic_resource = $new_pic_resource;
    }
       
    /**
     * 函数send_header,发送头
     * @return true
     */
    private function send_header()
    {
        switch ($this->pic_ext)
        {
            case 'gif':
                header('content-type:image/gif');
                break;
            case 'jpeg':
                header('content-type:image/jpeg');
                break;
            case 'jpg':
                header('content-type:image/jpg');
                break;
            case 'png':
                header('content-type:image/png');
                break;
            default:
                exit('Can not set header.');
                break;
        }
        return true;
    }

    /**
     * 函数create,生成目标图片
     * @param string $mudi_pic_path 目标图片路径 不为空的的话就输出到浏览器 如果有的话就按这个路径存为图片
     * @return true
     */
    function create( $mudi_pic_path = '' )
    {
        $out_func = $this->pic_type;
       
        if($this->pic_resource)
        {
            if( !empty($mudi_pic_path) )
            {
                $out_func( $this->pic_resource, $mudi_pic_path );
            } else {
                $this->send_header();
                $out_func($this->pic_resource);
            }
            return true;
        } else {
            exit('不能创建图片,原因可能是没有设置图片来源.');
        }
    }
   
    /**
     * 函数__destruct,析构函数
     * @return true
     */
    function __destruct()
    {
        /*释放图片*/
        @imagedestroy($this->TRUE_COLOR);
        @imagedestroy($this->PICTURE_CREATE);
    }
}

?>