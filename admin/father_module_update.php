<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

$template['title']='父版块-修改';
$template['css']=array('style/public.css');
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip(__FILE__,1,'id参数错误！');
}
$query="select * from sfk_fatcher_module where id={$_GET['id']}";
$result=execute($link,$query);
if(!mysqli_num_rows($result)){
	skip(__FILE__,1,'这条版块信息不存在！');
}
if(isPost()){
	//验证
	$check_flag='update';
	include '../inc/check_father_module.inc.php';
	$query="update sfk_fatcher_module set module_name='{$_POST['module_name']}',sort={$_POST['sort']},name={$_POST['name']} where id={$_GET['id']}";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip(__FILE__,0,'修改成功！');
	}else{
		skip(__FILE__,1,'修改失败,请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post的方式');
}
?>
