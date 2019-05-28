<?php
/**
* 分页类
* URL有多个参数也能分页，还能自定义分页样式
* php>=5.0
* @author 我不是稻草人 www.dcrcms.com
* @version 0.1.2
* @copyright 2006-2010
* @package class
*/
class PageClass{
	private $url;
	private $cpage;
	private $totalPage;
	private $tpl;
	private $web_url_module;
	/**
	 * PageClass的构造函数
	 * 模板说明：{index}表示首页 {pagelist}链接列表 {option}下拉列表框 {next}下一页 {pre}上一页 {cur}当前页 {index=首页}表示首页的链接文字为首页，即=号后为链接文字，不过这对{pagelist}{option}无效
	 * @param string $cpage 当前页
	 * @param string $tatolPage 总页数
	 * @param string $tpl 模板.
	 * @param string $url 要分页的url 默认为当前页
	 * @return PageClass
	 */
	function __construct($cpage,$totalPage,$tpl='',$url=''){
	  $this->cpage=$cpage;
	  $this->totalPage=$totalPage;
	  if(strlen($tpl)==0){
		  $this->tpl="{cur=当前页} {index=首页} {pre=上一页} {next=下一页} {end=最后页} {option}"; //中文分页
	  }else{
		  $this->tpl=$tpl;
	  }
	  if(strlen($url)==0){
		  $this->url=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	  }else{
		  $this->url=$url;
	  }
	  //这里用一个外部变量..来说明是不是用伪静态.
	  global $web_url_module;
	  $this->web_url_module=$web_url_module;
	}
	/**
	 * 函数showPage,返回生成的分页HTML
	 * @return string
	 */
	function showPage(){
	  //显示分页
	  $urlOption=array();//url的后缀如：?page=1&typeid=1
	  $parse_url=parse_url($this->url);
	  $urlMain='http://'.$parse_url['path'];
	  if($parse_url['query']){
	   //url有参数
	   $urlArr=split('&',$parse_url['query']);
	   if(is_array($urlArr)){
		   foreach($urlArr as $key=>$value){
			$c=split('=',$value);
			if($c[0]==page){
			}else{
			 array_push($urlOption,$c[0].'='.$c[1]);
			}
		   }
	   }
	  }else{
	   //url没有参数
	   //if($this->cpage<$this->totalPage){
	   // array_push($urlOption,"page=2");
	   //}
	  }
	  if(is_array($urlOption)){
		$urlOptionStr_t=implode('&',$urlOption);
	  }
	  if(strlen($urlOptionStr_t)>0){
		  $urlOptionStr.='&'.$urlOptionStr_t;
	  }
	
	  $tplcontent=$this->tpl;//分页模板
	  $showPage=$tplcontent;
	  //首页
	  if (preg_match_all('/\{index=([^}]*+)\}/', $tplcontent, $matches)){
		  if($this->web_url_module=='1'){
			  $newurl='';
			  $newurl=$urlMain.'?page=1'.$urlOptionStr;
		  }elseif($this->web_url_module=='2'){
			  $newurl='';
			  $t_arr=array();
			  $t_file_arr=array();
			  $urlMain=preg_replace('/_p_(\d+)/','',$urlMain);
			  $t_arr=parse_url($urlMain);
			  $t_file_arr=explode('.',$t_arr['path']);
			  $newurl=$t_arr[0].$t_file_arr[0].'_p_1.'.$t_file_arr[1];
		  }
		  $t_tpl=$matches[0][0]; //模板内容
		  $t_word=$matches[1][0]; //分页字段
		  $indexStr='<a href="'.$newurl.'">'.$t_word.'</a>';
		  $showPage=str_replace($t_tpl,$indexStr,$showPage);
	  }
	  //当前页
	  if (preg_match_all('/\{cur=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
		  $curStr=$t_word.$this->cpage.'/'.$this->totalPage;
		  $showPage=str_replace($t_tpl,$curStr,$showPage);
	  }
	  //末页
	  if (preg_match_all('/\{end=([^}]*+)\}/', $tplcontent, $matches)){
		  //这里判断 如果总页数为0 则最后页设置为1
		  $total_page=$this->totalPage==0?1:$this->totalPage;
		  if($this->web_url_module=='1'){
			  $newurl='';
			  $newurl=$urlMain.'?page='.$total_page.$urlOptionStr;
		  }elseif($this->web_url_module=='2'){
			  $newurl='';
			  $t_arr=array();
			  $t_file_arr=array();
			  $urlMain=preg_replace('/_p_(\d+)/','',$urlMain);
			  $t_arr=parse_url($urlMain);
			  $t_file_arr=explode('.',$t_arr['path']);
			  $newurl=$t_arr[0].$t_file_arr[0].'_p_'.$total_page.'.'.$t_file_arr[1];
		  }
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
		  $endPage='<a href="'.$newurl.'">'.$t_word.'</a>';
		  $showPage=str_replace($t_tpl,$endPage,$showPage);
		}
	  //上一页
	  if (preg_match_all('/\{pre=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
			if($this->cpage!=1){
				if($this->web_url_module=='1'){
					$newurl='';
					$newurl=$urlMain.'?page='.($this->cpage-1).$urlOptionStr;
				}elseif($this->web_url_module=='2'){
					$newurl='';
					$t_arr=array();
					$t_file_arr=array();
					$urlMain=preg_replace('/_p_(\d+)/','',$urlMain);
					$t_arr=parse_url($urlMain);
					$t_file_arr=explode('.',$t_arr['path']);
					$newurl=$t_arr[0].$t_file_arr[0].'_p_'.($this->cpage-1).'.'.$t_file_arr[1];
				}
				$prePage='<a href="'.$newurl.'">'.$t_word.'</a>';
			}else{
				   $prePage=$t_word;
			}
			$showPage=str_replace($t_tpl,$prePage,$showPage);
	  }
		//下一页
	  if (preg_match_all('/\{next=([^}]*+)\}/',$tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
			if($this->cpage!=$this->totalPage && $this->totalPage>1){
				if($this->web_url_module=='1'){
					$newurl='';
					$newurl=$urlMain.'?page='.($this->cpage+1).$urlOptionStr;
				}elseif($this->web_url_module=='2'){
					$newurl='';
					$t_arr=array();
					$t_file_arr=array();
					$urlMain=preg_replace('/_p_(\d+)/','',$urlMain);
					$t_arr=parse_url($urlMain);
					$t_file_arr=explode('.',$t_arr['path']);
					$newurl=$t_arr[0].$t_file_arr[0].'_p_'.($this->cpage+1).'.'.$t_file_arr[1];
				}
			   $nextPage=' <a href="'.$newurl.'">'.$t_word.'</a>';
			}else{
				   $nextPage=$t_word;
			}
			$showPage=str_replace($t_tpl,$nextPage,$showPage);
		}
		//链接列表
		if (preg_match("{pagelist}",$tplcontent)){
			for($i=1;$i<$this->totalPage+1;$i++){
				if($this->web_url_module=='1'){
					$linkPage=$urlMain.'?page='.$i.$urlOptionStr;					
				}elseif($this->web_url_module=='2'){
					$newurl='';
					$t_arr=array();
					$t_file_arr=array();
					$urlMain=preg_replace('/_p_(\d+)/','',$urlMain);
					$t_arr=parse_url($urlMain);
					$t_file_arr=explode('.',$t_arr['path']);
					$newurl=$t_arr[0].$t_file_arr[0].'_p_'.$i.'.'.$t_file_arr[1];
			  		$linkPage.=' <a href="'.$newurl.'">'.$i.'</a>';
				}
			}
			$showPage=str_replace('{pagelist}',$linkPage,$showPage);
		}
		//下拉框分页
		if (preg_match("{option}",$tplcontent)){
			$optionPage='<select onchange="javascript:window.location='."'".$urlMain."?page='+this.options[this.selectedIndex].value+"."'$urlOptionStr'".';">';
			for($i=1;$i<$this->totalPage+1;$i++){
				if($i==$this->cpage){
					$optionPage.="<option selected='selected' value='$i'>第".$i."页</option>\n";
				}else{
					$optionPage.="<option value='$i'>第".$i."页</option>\n";
				}
			}
			$optionPage.='</select>';
			$showPage=str_replace('{option}',$optionPage,$showPage);
		}
	  return $showPage;
	  }
}
?>