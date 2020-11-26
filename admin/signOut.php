<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if(isGet()){
    if(is_manage_login($link)){
        header("Content-type:text/html;charset=utf-8");
        session_start();
        setcookie(session_name(),time()-3600);
        skip(__FILE__,0,'登出成功');
        
    }
    else{
        skip(__FILE__,'error','您并没有登录，不需要登出');
    }
}
else{
    skip(__FILE__,1,'请使用get方式');
}

?>