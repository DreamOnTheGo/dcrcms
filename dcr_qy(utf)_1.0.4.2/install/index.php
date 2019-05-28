<?php
session_start();
require("../include/common.func.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/install.css" type="text/css" rel="stylesheet">
<title>稻草人企业站管理系统_程序安装</title>
<script type="text/javascript" src="../include/js/jquery.js"></script>
</head>
<body>
<?php
$step=$_GET['step'];
if($step=="1" || empty($step)){
	?>
<div id="content" style="margin:80px 180px">
  <ul class=Form_Advance id=FormRegStep1>
    <li class=Title>安装环境检测_程序安装</li>
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
		try{
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
		}catch(Exception $e)
		{
    		echo $e->getMessage();
			echo "<span style='color:red'>测试失败，可能install目录没有读写权限或者你的网站目录里有中文</span>";
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
	//$d = ereg_replace('/$','',$dir);
	$fp = @fopen($dir.'/'.$tfile,'w');
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
	define('WEB_INCLUDE', str_replace("\\",'/',dirname(__FILE__) ));
	define('WEB_DR', str_replace("\\",'/',substr(WEB_INCLUDE,0,-8) ) );
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
    <li class=SubmitBox>
      <input class="btn" type="button" onclick="location.href='index.php?step=2'" value="进入下一步" name=Submit>
    </li>
  </ul>
</div>
<?php
}
if($step=="2"){
?>
<div id="content" style="margin:80px 180px">
  <form action="install_action.php" method="post">
    <input type="hidden" name="action" id="action" value="install">
    <ul class=Form_Advance id=FormRegStep1>
      <li class=Title>稻草人企业站管理系统_程序安装</li>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <div class=Hint>数据库类型：</div>
        <div class=FormInput>
          <input name="db_type" type="radio" id="db_type" style="width:15px; border:none; height:15px;" onclick="ShowPanel(1)" value="1" checked="checked" />
          SQLite
          <input type="radio" onclick="ShowPanel(2)" name="db_type" id="db_type" value="2" style="width:15px; border:none; height:15px;" />
          Mysql </div>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">SQLite网站处理的数据量小于10W时选择,当网站要处理的数据量比较大时选择Mysql</span></div>
        </div>
        <div class=HackBox></div>
      </li>
      <span id="sqlitepanel">
      <li>
        <div class=Hint>数据库名称：</div>
        <div class=FormInput>
          <input id="sqlite_table" size="24" class="Warning" name="sqlite_table" value="dcr_qy.php" />
        </div>
        <div class="Info">
          <div class="alert_txt">请输入的数据库名,默认为dcr_qy.php，数据库会建立在data目录中，为了防止数据库被下载，一般把数据库的后缀设置为.php</div>
        </div>
        <div class=HackBox></div>
      </li>
      </span> <span id="mysqlpanel" style="display:none">
      <li>
        <div class=Hint>数据库主机：</div>
        <div class=FormInput>
          <input id="host" size="24" class="Warning" name="host" value="localhost" />
        </div>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">本机的话为localhost,非本机填IP</span></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>数据库名称：</div>
        <div class=FormInput>
          <input id="table" size="24" class="Warning" name="table" />
        </div>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>数据库用户：</div>
        <div class=FormInput>
          <input name="name" class="Warning" id="name" size="24" />
        </div>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>数据库密码：</div>
        <div class=FormInput>
          <input id="pass" size="24" class="Warning" name="pass" />
        </div>
        <div class="Info">
          <div class="alert_txt">
            <div id="content_alert"></div>
          </div>
        </div>
        <div class=HackBox></div>
      </li>
      </span>
      <li>
        <div class=Hint>数据库前缀：</div>
        <div class=FormInput>
          <input id="tablepre" size="24" class="Warning" name="tablepre" value="dcr_qy_" />
        </div>
        <div class="Info">
          <div class="alert_txt">如果数据库中存在相同前缀的表，请用不同的前缀</div>
        </div>
        <div class=HackBox></div>
      </li>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <div class=Hint>管理员用户名：</div>
        <div class=FormInput>
          <input id="adminuser" size="24" class="Warning" name="adminuser" value="admin" />
        </div>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">管理员用户名</span></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>管理员密码：</div>
        <div class=FormInput>
          <input name="adminpas" type="text" class="Warning" id="adminpas" value="admin" size="24" />
        </div>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">管理员密码</span></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <div class=Hint>网址地址：</div>
        <div class=FormInput>
          <?php
  $topurl='http://'.GetTopUrl();
  $dir_name=dirname($_SERVER['SCRIPT_NAME']);
  $dir_name=str_replace('/install','',$dir_name);
  $dir_name=str_replace('/','',$dir_name);
  $dir_name=str_replace('\\','',$dir_name);
  //如果有端口加上
  ?>
          <input id="web_url" size="24" class="Warning" name="web_url"  value="<?php echo $topurl;?>" />
        </div>
        <div class="Info">
          <div class="alert_txt">网站地址，这里填写网站的顶级域名 <span style="color:red;">请不要带/</span></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>网站目录：</div>
        <div class=FormInput>
          <input id="web_dir" size="24" class="Warning" name="web_dir"  value="<?php echo $dir_name; ?>" />
        </div>
        <div class="Info">
          <div class="alert_txt">如果您的<span style="color:red;">网站安装在二级目录</span>下，请在这里填写目录名</div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>网站名称：</div>
        <div class=FormInput>
          <input id="web_name" size="24" class="Warning" name="web_name" value="我的网站" />
        </div>
        <div class="Info">
          <div class="alert_txt">网站名称</div>
        </div>
        <div class=HackBox></div>
      </li>
      <li>
        <div class=Hint>网址模式：</div>        
        <div class=FormInput>
          <input name="web_url_module" type="radio" id="web_url_module" style="width:15px; border:none; height:15px;" value="1" checked="checked" />
          动态
          <input type="radio" name="web_url_module" id="web_url_module" value="2" style="width:15px; border:none; height:15px;" />
          伪静态 </div>
        <div class="Info">
          <div class="alert_txt">网址模板,动态即网站都以php来展示，伪静态即以html来展示.<a href="http://www.dcrcms.com/news.php?id=17" target="_blank">开启伪静态的方法请点击这里</a></div>
        </div>
        <div class=HackBox></div>
      </li>
      <li class="Seperator">
        <hr>
      </li>
      <li class=SubmitBox>
        <input class="btn" type=submit value="安装程序" name=Submit>
      </li>
    </ul>
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
</div>
<?php } ?>
</body>
</html>