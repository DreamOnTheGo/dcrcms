<?php
	if($classid == 0)
	{
		$classname = "产品中心";
		$position = '首页>>产品中心';
	}else
	{
		$cls_pro = cls_app:: get_product();
		$class_info = $cls_pro->get_class_info($classid);
		//p_r($class_info);
		$classname = $class_info['classname'];
		$position = $class_info['position'];
	}
?>