<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php', 'error', '请登录之后再发帖!');
}
if(isPost()){
	include 'inc/check_publish.inc.php';
	$_POST=escape($link,$_POST);
	$query="insert into sfk_content(module_id,father_module_id,title,content,time,member_id) values({$_POST['module_id']},{$_POST['father_module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$member_id})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('publish.php', 'ok', '发布成功！');
	}else{
		skip('publish.php', 'error', '发布失败，请重试！');
	}
}
else{
	skip(__FILE__,1,'请使用post方式');
}
