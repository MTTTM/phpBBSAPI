<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

if(isPost()){
	$link=connect();
	include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
	//验证用户填写的信息
	$check_flag='add';
	include '../inc/check_son_module.inc.php';
	$query="insert into sfk_son_module(father_module_id,module_name,info,member_id,sort,name) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']},'{$_POST['name']}')";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip(__FILE__,0,'恭喜你，添加成功！');
	}else{
		skip(__FILE__,1,'对不起，添加失败，请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>