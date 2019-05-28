<?php
/**
* ��ҳ��
* URL�ж������Ҳ�ܷ�ҳ�������Զ����ҳ��ʽ
* php>=5.0
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 0.1.1
* @copyright 2006-2010
* @package class
*/
class PageClass{
	private $url;
	private $cpage;
	private $totalPage;
	private $tpl;
	/**
	 * PageClass�Ĺ��캯��
	 * ģ��˵����{index}��ʾ��ҳ {pagelist}�����б� {option}�����б�� {next}��һҳ {pre}��һҳ {cur}��ǰҳ {index=��ҳ}��ʾ��ҳ����������Ϊ��ҳ����=�ź�Ϊ�������֣��������{pagelist}{option}��Ч
	 * @param string $cpage ��ǰҳ
	 * @param string $tatolPage ��ҳ��
	 * @param string $tpl ģ��.
	 * @param string $url Ҫ��ҳ��url Ĭ��Ϊ��ǰҳ
	 * @return PageClass
	 */
	function __construct($cpage,$totalPage,$tpl='',$url=''){
	  $this->cpage=$cpage;
	  $this->totalPage=$totalPage;
	  if(strlen($tpl)==0){
		  $this->tpl="{cur=��ǰҳ} {index=��ҳ} {pre=��һҳ} {next=��һҳ} {end=���ҳ} {option}"; //���ķ�ҳ
	  }else{
		  $this->tpl=$tpl;
	  }
	  if(strlen($url)==0){
		  $this->url=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	  }else{
		  $this->url=$url;
	  }
	}
	/**
	 * ����showPage,�������ɵķ�ҳHTML
	 * @return string
	 */
	function showPage(){
	  //��ʾ��ҳ
	  $urlOption=array();//url�ĺ�׺�磺?page=1&typeid=1
	  $parse_url=parse_url($this->url);
	  $urlMain='http://'.$parse_url['path'];
	  if($parse_url['query']){
	   //url�в���
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
	   //urlû�в���
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
	
	  $tplcontent=$this->tpl;//��ҳģ��
	  $showPage=$tplcontent;
	  //��ҳ
	  if (preg_match_all('/\{index=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0]; //ģ������
		  $t_word=$matches[1][0]; //��ҳ�ֶ�
		  $indexStr='<a href="'.$urlMain.'?page=1'.$urlOptionStr.'">'.$t_word.'</a>';
		  $showPage=str_replace($t_tpl,$indexStr,$showPage);
	  }
	  //��ǰҳ
	  if (preg_match_all('/\{cur=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
		  $curStr=$t_word.$this->cpage.'/'.$this->totalPage;
		  $showPage=str_replace($t_tpl,$curStr,$showPage);
	  }
	  //ĩҳ
	  if (preg_match_all('/\{end=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
			$endPage='<a href="'.$urlMain.'?page='.$this->totalPage.$urlOptionStr.'">'.$t_word.'</a>';
			$showPage=str_replace($t_tpl,$endPage,$showPage);
		}
	  //��һҳ
	  if (preg_match_all('/\{pre=([^}]*+)\}/', $tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
			if($this->cpage!=1){
				   $prePage='<a href="'.$urlMain.'?page='.($this->cpage-1).$urlOptionStr.'">'.$t_word.'</a>';
			}else{
				   $prePage=$t_word;
			}
			$showPage=str_replace($t_tpl,$prePage,$showPage);
	  }
		//��һҳ
	  if (preg_match_all('/\{next=([^}]*+)\}/',$tplcontent, $matches)){
		  $t_tpl=$matches[0][0];
		  $t_word=$matches[1][0];
			if($this->cpage!=$this->totalPage && $this->totalPage>1){
			   $nextPage=' <a href="'.$urlMain.'?page='.($this->cpage+1).$urlOptionStr.'">'.$t_word.'</a>';
			  }else{
				   $nextPage=$t_word;
			}
			$showPage=str_replace($t_tpl,$nextPage,$showPage);
		}
		//�����б�
		if (preg_match("{pagelist}",$tplcontent)){
			for($i=1;$i<$this->totalPage+1;$i++){
				$linkPage.=' <a href="'.$urlMain.'?page='.$i.$urlOptionStr.'">'.$i.'</a>';
			}
			$showPage=str_replace('{pagelist}',$linkPage,$showPage);
		}
		//�������ҳ
		if (preg_match("{option}",$tplcontent)){
			$optionPage='<select onchange="javascript:window.location='."'".$urlMain."?page='+this.options[this.selectedIndex].value+"."'$urlOptionStr'".';">';
			for($i=1;$i<$this->totalPage+1;$i++){
				if($i==$this->cpage){
					$optionPage.="<option selected='selected' value='$i'>��".$i."ҳ</option>\n";
				}else{
					$optionPage.="<option value='$i'>��".$i."ҳ</option>\n";
				}
			}
			$optionPage.='</select>';
			$showPage=str_replace('{option}',$optionPage,$showPage);
		}
	  return $showPage;
	  }
}
?>