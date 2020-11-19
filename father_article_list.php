<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '父版块id参数不合法!');
}
if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
	skip('index.php', 'error', '分页page参数不合法!');
}
if(isset($_GET['page_size']) && !is_numeric($_GET['page_size'])){
	skip('index.php', 'error', '分页page_size参数不合法!');
}
$query="select * from sfk_fatcher_module where id={$_GET['id']}";
$result_father=execute($link, $query);
if(mysqli_num_rows($result_father)==0){
	skip('index.php', 'error', '父版块不存在!');
}
$page=$_GET['page'];
$page_size=isset($_GET['page_size'])?$_GET['page_size']:10;

$data_father=mysqli_fetch_assoc($result_father);
$query="select * from sfk_son_module where father_module_id={$_GET['id']}";
$result_son=execute($link,$query);
$id_son='';
while($data_son=mysqli_fetch_assoc($result_son)){
	$id_son.=$data_son['id'].',';
}
$id_son=trim($id_son,',');
if($id_son==''){
	$id_son='-1';
}
// $query="select count(*) from sfk_content where module_id in({$id_son})";
// $count_all=num($link,$query);
// $query="select count(*) from sfk_content where module_id in({$id_son}) and time>CURDATE()";
// $count_today=num($link,$query);

$query="select 
    sfk_content.title,
    sfk_content.id,
    sfk_content.time,
    skf_menber.name,
    skf_menber.photo,
    sfk_son_module.module_name 
    from
    sfk_content,
    skf_menber,
    sfk_son_module
    where 
    sfk_content.module_id in({$id_son}) and 
    sfk_content.member_id=skf_menber.id and 
    sfk_content.module_id=sfk_son_module.id limit {$page},{$page_size}";
$result_content=execute($link,$query);
$data_content=mysqli_fetch_all($result_content,MYSQLI_ASSOC);
var_dump($id_son);
skip(__FILE__,0,'获取成功',$data_content);
?>