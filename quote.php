<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php', 'error', '请登录之后再做回复!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '您要回复的帖子id参数不合法!');
}
$query="select 
sc.id,
sc.title,
sm.name
from 
sfk_content sc,
skf_menber sm 
where
sc.id={$_GET['id']}
and
sc.member_id=sm.id";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php', 'error', '您要回复的帖子不存在!');
}
if(!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
	skip('index.php', 'error', '您要引用的回复id参数不合法!');
}
$query="select sfk_reply.content,skf_menber.name from sfk_reply,skf_menber where sfk_reply.id={$_GET['reply_id']} and sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=skf_menber.id";
$result_reply=execute($link, $query);
if(mysqli_num_rows($result_reply)!=1){
	skip('index.php', 'error', '您要引用的回复不存在!');
}
if(isPost()){
	include 'inc/check_reply.inc.php';
	$_POST=escape($link,$_POST);
	$query="insert into sfk_reply(content_id,quote_id,content,time,member_id) 
			values(
				{$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id}
			)";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}", 'ok', '回复成功!');
	}else{
		skip($_SERVER['REQUEST_URI'], 'error', '回复失败,请重试!');
	}
}
else{
    skip(__FILE__,1,'请使用post方式');
}


?>
