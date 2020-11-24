<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '会员id参数不合法!');
}
$query="select * from skf_menber where id={$_GET['id']}";
$result_memebr=execute($link, $query);
if(mysqli_num_rows($result_memebr)!=1){
	skip('index.php', 'error', '你所访问的会员不存在!');
}
$data_member=mysqli_fetch_assoc($result_memebr);
$query="select count(*) from sfk_content where member_id={$_GET['id']}";
$count_all=num($link, $query);
skip(__FILE__,0,'获取成功',
array(
'data_member'=>$data_member,
'count_all'=>$count_all,
))
?>