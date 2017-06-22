<?php

	header("content-type:text/html;charset=utf-8");
	class labelUtils{

		/**连接数据库的方法
		*/
		static function connectDB(){
			$hostName='43.248.133.138';
			$userName='mysql1705190dd0';
			$passWorld='Lb123456';
			$dbName='mysql1705190dd0_db';

			$mysqli=new mysqli($hostName,$userName,$passWorld,$dbName);
			if($mysqli->connect_errno){
				die('数据库连接失败:'.$mysqli->connect_error);
			}
			else{
				$mysqli->set_charset('utf8');
				return $mysqli;
			}
		}
	}
	
?>