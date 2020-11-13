<?php 
function skip($path,$status=0,$message){

    header('Content-Type:application/json; charset=utf-8');
    $arr = array('status'=>$status,'msg'=>$message);
    exit(json_encode($arr));
}
/**
 * 是否是AJAx提交的
 * @return bool
 */
function isAjax(){
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
      return true;
    }else{
      return false;
    }
  }
  /**
   * 是否是GET提交的
   */
  function isGet(){
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }
  /**
   * 是否是POST提交
   * @return int
   */
  function isPost() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
?>