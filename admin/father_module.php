<?php 
	include_once '../inc/config.inc.php';
	include_once '../inc/mysqli.inc.php';
	include_once '../inc/tool.inc.php';
	$link=connect();
    $query="select * from sfk_fatcher_module order by sort desc";
    $result_father=execute($link, $query);
    $result_obj=array();
    if(isset($_GET['child'])){
        while ($data_father=mysqli_fetch_assoc($result_father)){
            $result_obj[$data_father['module_name']]=array();
            $query="select * from sfk_son_module where father_module_id={$data_father['id']} order by sort desc";
            $result_son=execute($link, $query);
    
            $result_obj[$data_father['module_name']]=mysqli_fetch_all($result_son,MYSQLI_ASSOC);
        }
    }
    else{
        $result_obj=mysqli_fetch_all($result_father,MYSQLI_ASSOC);
    }
    
    skip(__FILE__,0,'获取成功',$result_obj);
?>

