<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
$query="select * from sfk_manage";
$result=execute($link,$query);
if($data=mysqli_fetch_all($result,MYSQLI_ASSOC)){
    skip(__FILE__,0,'获取成功',$data);
}
else{
    skip(__FILE__,1,'获取失败');
}
?>
