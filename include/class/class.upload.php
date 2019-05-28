<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 上传类
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

class cls_upload
{
	private $allow_files; //允许的文件类型
	private $max_file_size; //文件最大上传大小
	private $input_name; //上传框的name
	
	/**
	 * 构造函数
	 * @param string $input_name 上传文件框的名字
	 */
	function __construct( $input_name )
	{
		//初始化数据
		$this->input_name = $input_name;
		$this->allow_files = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
		$this->max_file_size = 5000000;
	}
	
    /**
     * 设置允许上传的文件类型
     * @param array 允许的文件类型
     * @return true
     */   
    function set_allow_files( $allow_files )
    {
        $this->allow_files = $allow_files;
    }
   
    /**
     * 设置允许上传的文件大小
     * @param int 允许的文件最大值
     * @return true
     */   
    function set_max_file_size( $max_file_size )
    {
        $this->max_file_size = $max_file_size;
    }
	
	/**
	 * 上传文件
	 * @param string $dir_name 文件上传后放的目录名 为空时当前目录
	 * @param string $fileName 文件名
	 * @param array $sl 缩略图参数 array('width'=>100,'height'=>100,'newpic'=>1,'sl_name'=''); newpic=1时生成新的缩略图 0为覆盖原图 sl_name表示缩略图名 如果为空则用默认的
	 * @param array $dir_fei_lei 目录分类 type表示类型 caishu为扩展参数 默认为按日期 (含)1.0.6版本以后有效 现在有效且默认的是array('type'=>'date','caishu'=>'Y_m_d') 为了这个参数 几乎改写了上传过程 大家请以后台上传文件为参考 ^_^ 从这些个变量得出一个结论 最好不要对原变量来改 比如fileName让他从头到尾都是从外传来的值 而用新的变量来记录处理的变量
	 * @return array|boolean 上传成功filename为原图 sl_filename为缩略图 上传错误则error=1 error_msg表示错误信息 没有文件上传是为false
	 */
	function upload( $dir_name = '', $file_name = '', $sl = array(), $dir_fei_lei = array ('type'=> 'date', 'caishu'=> 'Y_m_d' ) )
	{
		global $web_watermark_type, $web_watermark_txt, $web_watermark_weizhi;
		
		$input_name = $this-> input_name;
		$return_value = array();//返回的结果
		if( is_uploaded_file( $_FILES[$input_name]['tmp_name'] ) )
		{
			$file = $_FILES[$input_name];
			if( $this->max_file_size < $file["size"] )
			{
				show_msg( '您上传的文件大小[' . $file["size"] . ']超过文件上传大小限制', 2 );
				return array( 'error'=>1, 'error_msg'=>'您上传的文件超过文件上传大小限制' );
			}
			if( !in_array($file["type"], $this->allow_files) )
			{
				show_msg( '你上传的文件文件类型[' . $file["type"] . ']不在允许上传的类型之内', 2 );
				return array('error'=>1,'error_msg'=>'你上传的文件不在允许上传的类型之内');
			}
			if( is_array($dir_fei_lei) && !empty($dir_fei_lei['type']) && !empty($dir_fei_lei['caishu']) )
			{
				if('date' == $dir_fei_lei['type'])
				{
					$dir_can_shu = date($dir_fei_lei['caishu']);//因为参数产生的多的字符串
				}
			}
			
			
			$real_file_name = '';//真实的FileName 这里是为了区别以前的路径名 file_name是全路径 real_file_name是不含目录分类参数带来的的路径
			$real_sl_file_name = '';//真实的缩略图FileName 意思同上
			$real_dir_name = '';//真实的目录名 意思同上 这三个变量主要是为了区别加了dir_fei_lei这个参数产生的字符串 ^_^
			
			$old_name = $file['tmp_name'];
			$pinfo = pathinfo($file["name"]);
			$ftype = $pinfo['extension'];
			if( strlen($file_name) == 0 )
			{
				$real_file_name = date(ymdhms) . rand(1000, 9999) . "." . $ftype;
			}else
			{
				$t_a = explode('.', $file_name);
				if( count($t_a) > 1 )
				{
					$real_file_name = $file_name;
				}else{
					$real_file_name = $file_name . "." . $ftype;
				}
			}
			
			if( ! empty($dir_can_shu) )
			{
				$real_dir_name = $dir_name.'/'.$dir_can_shu;
			}else
			{
				$real_dir_name = $dir_name;
			}
			if(!file_exists($real_dir_name))
			{
				@mkdir($real_dir_name); 
			}
			$file_name = $real_dir_name . '/' . $real_file_name;
			
			if( ! move_uploaded_file($old_name, $file_name) )
			{
				return false;
			}
			else
			{
				require_once(WEB_CLASS . "/class.picture.php");
				//打水印
				if('2' == $web_watermark_type)
				{
					//文字
					$cls_pic = new cls_picture($file_name);
					$cls_pic->watermark_text($web_watermark_txt, WEB_INCLUDE . '/watermark/ziti.ttf', $web_watermark_weizhi);
					$cls_pic->create($file_name);
					unset($cls_pic);
					
				}else if( '1' == $web_watermark_type )
				{
					//文字
					$cls_pic = new cls_picture($file_name);
					$cls_pic->watermark_picture(WEB_INCLUDE . '/watermark/watermark.gif', $web_watermark_weizhi);
					$cls_pic->create($file_name);
					unset($cls_pic);
				}
				
				if( is_array($sl) && count($sl) > 0 )
				{
					if( $sl['newpic'] == 1 )
					{
						$real_sl_file_name = self:: get_sl($real_file_name);
					}else
					{
						$real_sl_file_name = $real_file_name;
					}
					//echo $real_dir_name;
					$sl_filename = $real_dir_name . '/' . $real_sl_file_name;
					//echo $sl_filename;
					$cls_pic = new cls_picture($file_name);
					$sl['type'] = ( empty($sl['type']) )?  2: $sl['type'];
					$cls_pic->zoom(array('type'=>$sl['type'], 'width'=>$sl['width'], 'height'=>$sl['height']));//改变尺寸					
					$cls_pic->create($sl_filename);
					unset($cls_pic);
				}
				if( ! empty($dir_can_shu) )
				{
					$real_file_name = $dir_can_shu . '/' . $real_file_name;
					$real_sl_file_name = $dir_can_shu.'/' . $real_sl_file_name;
				}
				if( is_array( $sl ) && count( $sl )>0 )
				{
					return array('sl_filename'=> $real_sl_file_name, 'filename'=> $real_file_name);
				}else
				{
					return array('filename'=> $real_file_name);
				}
			}
		}else
		{
			//没有上传文件
			return false;
		}
	}
	/**
	 * 获取缩略图名 1.0.6后大改写 原来是全路径 现在只是非全路径了 注意！！！
	 * @param string $file_name 图片文件名
	 * @return string 缩略图名
	 */
	static function get_sl( $file_name )
	{
		$b_name = explode('.', $file_name);
		return $b_name[0] . '_sl.' . $b_name[1];
	}
}

?>