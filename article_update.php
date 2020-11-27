<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$is_manage_login=is_manage_login($link);
$member_id=is_login($link);
if(!$member_id && !$is_manage_login){
	skip('login.php', 'error', '您没有登录!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '帖子id参数不合法!');
}
if(!isPost()){
    skip(__FILE__,1,'请使用post方式');
}
$query="select * from sfk_content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	$data_content['title']=htmlspecialchars($data_content['title']);
	if(check_user($member_id,$data_content['member_id'],$is_manage_login)){
	
			include 'inc/check_publish.inc.php';
			$_POST=escape($link, $_POST);
			$query="update sfk_content set module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' where id={$_GET['id']}";
			execute($link, $query);
			if(isset($_GET['return_url'])){
				$return_url=$_GET['return_url'];
			}else{
				$return_url="member.php?id={$member_id}";
			}
			if(mysqli_affected_rows($link)==1){
				skip($return_url, 'ok', '修改成功！');
			}else{
				skip($return_url, 'error', '修改失败，请重试！');
			}
		
	}else{
		skip('index.php', 'error', '这个帖子不属于你，你没有权限!');
	}
}else{
	skip('index.php', 'error', '帖子不存在!');
}
?>