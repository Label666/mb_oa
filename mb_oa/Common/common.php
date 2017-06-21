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

?>	