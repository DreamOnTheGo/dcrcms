/*
 * images player
 * author:mr路zhong
 * date:2010-04-19
 */
 
//褰揿墠瀵艰埅椤电爜鏁板瓧
var currentPage = 1;
//锲剧墖闂撮殧镞堕棿
var playerTime = 3000;

$(function(){	
	SetPlayerNavPosition();		   	
	OnLoadingImages();	
	OnLoadingLinks();
	setInterval("Player()",playerTime);
});

/*
 * 锲剧墖鎾斁鏂规硶
 */
function Player(){
	PageClick($("#page_" + currentPage));
	
	if(currentPage == $("#playerNav a").length)
		currentPage = 1;
	else
		currentPage++;
}

/*
 * 鍒涘缓锲剧墖椤电爜路骞剁粦瀹氶〉镰佺殑click浜嬩欢
 * count:闇€瑕佸垱寤洪〉闱㈢殑涓暟
 */
function CreatePageNberObj(count){
	var pages = '';

	for(var i = 1; i <= (count - 1); i++){
		pages += '<a id="page_' + i + '" idx="' + i + '" onfocus="blur()">' + i + '</a>';		
	}
	
	$("#playerNav").html(pages);
	
	for(var i = 1; i <= count; i++){
		BindPageClick("page_" + i);
	}
}

/*
 * 锷犺浇锲剧墖板喡峰苟涓哄浘鐗囱瀹氩敮涓€ID锛屾渶鍚庢樉绀轰竴寮犻殣钘忓叾瀹?
 */
function OnLoadingImages(){
	var li_id = 1;
	
	$("#playerImage li").each(function(){
		$(this).attr("id","play_img_" + li_id);				
		
		if(li_id > 1){
			SetImageShowOrHide($(this),false);
		}
		
		li_id++;
	});
}

/*
 * 锷犺浇锲剧墖鐩稿搴旈摼鎺ラ泦路骞朵负阈炬帴璁惧畾鍞竴ID锛屾渶鍚庢樉绀哄鐩稿簲镄勯摼鎺ラ殣钘忓叾瀹?
 */
function OnLoadingLinks(){
	var a_id = 1;
	
	$("#playerTitle a").each(function(){
		$(this).attr("id","link_" + a_id);				

		if(a_id > 1){
			SetImageShowOrHide($(this),false);
		}
						
		a_id++;
	});
	
	CreatePageNberObj(a_id);
}

/*
 * 缁戝畾锲剧墖椤电爜镄刢lick浜嬩欢搴曞眰鏂规硶
 */
function BindPageClick(id){
	$("#" + id).click(function(){
		PageClick($(this));
	});
}

/*
 * 锲剧墖椤电爜Click澶勭悊鏂规硶
 * obj:褰揿墠椤电爜鍏幂礌瀵硅薄
 */
function PageClick(obj){
	var id = obj.attr("idx");	
	
	//褰挞〉镰佸湪镊姩鎾斁镄勬椂链欑偣鍑讳简镆愪釜椤电爜鏁板瓧蹇呴』鍐嶉吨鏂拌祴链肩粰褰揿墠镄刢urrentPage璁板綍鍣?
	currentPage = id;
	//璁剧疆镓€链夐〉镰佹牱寮忎负榛樿
	$("#playerNav a").removeClass("hover");
	//璁剧疆褰揿墠阃変腑镄勯〉镰佹暟瀛椾负鎸囧畾镄勯鑹?
	SetPageColor(obj,true);				
	
	//鏄剧ず鎴栭殣钘忓浘鐗?
	$("#playerImage li").each(function(){										   
		if($(this).attr("id") == ("play_img_" + id)){
			SetImageShowOrHide($(this),true);
		}else{
			SetImageShowOrHide($(this),false);			
		}									
	});
	
	//鏄剧ず鎴栭殣钘忔枃瀛楅摼
	$("#playerTitle a").each(function(){										   
		if($(this).attr("id") == ("link_" + id)){
			SetImageShowOrHide($(this),true);
		}else{
			SetImageShowOrHide($(this),false);			
		}									
	});	
}

/*
 * 璁剧疆鎸囧畾镄勫厓绱犳垨锲剧墖鏄剧ず鎴栦笉闅愯棌
 * obj:闇€瑕侀殣钘忕殑鍏幂礌
 * isShow:鏄剧ずor闅愯棌
 */
function SetImageShowOrHide(obj,isShow){
	if(!isShow){
		obj.css("display","none");
	}else{
		obj.css("display","block");
	}
}

/*
 * 璁剧疆鎸囧畾镄勫浘鐗囬〉镰佹牱寮?
 * obj:闇€瑕佽缃殑鍏幂礌
 * isSelect:鏄惁阃変腑
 */
function SetPageColor(obj,isSelect){
	if(!isSelect){
		obj.removeClass("hover");
	}else{
		obj.addClass("hover");
	}
}

/*
 * 璁剧疆锲剧墖鏁板瓧阈炬帴鍜屽浘鐗囨爣棰楧IV浣岖疆
 */
function SetPlayerNavPosition(){
	var offset = $("#playerBox").offset();
	var boxHeight = $("#playerBox").height();
	var navHeight = $("#playerNavAndTitle").height();
	
	$("#playerNavAndTitle").css({ top:(offset.top + boxHeight - navHeight) + 1 + "px", left:offset.left + 1 + "px" });
}