<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
// include_once 'inc/vcode.inc.php';
$link=connect();
if(is_login($link)){
	skip('index.php','error','你已经登录，请不要重复注册！');
}
if(isPost()){
	include 'inc/check_register.inc.php';
	$query="insert into skf_menber(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('sfk[name]',$_POST['name']);
		setcookie('sfk[pw]',sha1(md5($_POST['pw'])));
		skip('index.php','ok','注册成功！');
	}else{
		skip('register.php','eror','注册失败,请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>