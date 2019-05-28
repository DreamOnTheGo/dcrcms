<?php
$cls_news = cls_app:: get_news();
$cls_news-> update_click( $id );
$art = $cls_news->get_info($id);
$class_name = $cls_news->get_class_name( $art['classid'] );
?>