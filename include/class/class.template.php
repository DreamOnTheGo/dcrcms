<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 模板类 模板的处理类
 * ===========================================================
 * 版权所有 (C) 2005-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0
 * @package class
 * @since 1.0.9
*/

class cls_template
{
    private $template_yuanshi_code; //模板最原始的内容.没有解析之前
    private $template_compile_code; //compile好的模板内容，只要写到模板缓存就行了
    private $template_compile_file_path; //编译好后的模板存放位置，一般是放在 模板缓存目录下/模板名.php
    private $template_path; //模板路径
    private $cls_template_file; //操作模板文件的file class
    private $cache_time; //模板缓存时间
    private $template_cache_path_info; //模板缓存文件路径信息  template_dir=>'目录' template_filename=>'文件名'
    
    /**
     * 构造函数
     * @param string $template_path 模板路径
     * @param int $cache_time 模板缓存时间
     * @return 如果模板路径为空则返回false
     */
    function __construct($template_path, $cache_time = 1728000)
    {
        global $tpl_dir;
        
        $this->cache_time = $cache_time;
        
        if( empty($template_path) )
        {
            return false;
        }
		
        
        /*如果模板目录下不存在这个文件，就到当前目录下找*/
        $template_path_main = WEB_Tpl . '/' . $tpl_dir . '/' . $template_path;
        if( file_exists($template_path_main) )
        {
            $this->template_path = $template_path_main;
        }else
        {
            $this->template_path = $template_path;
        }
        if( !file_exists($this->template_path) )
        {
            show_msg('模板' . $this->template_path .'不存在', 2);
        }
        //得出模板缓存目录
        //得出文件名（不包含后缀）
        $template_file_suffix = strrchr($template_path, '.');
        $template_file_no_suffix = str_replace($template_file_suffix, '', $template_path);        
        $this->template_cache_path_info = array('template_dir'=>WEB_CACHE . '/template/' . $tpl_dir, 'template_filename'=>$template_file_no_suffix . '.php');
        
        $this->template_cache_path = $this->template_cache_path_info['template_dir'] . '/' . $this->template_cache_path_info['template_filename'];
    }
    
    /**
     * 读取模板内容
     * @return 如果模板路径为空则返回false
     */
    function read()
    {
        if( empty($this->template_path) )
        {
            return false;
        }        
        
        //模板操作文件类
        require_once(WEB_CLASS . '/class.file.php');
        $this->cls_template_file = new cls_file($this->template_path);
        //读取文件        
        $this->template_yuanshi_code = $this->cls_template_file->read();
    }
    
    /**
     * 编译模板内容
     * @return
     */
    function compile()
    {
        
        $compile_code = $this->template_yuanshi_code;
		
        //单标记无法获取的，随便加个标记
        $compile_code = preg_replace('/{dcr([:.])([a-z]+)}/', '{dcr$1$2 temp}', $compile_code);
        $arr_block_tag = array();
        //if(preg_match_all( '/{dcr:(.+)([^\}]*)}([\w\W]*){\/dcr:\1}/U', $compile_code, $arr_block_tag) )
        
        /*编译开始*/
        //classlist处理在第一优先级
        $arr_classlist_tag = array();
        if( preg_match_all( '/{dcr:classlist ([\w\W]*)}/U', $compile_code, $arr_classlist_tag) )
        {
            for( $i = 0; $i < count( $arr_classlist_tag[1] ); $i ++ )
            {
                $attr_array = $this->get_attr_array($arr_classlist_tag[1][$i]);
                $classlist_class_name = WEB_CLASS . '/' . 'template/class.template.classlist.php';//块标签处理类
                if( file_exists($classlist_class_name) )
                {
                    /*引入块的类处理文件*/
                    require_once($classlist_class_name);
                    
                    $block_content = $arr_classlist_tag[0][$i]; //块内容
                    //标签信息
                    $tag_info = array(
                                      'block_content'=> $block_content,
                                      'attr_array'=> $attr_array,
                                      );
                                      
                    //编译标签内容
                    $class_name = 'cls_template_classlist';
                    $cls_template_classlist = new $class_name($tag_info);                            
                    $compile_code = str_replace($block_content, $cls_template_classlist-> get_content(), $compile_code);
                    
                }else
                {
                    //块处理不存在
                }
            }
            //处理模板中的{dcr.class_product_1.classname}这样的标记
            if(preg_match_all('/\{dcr\.class_([a-zA-Z]+)_([0-9]+)\.([_a-zA-Z1-9]+)}/U', $compile_code, $class_inner_tags))
            {
                if( $class_inner_tags )
                {
                    for( $i = 0; $i < count( $class_inner_tags[0] ); $i ++ )
                    {
                        $compile_code = str_replace( $class_inner_tags[0][$i], "<?php echo \$" . $class_inner_tags[1][$i] . "_class_" . $class_inner_tags[2][$i] . "_info['" . $class_inner_tags[3][$i] . "'] ?>", $compile_code);
                    }
                }
            }
            
            //处理{/dcr:classlist}
            $compile_code = str_replace( '{/dcr:classlist}', '<?php }} ?>', $compile_code);    
        }
        
        //foreach处理在第2优先级
        $arr_foreach_tag = array();
        if( preg_match_all( '/{dcr:(foreach|for) ([\w\W]*)}/U', $compile_code, $arr_foreach_tag) )
        {
            for( $i=0; $i<count($arr_foreach_tag[0]); $i++ )
            {
                $tag_name = $arr_foreach_tag[1][$i];
                $attr_array = $this->get_attr_array($arr_foreach_tag[2][$i]);
                $php = "<?php \r\n\t if(\$" . $attr_array['for'] . "){\r\n\tforeach(\$" . $attr_array['for'] . ' as $' . $attr_array['loop'] . '){ ?>';
                $compile_code = str_replace( $arr_foreach_tag[0][$i], $php, $compile_code );
            }
            $compile_code = str_replace( '{/dcr:foreach}', '<?php }} ?>', $compile_code);
            $compile_code = str_replace( '{/dcr:for}', '<?php }} ?>', $compile_code);
        }
        
        //编译块标签
        $arr_block_tag = array();//正则出来的块标签内容数组里面是多个数组 0=>标签全部内容 1=>标签名 2=>属性字符串 3=>标签内容(除{dcr:*} 及{/dcr:*})
        //if(preg_match_all( '/{dcr:(.+) ([\s\S]*)}([\s\S]*){\/dcr:\1}/U', $compile_code, $arr_block_tag) )
        //echo $compile_code;
        if(preg_match_all( '/{dcr:(.+) ([^\}]*)}([\w\W]*){\/dcr:\1}/U', $compile_code, $arr_block_tag) )
        {
			//p_r($arr_block_tag);
            //cls_app:: log(var_export( $arr_block_tag, true) );
            for( $i = 0; $i < count($arr_block_tag[0]); $i ++ )
            {
                $tag_name = $arr_block_tag[1][$i];
                $block_class_name = WEB_CLASS . '/' . 'template/class.template.' . $tag_name . '.php';//块标签处理类
                if( file_exists($block_class_name) )
                {
                    /*引入块的类处理文件*/
                    require_once($block_class_name);
                    
                    /*得出属性列表*/
                    $attr_array = $this->get_attr_array($arr_block_tag[2][$i]);
                    $block_content = $arr_block_tag[0][$i]; //块内容
                    //标签信息
                    $tag_info = array(
                                      'block_content'=> $block_content,
                                      'tag_name'=> $arr_block_tag[1][$i],
                                      'attr_array'=> $attr_array,
                                      'block_notag_content'=> $arr_block_tag[3][$i]
                                      );
                                      
                    //编译标签内容
                    $class_name = 'cls_template_' . $tag_name;
                    $cls_template_block = new $class_name($tag_info);                            
                    $compile_code = str_replace($block_content, $cls_template_block-> get_content(), $compile_code);
                } else
                {
                    //本标签处理类不存在
                }
            }
        }
        //编译单标签
        $arr_single_tag = array();//正则出来的块标签内容数组里面是多个数组 0=>标签全部内容 1=>标签名 2=>属性字符串)
        //if(preg_match_all( '/\{dcr\.(.*) ([^\r]*)\}/U', $compile_code, $arr_single_tag) )
        if(preg_match_all( '/{dcr\.([^\}]*) ([^\}]*)}/U', $compile_code, $arr_single_tag) )
        {
            for( $i = 0; $i < count($arr_single_tag[0]); $i++)
            {
                //这里要剔除这样的:{dcr.cfg.web_name}
                if(preg_match('/{dcr\.\S*\.\S*}/U', $arr_single_tag[0][$i]))
                {
                    continue;
                }
                $tag_name = $arr_single_tag[1][$i];
                $single_class_name = WEB_CLASS . '/' . 'template/class.template.' . $tag_name . '.php';//块标签处理类
                if( file_exists($single_class_name) )
                {
                    /*引入块的类处理文件*/
                    require_once($single_class_name);
                    
                    /*得出属性列表*/
                    $attr_array = $this->get_attr_array($arr_single_tag[2][$i]);
                    $class_name = 'cls_template_' . $tag_name;
                    $single_content = $arr_single_tag[0][$i]; //块内容
                    //标签信息
                    $tag_info = array(
                                      'block_content'=> $single_content,
                                      'tag_name'=> $arr_single_tag[1][$i],
                                      'attr_array'=> $attr_array
                                      );
                                      
                    //编译标签内容
                    $cls_template_single = new $class_name($tag_info);                            
                    $compile_code = str_replace($single_content, $cls_template_single-> get_content(), $compile_code);
                } else
                {
                    //本标签处理类不存在
                }
            }
        }
        //编译inner_tag
        $compile_code = $this->compile_inner_tag($compile_code);
		
        $this->template_compile_code = $compile_code;
        
    }
    
    
    /**
     * 把模板内容写到缓存中
     * @return
     */
    function write()
    {
        global $tpl_dir;
        
        //如果没有这个目录则要建立
        $t_template_dir = WEB_CACHE . '/template';
        if(!file_exists($t_template_dir))
        {
            @mkdir($t_template_dir); 
        }
        $t_template_sub_dir = $t_template_dir . '/' . $tpl_dir;
        if(!file_exists($t_template_sub_dir))
        {
            @mkdir($t_template_sub_dir); 
        }
        
        require_once(WEB_CLASS . '/class.file.php');
        $template_cache_path = $this->template_cache_path_info['template_dir'] . '/' .$this->template_cache_path_info['template_filename'];
        $this->cls_template_complile_file = new cls_file($template_cache_path);
        $this->cls_template_complile_file->set_text($this->template_compile_code);
        $this->cls_template_complile_file->write();
    }    
    
    /**
     * 显示编译好后的模板
     * @return
     */
    function display()
    {
        $out = $this->fetch();
        echo $out;    
        
    }    
    
    /**
     * 获取编译好的模板HTML源码
     * @return string html源码
     */
    function fetch()
    {
        //从缓存系统中读
        require_once(WEB_CLASS . '/class.cache.php');
        $cls_template_cache = new cls_cache($this->template_cache_path_info['template_filename'], $this->cache_time, $this->template_cache_path_info['template_dir']);
        
        if($cls_template_cache->check())
        {
            //缓存存在
        }else
        {
            //缓存不存在
            $this->read();
            $this->compile();
            $this->write();
        }
        
        //加载缓存显示内容
        ob_start();
        include($this->template_cache_path);
        //include($this->compileDirectory . $template . '.php');
        $out = ob_get_clean();
        return $out;
    }
    
    /*以下为大多子类要用到的function 本类也用*/
    /**
     * 编译单标签inner_tag
     * @param string $block_content 模板内容
     * @param string $type 这个字段是在哪个列表内的 主要是{$title}这类的标记 为product时表示产品列表 为news为表示新闻列表 为空时是默认date_info
     * @return 返回处理好的模板内容
     */
    function compile_inner_tag($block_content = '', $type = '')
    {
        //如果block_content为空，则用类的template_compile_code
        if(empty($block_content))
        {
            $block_content = $this->template_compile_code;
        }
        if( empty($block_content) )
        {
            return;
        }
        $var_name = ''; //每个类型的信息info不同
        if( 'product' == $type )
        {
            $var_name = 'dcr_list_pro_data_info';
        }else if( 'news' == $type )
        {
            $var_name = 'dcr_list_news_data_info';           
        }else
        {
            $var_name = 'data_info';           
        }
		
        $inner_tag = array();
        if(preg_match_all('/\{\$([_a-zA-Z1-9]+)( (func|function)=[\'\"]([\w\W]*)[\'\"])*}/U', $block_content, $inner_tag))
        {
            //p_r($inner_tag);
            for($i = 0; $i<count($inner_tag[0]); $i++)
            {
                //如果有function
                if( ! empty( $inner_tag[4][$i] )  )
                {
                    $echo_txt = str_replace( '~me', "\${$var_name}['" . $inner_tag[1][$i] . "']", $inner_tag[4][$i] );
                }else
                {
                    $echo_txt = "\${$var_name}['" . $inner_tag[1][$i] . "']";
                }
                $block_content = str_replace($inner_tag[0][$i], "<?php echo {$echo_txt}; ?>", $block_content);
            }
        }

       
        //处理标签块里的标记子标记
        $child_tag = array(); //0=>标记内容 1=>标记类型 2=>标记名
        if(preg_match_all('/\{dcr\.([_a-zA-Z1-9]+)\.([_a-zA-Z1-9]+)( (func|function)=[\'\"]([\w\W]*)[\'\"])*}/U', $block_content, $child_tag))
        {
            //p_r($child_tag);
            //exit;
            for($i = 0; $i<count($child_tag[0]); $i++)
            {
                $func_txt = $child_tag[5][$i];
                $field_name = $child_tag[1][$i];
                if('field' == $field_name)
                {
                    //如果有function
					if( 'product' == $type )
					{
						$var_name = 'dcr_list_pro_data_info';
					}else if( 'news' == $type )
					{
						$var_name = 'dcr_list_news_data_info';           
					}else
					{
						$var_name = 'data_info';           
					}
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\${$var_name}['" . $child_tag[2][$i] . "']", $func_txt );
                    }else
                    {
                        $echo_txt = "\${$var_name}['" . $child_tag[2][$i] . "']";
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php echo {$echo_txt}; ?>", $block_content);
                }
                if('product' == $field_name || 'pro' == $field_name)
                {
                    //如果有function
                    $var_name = 'dcr_product_data_info';
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\${$var_name}['" . $child_tag[2][$i] . "']", $func_txt );
                    }else
                    {
                        $echo_txt = "\${$var_name}['" . $child_tag[2][$i] . "']";
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php echo {$echo_txt}; ?>", $block_content);
                }
                if('news' == $field_name)
                {
                    //如果有function
                    $var_name = 'dcr_news_data_info';
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\${$var_name}['" . $child_tag[2][$i] . "']", $func_txt );
                    }else
                    {
                        $echo_txt = "\${$var_name}['" . $child_tag[2][$i] . "']";
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php echo {$echo_txt}; ?>", $block_content);                   
                }
                if('single' == $field_name || 'info' == $field_name)
                {
                    //如果有function
                    $var_name = 'dcr_single_data_info';
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\${$var_name}['" . $child_tag[2][$i] . "']", $func_txt );
                    }else
                    {
                        $echo_txt = "\${$var_name}['" . $child_tag[2][$i] . "']";
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php echo {$echo_txt}; ?>", $block_content);
                }
                if('var' == $field_name)
                {
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\$" . $child_tag[2][$i], $func_txt );
                    }else
                    {
                        $echo_txt = "\$" . $child_tag[2][$i];
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php global \$" . $child_tag[2][$i] . "; echo {$echo_txt}; ?>", $block_content);
                }
                if('cfg' == $field_name)

                {
                    if( ! empty( $func_txt )  )
                    {
                        $echo_txt = str_replace( '~me', "\$" . $child_tag[2][$i], $func_txt );
                    }else
                    {
                        $echo_txt = "\$" . $child_tag[2][$i] . "";
                    }
                    $block_content = str_replace($child_tag[0][$i], "<?php global \$" . $child_tag[2][$i] . "; echo {$echo_txt}; ?>", $block_content);
                }
            }
        }
		
        return $block_content;   
    }    
    /**
     * 获取一个标签块的第一行 get_block_first_line 如{dcr:foreach for='a'}test{/dcr:foreach} 则返回{dcr:foreach for='a'}
     * @param string $tag_info 标签内容
     * @return string
     */    
    function get_block_first_line($tag_info)
    {
        $block_first_line = '';
        $zhenze = '{dcr:' . $tag_info['tag_name'] . '([^\}]*)}';
        //echo $zhenze;
        if( preg_match("/{$zhenze}/", $tag_info['block_content'], $first_line_result) )
        {
            $block_first_line = $first_line_result[0];
        }
        
        return $block_first_line;
    }
    
    /**
     * 获取一个标签的属性列表
     * @param string $str 内容
     * @return string
     */    
    function get_attr_array($str)
    {
        /*得出属性列表*/
        $attr_preg_array = array(); //0=>属性全内容如 name='张三' 1=>属性名(name) 2=>属性值(张三)
        $attr_array = array();//属性数组 '属性名'=>属性值
        if( preg_match_all( '/(.*)=([\'\"]+)(.*)\2/U', $str, $attr_preg_array) )
        {                        
            for( $j = 0; $j < count($attr_preg_array[0]); $j++ )
            {
                $attr_array[ trim($attr_preg_array[1][$j]) ] = $this->get_dynamic_var( trim( $attr_preg_array[3][$j] ) );
            }
        }
        return $attr_array;
    }
    
    
     /**
     * 获取动态变量..操作[dcr.var.pro] 变为 $pro
	 * 如{dcr:list where="classid='[dcr.var.classid]' and id=[dcr.var.id]"}
     * @param string $str 内容
     * @return string
     */   
    function get_dynamic_var($str)
    {
        //return $str;
        $dynamic_var_arr = array();
        $value = $str;
        if(preg_match_all('/\[dcr\.var\.([_a-zA-Z1-9]+)]/U', $str, $dynamic_var_arr))
        {
            //p_r( $dynamic_var_arr );
            //echo $value . '<br>';
            for( $i = 0; $i < count($dynamic_var_arr[0]); $i++ )
            {
                $var = $dynamic_var_arr[1][$i];
                global $$var;
                $value = str_replace( $dynamic_var_arr[0][$i], $$var, $value );
            }
        }
        return $value;
    }   

}
?>