<?php
include_once '../inc/config.inc.php';
 include_once '../inc/mysqli.inc.php';
 $link=connect();
 $query='select count(*) from sfk_fatcher_module';
//  $result=execute($link,$query);
//  var_dump(mysqli_fetch_assoc($result));
// var_dump(execute_bool($link,$query));
// $arr_sqls=array(
//     'select * from sfk_fatcher_module',
//     'select * from sfk_fatcher_module',
//     'select * from sfk_fatcher_module',
//     'select * from sfk_fatcher_module',
//     'select * from sfk_fatcher_module',
//     'select * from sfk_fatcher_module',
// );
// $result=execute_multi($link,$arr_sqls,$error);

// var_dump($result);
$result=mysqli_query($link,$query);
var_dump(num($link,$query));
?>