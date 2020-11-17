<?php 
	include_once '../inc/config.inc.php';
	include_once '../inc/mysqli.inc.php';
	include_once '../inc/tool.inc.php';
	$link=connect();
   
    $result_obj=array();
    $father_count_today=0;
    $father_count_all=0;
    if(isset($_GET['id'])){
        $query="select * from sfk_son_module where father_module_id={$_GET['id']}";
        $result_son=execute($link, $query);
        $result_obj=mysqli_fetch_all($result_son,MYSQLI_ASSOC);
            foreach ($result_obj as $key => $value) {
                $data_father=$value;
                $query="select * from sfk_son_module where father_module_id={$data_father['id']}";
                $result_son=execute($link, $query);
                if(mysqli_num_rows($result_son)){
                        while ($data_son=mysqli_fetch_assoc($result_son)){
                            $query="select count(*) from sfk_content where module_id={$data_son['id']} and time > CURDATE()";
                            $count_today=num($link,$query);
                            $query="select count(*) from sfk_content where module_id={$data_son['id']}";
                            $count_all=num($link,$query);
                            $result_obj[$key]['count_today']=$count_today;
                            $result_obj[$key]['count_all']=$count_all;
                            $father_count_today+=$count_today;
                            $father_count_all+=$count_all;
                        }
                }else{
                    $result_obj[$key]['count_today']=0;
                    $result_obj[$key]['count_all']=0;
                }
            }
    }
    else{
        $query="select * from sfk_fatcher_module order by sort desc";
        $result_father=execute($link, $query);
        $result_obj=mysqli_fetch_all($result_father,MYSQLI_ASSOC);
        foreach ($result_obj as $key => $value) {
            $data_father=$value;
            // var_dump($data_father);
            $query="select * from sfk_son_module where father_module_id={$data_father['id']}";
            $result_son=execute($link, $query);
            if(mysqli_num_rows($result_son)){
                while ($data_son=mysqli_fetch_assoc($result_son)){
                    $query="select count(*) from sfk_content where module_id={$data_son['id']} and time > CURDATE()";
                    $count_today=num($link,$query);
                    $query="select count(*) from sfk_content where module_id={$data_son['id']}";
                    $count_all=num($link,$query);
                    $result_obj[$key]['count_today']=$count_today;
                    $result_obj[$key]['count_all']=$count_all;
                    $father_count_today+=$count_today;
                    $father_count_all+=$count_all;
                }
            }else{
                $result_obj[$key]['count_today']=0;
                $result_obj[$key]['count_all']=0;
            }
        }
    }
    
    skip(__FILE__,0,'获取成功',
        array(
            'list'=>$result_obj,
            'count_today'=>$father_count_today,
            'count_all'=>$father_count_all
        )
    );
?>

