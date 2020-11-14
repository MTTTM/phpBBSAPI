<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysqli.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(isGet()){
    if(is_login($link)){
        setcookie('sfk[name]',$_POST['name'],time()-36000);
        setcookie('sfk[pw]',sha1(md5($_POST['pw'])),time()-36000);
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