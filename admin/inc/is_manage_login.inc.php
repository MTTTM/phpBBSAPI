<?php 
if(!is_manage_login($link)){
	skip($_SERVER['HTTP_REFERER'],'error','您未登录');
}
if(basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){
	
	if($_SESSION['manage']['level']!='0'){
		if(!isset($_SERVER['HTTP_REFERER'])){
			$_SERVER['HTTP_REFERER']='index.php';
		}
		skip($_SERVER['HTTP_REFERER'],'error',$_SESSION['manage']['level']);
	}
}
?>