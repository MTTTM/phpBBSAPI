<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip(__FILE__,'error','id参数错误！');
}
$query="select * from sfk_son_module where id={$_GET['id']}";
$result=execute($link,$query);
if(!mysqli_num_rows($result)){
	skip(__FILE__,'error','这条子版块信息不存在！');
}
$data=mysqli_fetch_assoc($result);
if(isPost()){
	//验证
	$check_flag='update';
	include '../inc/check_son_module.inc.php';
	$query="update sfk_son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip(__FILE__,'ok','修改成功！');
	}else{
		skip(__FILE__,'error','修改失败,请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>