<?php
	
	//验证信息发送（阿里大于）
	require('./mb_oa/Lib/Action/TopSdk.php');


	/*
		用户系统模块
	*/
	class registerAction extends Action{

		/*
		*发送验证消息的方法
		*/
		public function sendMessage(){
			$mobile=$_POST['mobile'];

			// $check_sql="select * from mb_user where mobile = '{$mobile}';";

			// 	//已经注册用户不再重复发送
			// 	$check=$mysqli->query($check_sql);
			// 	if($check&&$check->num_rows>0){
			// 		$result=getJsonResult('400','用户已经注册',null);
			// 		echo $result;
			// 		return;
			// 	}

			$c = new TopClient;
			$c->appkey = '24299362';
			$c->secretKey = 'faf3616419555d330a75d142fcce584e';
			$req = new AlibabaAliqinFcSmsNumSendRequest;
			$req->setExtend("");
			$req->setSmsType("normal");
			$req->setSmsFreeSignName("小贝测试");
			$randomCode=rand(100000,999999);
			$req->setSmsParam("{\"randomCode\":\"$randomCode\"}");
			$req->setRecNum($mobile);
			$req->setSmsTemplateCode("SMS_34735258");
			$resp = $c->execute($req);

			// print_r($resp);
			//保存数据到session(用户的验证码和验证码有效时间)
			if($resp->result->success){
				session_start();
				$_SESSION["$mobile"]=array('randomCode'=>$randomCode,'msgTime'=>time()+1800);
				print_r($_SESSION);
			}
		}



		/*
		用户注册

		*/
		public function register(){
			$mobile = $_POST['mobile'];
			$identity = $_POST['identity'];
			$passwd = $_POST['passwd'];
			// $restult=getJsonResult('200','成功',array('mobile'=>'15692162001','nickname'=>'xiaobei'));
			// echo $restult;

			$passwd=md5($passwd);
			$mysqli=@connectDB();
			if(isset($mysqli)){
				$check_sql="select * from mb_user where mobile = '{$mobile}';";

				//已经注册
				$check=$mysqli->query($check_sql);
				if($check&&$check->num_rows>0){
					$result=getJsonResult('400','用户已经注册',null);
					echo $result;
					return;
				}

				//新用户注册
				$add_sql="insert into mb_user(mobile,passwd,createtime) values ('{$mobile}','{$passwd}',now());";
				$insert=$mysqli->query($add_sql);
				if($insert){
					$user_id=$mysqli->insert_id;

					$content=array('user_id'=>$user_id);
					$result=getJsonResult('200','注册成功',$content);
				}
				else{
					$errmsg=$mysqli->error;
					$restult=getJsonResult('400','注册失败',$errmsg);
				}

				echo $result;
			}
		}


		/**用户登录
		*/
		public function login(){
			$mobile = $_POST['mobile'];
			$identity = $_POST['identity'];
			$passwd = $_POST['password'];
			$passwd=md5($passwd);
			$mysqli=@connectDB();
			
			session_start();
			print_r($_SESSION);
			//快捷登录
			if(isset($identity)&&!empty($identity)){
				
				$date=$_SESSION["$mobile"];
				echo "保存的验证码：".$date['randomCode'];
				echo "<br/>";
				echo "输入的验证码".$identity;
				echo "<br/>";
				echo "手机号：".$mobile;
				if(identity==$date['randomCode']){
					if(date['msgTime']>time()){
						//创建或获取用户
						echo getJsonResult('200','登录成功',null);
					}
					else{
						echo getJsonResult('400','验证码失效',null);
					}
				}
				else{
					echo getJsonResult('400','验证码错误',null);
				}
				return;
			}

			//账号密码登录(通过)
			if(isset($passwd)){
				$searchsql="select passwd from mb_user where mobile = '{$mobile}';";
				$search=$mysqli->query($searchsql);
				if($search&&$search->num_rows>0){
					$date=$search->fetch_all(MYSQLI_ASSOC);
					
					if($passwd==$date[0]['passwd']){
						echo getJsonResult('200','登录成功',null);
					}
					else{
						echo getJsonResult('400','账号或密码错误',null);
					}
				}
				if($search->num_rows==0){
					echo getJsonResult('400','该号码尚未注册',null);
				}

				$search->free();
			}
		}




	}
?>