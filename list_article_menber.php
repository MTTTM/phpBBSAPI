<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '会员id参数不合法!');
}
if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
	skip('index.php', 'error', '分页page参数不合法!');
}
if(isset($_GET['page_size']) && !is_numeric($_GET['page_size'])){
	skip('index.php', 'error', '分页page_size参数不合法!');
}
$query="select * from skf_menber where id={$_GET['id']}";
$result_memebr=execute($link, $query);
if(mysqli_num_rows($result_memebr)!=1){
	skip('index.php', 'error', '你所访问的会员不存在!');
}
$query="select count(*) from sfk_content where member_id={$_GET['id']}";
$count_all=num($link, $query);
$page=$_GET['page'];
$page_size=isset($_GET['page_size'])?$_GET['page_size']:10;

$query="select
sfk_content.title,
sfk_content.id,
sfk_content.time,
sfk_content.member_id,
sfk_content.times,
skf_menber.name,
skf_menber.photo
from 
sfk_content,
skf_menber
where
sfk_content.member_id={$_GET['id']} and
sfk_content.member_id=skf_menber.id order by id desc limit {$page},{$page_size}";
$result_content=execute($link, $query);
$result_arr=array();
while($data_content=mysqli_fetch_assoc($result_content)){
    $data_content['title']=htmlspecialchars($data_content['title']);
    $query="select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 1";
    $result_last_reply=execute($link, $query);
    if(mysqli_num_rows($result_last_reply)==0){
        $last_time='暂无';
    }else{
        $data_last_reply=mysqli_fetch_assoc($result_last_reply);
        $last_time=$data_last_reply['time'];
    }
    $query="select count(*) from sfk_reply where content_id={$data_content['id']}";
    $reply_num=num($link,$query);
    $data_content['replay_num']= $reply_num;
    $data_content['last_time']=  $last_time;
    array_push($result_arr,$data_content);
}
skip(__FILE__,0,'获取成功',
array(
'list'=>$result_arr,
'count_all'=>$count_all,
'page'=>$page
))
?>
