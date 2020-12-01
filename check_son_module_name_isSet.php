<?php 
include_once './inc/config.inc.php';
include_once './inc/mysqli.inc.php';
include_once './inc/tool.inc.php';
//检查是否已经存在同样name的父级模块
//ALTER TABLE `sfk_son_module` ADD `name` VARCHAR(66) NOT NULL AFTER `sort`, ADD UNIQUE (`name`);
if(empty($_POST['name'])){
	skip('father_module_add.php','error','名称不得为空！');
}
if(mb_strlen($_POST['name'])>66){
	skip('father_module_add.php','error','名称不得多余66个字符！');
}
$link=connect();
$_POST=escape($link,$_POST);
$query="select * from sfk_son_module where name='{$_POST['name']}'";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
	skip('father_module_add.php','error','这个版块已经有了！');
}
else{
	skip('father_module_add.php',0,'这个版块不存在');
}
?>