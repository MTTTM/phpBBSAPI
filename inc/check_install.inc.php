<?php 
if(empty($_POST['db_host'])){
    skip('login.php', 'error', '数据库地址不得为空！');
}
if(empty($_POST['db_port'])){
    skip('login.php', 'error', '数据库服务端口不得为空！');
}
if(empty($_POST['db_user'])){
    skip('login.php', 'error', '数据库用户名不得为空！');
}
if(!isset($_POST['db_pw'])){
    skip('login.php', 'error', '数据库密码不存在！');
}
if(empty($_POST['db_database'])){
    skip('login.php', 'error', '数据库名称不得为空！');
}
$_POST['manage_name']='admin';
if(empty($_POST['manage_pw']) || mb_strlen($_POST['manage_pw'])<6){
    skip('login.php', 'error', '后台管理员密码不得少于6位！');
}
if(empty($_POST['manage_pw_confirm']) || $_POST['manage_pw']!=$_POST['manage_pw_confirm']){
    skip('login.php', 'error', '两次密码输入不一致！');
}
$link=@mysqli_connect($_POST['db_host'],$_POST['db_user'],$_POST['db_pw'],'',$_POST['port']);
if(mysqli_connect_errno()){
    skip('login.php', 'error', '数据库连接失败，请填写正确的数据库连接信息！');
}
mysqli_set_charset($link,'utf8');
if(!mysqli_select_db($link,$_POST['db_database'])){
	$query="CREATE DATABASE IF NOT EXISTS `{$_POST['db_database']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	mysqli_query($link,$query);
	if(mysqli_errno($link)){
        skip('login.php', 'error', '数据库创建失败，请检查数据库账户权限！');
	}
	mysqli_select_db($link,$_POST['db_database']);
}
?>