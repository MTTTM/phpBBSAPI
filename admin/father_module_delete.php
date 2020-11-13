<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip(__FILE__,'error','id参数错误！');
}

$link=connect();
$query="delete from sfk_fatcher_module where id={$_GET['id']}";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
	skip(__FILE__,0,'恭喜你删除成功！');
}else{
	skip(__FILE__,1,'对不起删除失败，请重试！');
}
?>