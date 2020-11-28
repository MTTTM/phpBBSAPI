<?php 
include_once 'inc/tool.inc.php';
if(isPost()){
	include 'inc/check_install.inc.php';
	$query=array();
	$query['sfk_content']="
		CREATE TABLE IF NOT EXISTS `sfk_content` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `module_id` int(10) unsigned NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `content` text NOT NULL,
		  `time` datetime NOT NULL,
		  `member_id` int(10) unsigned NOT NULL,
		  `times` int(10) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['sfk_fatcher_module']="
		CREATE TABLE IF NOT EXISTS `sfk_fatcher_module` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `module_name` varchar(66) NOT NULL,
		  `sort` int(11) DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='父版块信息表' AUTO_INCREMENT=1;	
	";
	$query['sfk_info']="
		CREATE TABLE IF NOT EXISTS `sfk_info` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `keywords` varchar(255) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['sfk_manage']="
		CREATE TABLE IF NOT EXISTS `sfk_manage` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `pw` varchar(32) NOT NULL,
		  `create_time` datetime NOT NULL,
		  `level` tinyint(4) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;		
	";
	$query['sfk_menber']="
		CREATE TABLE IF NOT EXISTS `sfk_menber` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `pw` varchar(32) NOT NULL,
		  `photo` varchar(255) NOT NULL,
		  `register_time` datetime NOT NULL,
		  `last_time` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;
	";
	$query['sfk_reply']="
		CREATE TABLE IF NOT EXISTS `sfk_reply` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `content_id` int(10) unsigned NOT NULL,
		  `quote_id` int(10) unsigned NOT NULL DEFAULT '0',
		  `content` text NOT NULL,
		  `time` datetime NOT NULL,
		  `member_id` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['sfk_son_module']="
		CREATE TABLE IF NOT EXISTS `sfk_son_module` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `father_module_id` int(10) unsigned NOT NULL,
		  `module_name` varchar(66) NOT NULL,
		  `info` varchar(255) NOT NULL,
		  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
		  `sort` int(10) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	foreach ($query as $key=>$val){
		mysqli_query($link,$val);
		if(mysqli_errno($link)){
            skip(__FILE__,1,"数据表 {$key} 创建失败，请检查数据库账户是否有创建表的权限！");
			exit();
		}
	}
	$query_info_s="select * from sfk_info where id=1";
	$result=mysqli_query($link, $query_info_s);
	if(mysqli_num_rows($result)!=1){
		$query_info_i="INSERT INTO `sfk_info` (`id`, `title`, `keywords`, `description`) VALUES(1, 'sfkbbs', '私房库', '私房库');";
		mysqli_query($link,$query_info_i);
		if(mysqli_errno($link)){
            skip(__FILE__,1,'数据库sfk_info写入数据失败请检查相应权限!');
		}
	}
	$query_manage_s="select * from sfk_manage where name='admin'";
	$result=mysqli_query($link, $query_manage_s);
	if(mysqli_num_rows($result)!=1){
		$query_manage_i="INSERT INTO `sfk_manage` (`name`, `pw`, `create_time`, `level`) VALUES('admin',md5('{$_POST['manage_pw']}'),now(), 0)";
		mysqli_query($link,$query_manage_i);
		if(mysqli_errno($link)){
            skip(__FILE__,1,'管理员创建失败，请检查数据表sfk_manage是否具有写权限!');
		}
    }
    $filename='inc/config.inc.php';
	$str_file=file_get_contents($filename);
	$pattern="/'DB_HOST',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_host']=addslashes($_POST['db_host']);
		$str_file=preg_replace($pattern,"'DB_HOST','{$_POST['db_host']}')", $str_file);
	}
	$pattern="/'DB_USER',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_user']=addslashes($_POST['db_user']);
		$str_file=preg_replace($pattern,"'DB_USER','{$_POST['db_user']}')", $str_file);
	}
	$pattern="/'DB_PASSWORD',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_pw']=addslashes($_POST['db_pw']);
		$str_file=preg_replace($pattern,"'DB_PASSWORD','{$_POST['db_pw']}')", $str_file);
	}
	$pattern="/'DB_DATABASE',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_database']=addslashes($_POST['db_database']);
		$str_file=preg_replace($pattern,"'DB_DATABASE','{$_POST['db_database']}')", $str_file);
	}
	$pattern="/\('DB_PORT',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_port']=addslashes($_POST['db_port']);
		$str_file=preg_replace($pattern,"('DB_PORT',{$_POST['db_port']})", $str_file);
	}
	if(!file_put_contents($filename, $str_file)){
        skip(__FILE__,1,'配置文件写入失败，请检查config.inc.php文件的权限!');
	}
	if(!file_put_contents('inc/install.lock',':))')){
        skip(__FILE__,1,'文件inc/install.lock创建失败，但是您的系统其实已经安装了，您可以手动建立inc/install.lock文件!');
    }
    skip(__FILE__,1,'安装成功，');
}
else{
	skip(__FILE__,1,'请使用post方式');
}
?>