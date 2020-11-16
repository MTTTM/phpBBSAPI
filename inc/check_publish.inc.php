<?php 
if(empty($_POST['father_module_id']) || !is_numeric($_POST['father_module_id'])){
	skip('publish.php', 'error', '所属父版块id不合法！');
}
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
	skip('publish.php', 'error', '所属版块id不合法！');
}
//检测父板块
$query="select * from sfk_fatcher_module where id={$_POST['father_module_id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
	skip('publish.php', 'error', '所属父版块不存在！');
}

$query="select * from sfk_son_module where id={$_POST['module_id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
	skip('publish.php', 'error', '所属版块不存在！');
}
if(empty($_POST['title'])){
	skip('publish.php', 'error', '标题不得为空！');
}
if(mb_strlen($_POST['title'])>255){
	skip('publish.php', 'error', '标题不得超过255个字符！');
}
?>