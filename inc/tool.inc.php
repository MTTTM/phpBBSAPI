<?php 
function skip($path,$status=0,$message,$data=array()){

    header('Content-Type:application/json; charset=utf-8');
    $arr = array('status'=>$status,'msg'=>$message,'data'=>$data);
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
  /**
   * 是否已经登录
   */
  function is_login($link){
	if(isset($_COOKIE['sfk']['name']) && isset($_COOKIE['sfk']['pw'])){
		$query="select * from skf_menber where name='{$_COOKIE['sfk']['name']}' and sha1(pw)='{$_COOKIE['sfk']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			$data=mysqli_fetch_assoc($result);
			return $data['id'];
		}else{
			return false;
		}
	}else{
		return false;
	}
}
?>