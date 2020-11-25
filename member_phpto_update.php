<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/upload.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php', 'error', '请登录之后再对自己的头像做设置!');
}
$query="select * from skf_menber where id={$member_id}";
$result_memebr=execute($link,$query);
$data_member=mysqli_fetch_assoc($result_memebr);
if(isPost()){
    // var_dump($_POST,isset($_POST['file']),$_FILES['file']);
	$save_path='uploads'.date('/Y/m/d/');//写上服务器上文件系统的路径，而不是url地址
	$upload=upload($save_path,'8M','file');
	if($upload['return']){
		$query="update skf_menber set photo='{$upload['save_path']}' where id={$member_id}";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1){
			skip("member.php?id={$member_id}",'ok','头像设置成功！');
		}else{
			skip('member_photo_update.php','error','头像设置失败，请重试');
		}
	}else{
		skip('member_photo_update.php', 'error',$upload['error']);
	}
}else{
	skip(__FILE__,1,'请使用post方式');
}
?>