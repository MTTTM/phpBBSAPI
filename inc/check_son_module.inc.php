<?php 
if(!is_numeric($_POST['father_module_id'])){
	skip(__FILE__,1,'所属父版块不得为空！');
}
$query="SELECT * FROM sfk_fatcher_module WHERE id={$_POST['father_module_id']}";
 $result=execute($link,$query);
if(mysqli_num_rows($result)==0){
	skip(__FILE__,1,"{$_POST['father_module_id']}所属父版块不存在");
}
if(empty($_POST['module_name'])){
	skip(__FILE__,1,'子版块名称不得为空！');
}
if(mb_strlen($_POST['module_name'])>66){
	skip(__FILE__,1,'子版块名称不得多余66个字符！');
}
if(empty($_POST['name'])){
	skip(__FILE__,1,'名称不得为空！');
}
if(mb_strlen($_POST['name'])>66){
	skip(__FILE__,1,'名称不得多余66个字符！');
}
$_POST=escape($link,$_POST);
switch ($check_flag){
	case 'add':
		$query="select * from sfk_son_module where name='{$_POST['name']}'";
		break;
	case 'update':
		$query="select * from sfk_fatcher_module where name='{$_POST['name']}' and id!={$_GET['id']}";
		break;
	default:
		skip('father_module_add.php',1,'$check_flag参数错误！');
}
$result=execute($link,$query);
if(mysqli_num_rows($result)){
	skip(__FILE__,1,'这个子版块已经有了！');
}
if(mb_strlen($_POST['info'])>255){
	skip(__FILE__,1,'子版块简介不得多于255个字符！');
}
if(!is_numeric($_POST['sort'])){
	skip(__FILE__,1,'排序只能是数字！');
}
?>