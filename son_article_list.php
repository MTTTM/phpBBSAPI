<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', 'id参数不合法!');
}
if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
	skip('index.php', 'error', '分页page参数不合法!');
}
if(isset($_GET['page_size']) && !is_numeric($_GET['page_size'])){
	skip('index.php', 'error', '分页page_size参数不合法!');
}
$query="select * from sfk_son_module where id={$_GET['id']}";
$result_son=execute($link,$query);
if(mysqli_num_rows($result_son)!=1){
	skip('index.php', 'error', '子版块不存在!');
}
$data_son=mysqli_fetch_assoc($result_son);
// $query="select * from sfk_fatcher_module where id={$data_son['father_module_id']}";
// $result_father=execute($link,$query);
// $data_father=mysqli_fetch_assoc($result_father);

$query="select count(*) from sfk_content where module_id={$_GET['id']}";
$count_all=num($link,$query);
$query="select count(*) from sfk_content where module_id={$_GET['id']} and time>CURDATE()";
$count_today=num($link,$query);

$page=$_GET['page'];
$page_size=isset($_GET['page_size'])?$_GET['page_size']:10;

$query="select * from skf_menber where id={$data_son['member_id']}";
$result_member=execute($link, $query);
$query="select
sfk_content.title,
sfk_content.id,
sfk_content.time,
skf_menber.name,
skf_menber.photo
from sfk_content,
skf_menber where
sfk_content.module_id={$_GET['id']} and
sfk_content.member_id=skf_menber.id
limit {$page},{$page_size}";
$result_content=execute($link,$query);
$data_content=mysqli_fetch_all($result_content,MYSQLI_ASSOC);
skip(__FILE__,0,'获取成功',array(
        'count_today'=>$count_today,
        'count_all'=>$count_all,
        'page'=>$page,
        'data'=>$data_content
        )
    );
    
?>