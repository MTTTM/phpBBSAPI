<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
session_start();
$link=connect();
if(is_manage_login($link)){
	skip('index.php','ok','您已经登录，请不要重复登录！');
}
if(isPost()){
	include_once 'inc/check_login.inc.php';
	// $_POST=escape($link,$_POST);
	$query="select * from sfk_manage where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}')";
	$result=execute($link, $query);
	if(mysqli_num_rows($result)==1){
		$data=mysqli_fetch_assoc($result);
		$_SESSION['manage']['name']=$data['name'];
		$_SESSION['manage']['pw']=sha1($data['pw']);
		$_SESSION['manage']['id']=$data['id'];
		$_SESSION['manage']['level']=$data['level'];
		skip('index.php','ok','登录成功！');
	}else{
		skip('login.php','error','用户名或者密码错误，请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>