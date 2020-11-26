<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

if(isPost()){
	$link=connect();
	include '../inc/check_manage.inc.php';
	include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
	$query="insert into sfk_manage(name,pw,create_time,level) values('{$_POST['name']}',md5({$_POST['pw']}),now(),{$_POST['level']})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('manage.php','ok','恭喜你，添加成功！');
	}else{
		skip('manage.php','error','对不起，添加失败，请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>