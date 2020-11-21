<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '帖子id参数不合法!');
}
$query="select 
sc.id cid,
sc.module_id,
sc.title,
sc.content,
sc.time,
sc.member_id,
sc.times,
sm.name,
sm.photo
from
sfk_content sc,
skf_menber sm
where 
sc.id={$_GET['id']}
and
sc.member_id=sm.id";
$result_content=execute($link,$query);
if(mysqli_num_rows($result_content)!=1){
	skip('index.php', 'error', '本帖子不存在!');
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);
$data_content['content']=nl2br($data_content['content']);
$query="select * from sfk_son_module where id={$data_content['module_id']}";
$result_son=execute($link,$query);
$data_son=mysqli_fetch_assoc($result_son);

$query="select * from sfk_fatcher_module where id={$data_son['father_module_id']}";
$result_father=execute($link,$query);
$data_father=mysqli_fetch_assoc($result_father);
skip(__FILE__,0,'获取成功',array(
    'title'=>$data_content['title'],
    'content'=>$data_content['content'],
    'times'=>$data_content['times'],
    'time'=>$data_content['time'],
    'father_name'=>$data_father['module_name'],
    'father_id'=>$data_father['id'],
    'son_id'=>$data_son['id'],
    'son_name'=>$data_son['module_name']
));
?>