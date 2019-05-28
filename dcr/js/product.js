// JavaScript Document
function AddClass(){
	classname=encodeURI($('#classname').val());
	classdescription=encodeURI($('#classdescription').val());
	actionArr={classname:classname,classdescription:classdescription};
	$.post("product_class_action.php?action=add_ajax",actionArr, function(data){
														if(data!='添加产品分类成功'){
															alert(data);
														}else if(data=='添加产品分类成功'){
															closeProductClassForm();
															refreshProductClassList();
															//alert('dfs');
														}
														}); 
}
function refreshProductClassList(){
	//刷新产品类别
	$.post("product_class_action.php?action=getlist_ajax",function(list){
																    var s='<select name="classid" id="classid">';
																	s=s+"<option value='0'>请选择产品类别</option>";
																   	for(var i=0;i<list.length;i++){
																		s=s+'<option value='+list[i].id+'>'+decodeURI(list[i].classname)+'</option>'
																   	}
																   	s=s+'</select>';
																   	$('#productClassList').html(s);
																   	},"json");
}
function closeProductClassForm(){
	$('#classname').val("");
	$('#classdescription').val("");
	$('#myframe').css("display","none");
	$('#AddClass').css("display","none");
}
function showProductClassForm(){
	$('#myframe').css("display","block");
	$('#AddClass').css("display","block");
}
function tijiaoAddAction(){
	keyCode=event.keyCode;
	if(keyCode==13){
		AddClass();
		event.keyCode=0;
	}
	return false;
}
function ShowBase()
{
	//alert('a');
	document.getElementById("pro_base").style.display='block';
	document.getElementById("pro_xiangguan").style.display='none';
	document.getElementById("tab_base").className='pro_edit_tab pro_edit_tab_cur';
	document.getElementById("tab_xiangguang").className='pro_edit_tab pro_edit_tab_nocur';
}
function ShowXiangguan()
{
	//alert('b');
	document.getElementById("pro_base").style.display='none';
	document.getElementById("pro_xiangguan").style.display='block';
	document.getElementById("tab_base").className='pro_edit_tab pro_edit_tab_nocur';
	document.getElementById("tab_xiangguang").className='pro_edit_tab pro_edit_tab_cur';
}
function search_products(){
	//搜索相关产品
	pro_search_name=encodeURI($('#pro_search_name').val());
	actionArr={pro_search_name:pro_search_name};
	$('#pro_names_sel').html('loading...');
	$.post("product_action.php?action=search_xiangguan_products", actionArr ,function(date){
		$('#pro_names_sel').html(date);
	});
}
function guanlian()
{
	//pro_names pro_guanlian
	$("#pro_names option:selected").each(function(){
		$("#pro_guanlian").append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option");
		$(this).remove();　
	})
	set_guanlian_pronames();
}
function guanlian_cancel()
{
	//pro_names pro_guanlian
	$("#pro_guanlian option:selected").each(function(){
　　　　	$(this).remove();　
	})
	set_guanlian_pronames();
}
function set_guanlian_pronames()
{
	var str='';
	$("#pro_guanlian option").each(function(){
		str = str + $(this).val() + ',';
	})
	$('#pro_guanlian_value').val(str);
}



//显示产品标题编辑框
function show_edit_input(id)
{
    $('#span_title_txt_' + id).hide();
    $('#span_title_input_' + id).show();
}

//在产品标题上按键，主要是回车更新标题这个操作
function input_title_keyup(e, id)
{
    var key_num

    if(window.event) // IE
    {
        key_num = e.keyCode
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        key_num = e.which
    }
    //console.log(key_num);
    if( 13 == key_num )
    {
        var new_val = $('#input_title_' + id).val();
        var old_val = $('#input_title_' + id).attr("old_value");
        if( old_val != new_val )
        {
            update_product_name(id, new_val);
        }else
        {
            $('#span_title_txt_' + id).show();
            $('#span_title_input_' + id).hide();
        }
        //console.log(new_val);
    } else if ( 27 == key_num)
    {
        $('#span_title_txt_' + id).show();
        $('#span_title_input_' + id).hide();
    }
}

//更新产品标题
function update_product_name(id, new_val)
{
    action_arr = {id:id, title:new_val};
    $.post( "product_action.php?action=update_product_name_byajax", action_arr, function( data )
    {       
        $('#span_title_txt_' + id).html(data);
        $('#span_title_txt_' + id).show();
        $('#title_input_' + id).val(data);
        $('#title_input_' + id).attr('old_value', data);
        $('#span_title_input_' + id).hide();
    });
}