<?php


	function hello(){
		echo "hello";
	}


	/*
		生成的结果组合成json
		$code:错误码  200：成功   400：
		$msg:提示信息
		$content:返回的数据
	*/
	function getJsonResult($code,$msg,$content){
		$arr= array('code'=>$code,'msg'=>$msg,'content'=>$content);
		$result=json_encode($arr);
		return $result;
	}


	/**连接数据库的方法
		*/
		function connectDB(){
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

?>	