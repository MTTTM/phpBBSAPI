<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
$is_manage_login=is_manage_login($link);

if(!isset($_GET['keyword'])){
	$_GET['keyword']='';
}
if(isset($_GET['page'])&&!is_numeric($_GET['page'])){
	skip('index.php', 'error', '分页page参数不合法!');
}
if(isset($_GET['page_size']) && !is_numeric($_GET['page_size'])){
	skip('index.php', 'error', '分页page_size参数不合法!');
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link,$_GET['keyword']);
$page=isset($_GET['page'])?$_GET['page']:0;
$page_size=isset($_GET['page_size'])?$_GET['page_size']:10;
$query="select count(*) from sfk_content where title like '%{$_GET['keyword']}%'";
$count_all=num($link,$query);
$query="select
sfk_content.title,
sfk_content.id,
sfk_content.time,
sfk_content.times,
sfk_content.member_id,
skf_menber.name,
skf_menber.photo
from
sfk_content,
skf_menber
where
sfk_content.title
 like '%{$_GET['keyword']}%'
and
sfk_content.member_id=skf_menber.id limit {$page},{$page_size}";

$result_content=execute($link,$query);
$data_content=mysqli_fetch_all($result_content,MYSQLI_ASSOC);
if(sizeof($data_content)>0){
    foreach($data_content as $item){
        $item['title']=htmlspecialchars($item['title']);
        $item['title_color']=str_replace($_GET['keyword'],"<span style='color:red;'>{$_GET['keyword']}</span>",$item['title']);
        $query="select time from sfk_reply where content_id={$item['id']} order by id desc limit 1";
        $result_last_reply=execute($link, $query);
        if(mysqli_num_rows($result_last_reply)==0){
            $last_time='暂无';
        }else{
            $data_last_reply=mysqli_fetch_assoc($result_last_reply);
            $last_time=$data_last_reply['time'];
        }
    }
    skip(__FILE__,0,'获取成功',$data_content);
}
else{
    skip(__FILE__,0,"没有查到[{$_GET['keyword']}]相关内容",array());
}

?>