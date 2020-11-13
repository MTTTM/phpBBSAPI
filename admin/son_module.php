<?php 
	include_once '../inc/config.inc.php';
	include_once '../inc/mysqli.inc.php';
	include_once '../inc/tool.inc.php';
	$link=connect();
	$query="select ssm.id,ssm.sort,ssm.module_name,sfm.module_name father_module_name,ssm.member_id from sfk_son_module ssm,sfk_fatcher_module sfm where ssm.father_module_id=sfm.id order by sfm.id";
	$result=execute($link,$query);
	
	if($data=mysqli_fetch_all($result,MYSQLI_ASSOC)){
		skip(__FILE__,0,$data);
	}
	else{
		skip(__FILE__,1,'获取失败');
	}
?>

