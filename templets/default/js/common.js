//��߲�Ʒ����б�
function SubNav(id){
	//alert(document.getElementById("sub_"+id).style.display);
	var o=document.getElementById("sub_"+id);
	//alert(o.className);
	if(o.className=='show' || o.className=='subclass'){
		o.className='hide';
	}else{
		o.className='show';
	}
}