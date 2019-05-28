<?php
$cls_news = cls_app:: get_news();
$classname = ($classid!=0) ? $cls_news-> get_class_name($classid) . '_新闻中心' : '新闻中心';
?>