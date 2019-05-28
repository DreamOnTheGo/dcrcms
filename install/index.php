<?php
session_start();
require("../include/common.func.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/install.css" type="text/css" rel="stylesheet">
<title>稻草人企业站管理系统_程序安装</title>
<script type="text/javascript" src="../include/js/jquery.js"></script>
</HEAD>
<BODY>
<?php
$step=$_GET['step'];
if($step=="1" || empty($step)){
	?>
<div id="content" style="margin:80px 180px">
  <UL class=Form_Advance id=FormRegStep1>
    <LI class=Title>安装环境检测_程序安装</LI>
    <li class="Seperator">
      <hr>
    </li>
    <li>您的PHP版本：<?php echo PHP_VERSION;?></li>
    <li>sqlite：
      <?php
  if(function_exists("pdo_drivers")){
	$pdo_drivers=pdo_drivers();
	if(in_array('sqlite',$pdo_drivers)){
		//通过建立新的数据库来全面测试下看
		$sql="";		
		$pdo=new PDO("sqlite:test.db");
		if($pdo){
			//没有错误 开始安装
			//安装表
			$pdo->exec("create table test(a int)");
			if($pdo->errorCode()=='00000'){
				//测试插入数据
				$pdo->exec("insert into test values(1)");
				if($pdo->errorCode()=='00000'){
					echo "<span style='color:green'>支持</span>";
				}else{
					echo "<span style='color:red'>不支持</span>";
				}
			}else{
				echo "<span style='color:red'>不支持</span>";
			}
			unset($pdo);
			@unlink('test.db');
		}else{
			echo "<span style='color:red'>测试失败，可能install目录没有读写权限或者空间不支持本CMS程序要用到的SQLITE驱动</span>";
		}
	}else{
		echo "<span style='color:red'>不支持</span>";
	}
}else{
	echo "<span style='color:red'>不支持</span>";
}
  ?>
    </li>
    <li>mysql：
      <?php  
  if(extension_loaded('mysql')){
	  echo "<span style='color:green'>支持</span>";
  }else{
	  echo "<span style='color:red'>不支持</span>";
  }
  ?>
    </li>
    <li>GD：
      <?php  
  if(extension_loaded('gd')){
	  echo "<span style='color:green'>支持</span>";
  }else{
	  echo "<span style='color:red'>不支持</span>";
  }
  ?>
    </li>
    <li class="Seperator">
      <hr>
    </li>
    <li>目录检测(<span style="color:red">以下目录要有读写权限</span>)：</li>
    <li>
      <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>目录名</td>
          <td>写入权限</td>
          <td>读取权限</td>
        </tr>
        <?php
  function TestWrite($dir){
	$tfile = '_test.txt';
	$d = ereg_replace('/$','',$dir);
	$fp = @fopen($d.'/'.$tfile,'w');
		if(!$fp) return false;
		else
		{
			fclose($fp);
			$rs = @unlink($dir.'/'.$tfile);
			if($rs) return true;
			else return false;
		}
	}
  	$darr=array(
				'/include/*',
				'/data/*',
				'/uploads/*',
				'/templets/*',
				'/install'
				);
	define('WEB_INCLUDE', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ));
	define('WEB_DR', ereg_replace("[/\\]{1,}",'/',substr(WEB_INCLUDE,0,-8) ) );
	foreach($darr as $dir){		
		$filldir = WEB_DR.str_replace('/*','',$dir);
		$isread=(is_readable($filldir) ? '<font color=green>[√]读</font>' : '<font color=red>[×]读</font>');
	    $iswrite = (TestWrite($filldir) ? '<font color=green>[√]写</font>' : '<font color=red>[×]写</font>');
		echo "<tr><td>$dir</td><td>$isread</td><td>$iswrite</td></tr>";
      	//$rsta = (is_readable($filldir) ? '<font color=green>[√]读</font>' : '<font color=red>[×]读</font>');
	    		//$wsta = (TestWrite($filldir) ? '<font color=green>[√]写</font>' : '<font color=red>[×]写</font>');
	    		//echo "<td>$rsta</td><td>$wsta</td>\r\n";
	}
  ?>
      </table>
    </li>
    <li class="Seperator">
      <hr>
    </li>
    <LI class=SubmitBox>
      <INPUT class="btn" type="button" onclick="location.href='index.php?step=2'" value="进入下一步" name=Submit>
    </LI>
  </UL>
</div>
<?php
}
if($step=="2"){
?>
<DIV id="content" style="margin:80px 180px">
  <form action="install_action.php" method="post">
    <input type="hidden" name="action" id="action" value="install">
    <UL class=Form_Advance id=FormRegStep1>
      <LI class=Title>稻草人企业站管理系统_程序安装</LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>数据库类型：</DIV>
        <DIV class=FormInput>
          <input name="db_type" type="radio" id="db_type" style="width:15px; border:none; height:15px;" onclick="ShowPanel(1)" value="1" checked="checked" />SQLite
          <input type="radio" onclick="ShowPanel(2)" name="db_type" id="db_type" value="2" style="width:15px; border:none; height:15px;" />Mysql
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">SQLite网站处理的数据量小于10W时选择,当网站要处理的数据量比较大时选择Mysql</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <span id="sqlitepanel">
      <li>
        <DIV class=Hint>数据库名称：</DIV>
        <DIV class=FormInput>
          <input id="sqlite_table" size="24" class="Warning" name="sqlite_table" value="dcr_qy.php" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">请输入的数据库名,默认为dcr_qy.php，数据库会建立在data目录中，为了防止数据库被下载，一般把数据库的后缀设置为.php</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      </span> <span id="mysqlpanel" style="display:none">
      <li>
        <DIV class=Hint>数据库主机：</DIV>
        <DIV class=FormInput>
          <input id="host" size="24" class="Warning" name="host" value="localhost" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">本机的话为localhost,非本机填IP</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>数据库名称：</DIV>
        <DIV class=FormInput>
          <input id="table" size="24" class="Warning" name="table" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>数据库用户：</DIV>
        <DIV class=FormInput>
          <input name="name" class="Warning" id="name" size="24" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>数据库密码：</DIV>
        <DIV class=FormInput>
          <input id="pass" size="24" class="Warning" name="pass" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">
            <div id="content_alert"></div>
          </div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      </span>
      <li>
        <DIV class=Hint>数据库前缀：</DIV>
        <DIV class=FormInput>
          <input id="tablepre" size="24" class="Warning" name="tablepre" value="dcr_qy_" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">如果数据库中存在相同前缀的表，请用不同的前缀</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>管理员用户名：</DIV>
        <DIV class=FormInput>
          <input id="adminuser" size="24" class="Warning" name="adminuser" value="admin" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">管理员用户名</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>管理员密码：</DIV>
        <DIV class=FormInput>
          <input name="adminpas" type="text" class="Warning" id="adminpas" value="admin" size="24" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">管理员密码</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>网址地址：</DIV>
        <DIV class=FormInput>
          <?php
  $topurl='http://'.GetTopUrl();
  //如果有端口加上
  ?>
          <input id="web_url" size="24" class="Warning" name="web_url"  value="<?php echo $topurl;?>" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">网站地址</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>网站名称：</DIV>
        <DIV class=FormInput>
          <input id="web_name" size="24" class="Warning" name="web_name" value="我的网站" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">网站名称</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <LI class=SubmitBox>
        <INPUT class="btn" type=submit value="安装程序" name=Submit>
      </LI>
    </UL>
  </form>
  <script type="text/javascript">
 function ShowPanel(id){
	 if(id==1){
		 $("#sqlitepanel").css("display","block")
		 $("#mysqlpanel").css("display","none")
	 }else if((id==2)){
		 $("#sqlitepanel").css("display","none")
		 $("#mysqlpanel").css("display","block")
	 }
 }
 $("#pass").blur(function(){
	action='checkconnect_ajax';
	host=$('#host').val();
	name=$('#name').val();
	pass=$('#pass').val();
	table=$('#table').val();
	actionArr={action:action,host:host,name:name,pass:pass,table:table};
	$.post("install_action.php",actionArr, function(data){
													if(data=='数据库信息正确！'){
														alertTxt="<span style='color:green'>"+data+"</span>";
													}else if(data='数据库信息有误！'){
														alertTxt="<span style='color:red'>"+data+"</span>";
													}
													$('#content_alert').html(alertTxt);
													}); 
						 
						 }); 
</script>
</DIV>
<?php } ?>
</BODY>
</HTML>