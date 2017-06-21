<?php
	class registerAction extends Action{

		/*
		*发送验证消息的方法
		*/
		public function sendMessage(){
			hello();
		}

		/*
		用户注册
		*/
		public function register(){
			$mobile = $_GET['mobile'];
			$identity = $_GET['identity'];
			$passworld = $_GET['passworld'];

			/*操作数据库*/
			echo "mobile:".$mobile;
			echo "identity:".$identity;
			echo "passworld:".$passworld;


			$restult=getJsonResult('200','成功',array('mobile'=>'15692162001','nickname'=>'xiaobei'));
			echo $restult;
		}

	}
?>