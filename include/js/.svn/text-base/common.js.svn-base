function selectAllChk(idname){
	//全选checkbox 用id区分 (把名字为idname的全选)
	var a = document.getElementsByTagName("input"); 
	for (var i=0; i<a.length; i++){
	   if (a[i].type == "checkbox" && a[i].name==idname ) a[i].checked =!a[i].checked; 
	}
}
function show_msg(msg){
	//提示信息 在这个调用前要调用：
	/*
	<script type="text/javascript" src="../include/js/jquery.js"></script>
	<script type='text/javascript' src='../include/js/boxy/javascripts/jquery.boxy.js'></script>
	<link rel="stylesheet" href="../include/js/boxy/stylesheets/boxy.css" type="text/css" />
	*/
	var options;
	options = $.extend({title: "提示信息"}, options || {});
	var dialog = new Boxy("<div ondblclick='Boxy.get(this).hide(); return false;'><p>"+ msg + ". <span style='color:#c0c0c0;'>双击关闭</span></p></div>", options);
  	allDialogs.push(dialog);
	return false;
}
function getFckeditorText(editor_name){
	//获取fckeditor内容
	var oEditor = FCKeditorAPI.GetInstance(editor_name) ; 
	returnValue = oEditor.GetXHTML(true);
	return returnValue; 
} 
