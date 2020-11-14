<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(is_login($link)){
	skip('index.php','error','你已经登录，请不要重复登录！');
}
if(isPost()){
	include 'inc/check_login.inc.php';
	escape($link,$_POST);
	$query="select * from skf_menber where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
	$result=execute($link, $query);
	if(mysqli_num_rows($result)==1){
		setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])),time()+$_POST['time']);
		skip('index.php','ok','登录成功！');
	}else{
		skip('login.php', 'error', '用户名或密码填写错误！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>
