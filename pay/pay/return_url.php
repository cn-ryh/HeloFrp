<?php
/* * 
 * 功能：彩虹易支付页面跳转同步通知页面
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

require_once("lib/epay.config.php");
require_once("lib/EpayCore.class.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付返回页面</title>
	</head>
	<body>
<?php
//计算得出通知验证结果
$epay = new EpayCore($epay_config);
$verify_result = $epay->verifyReturn();

if($verify_result) {//验证成功

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

	//支付方式
	$type = $_GET['type'];


	if($_GET['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//如果有做过处理，不执行商户的业务程序

		//获取用户名
		$myself = $_COOKIE["key"];
		//获取时间
		$time = $_COOKIE["time"];
		//处理时间，时间包括one，three，year，现在的时间的基础上加即可
		//它包括开始时间和结束时间
		
		//获取当前时间为开始时间
		$begin = date("Y-m-d H:i:s");
		//获取结束时间
		global $end;
		if($time == "one"){
			$end = date("Y-m-d H:i:s",strtotime("+1 month"));
			echo $end;
		}
		else if($time == "three"){
			$end = date("Y-m-d H:i:s",strtotime("+3 month"));
		}
		else if($time == "year"){
			$end = date("Y-m-d H:i:s",strtotime("+1 year"));
		}

		//写入数据库paidusers表包括id username	permissions	starttime	endtime四个字段
		//连接数据库
		require("../../lib/conn.php");
			if ($conn->$connect_error) {
 		 die("Connection failed: " . $conn->$connect_error);
		}
		//写入数据库，id是随机字符
		$id = md5(uniqid());
		//先判断是否已经存在该用户，如果存在则更新(UPLOAD)会员时间，如果不存在则插入新的会员(INSERT)
		$sql = "SELECT * FROM paidusers WHERE username = '$myself'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0) {
		    echo "第一次开通会员";
			$sql = "INSERT INTO paidusers (id, username, permissions, starttime, endtime) VALUES ('$id', '$myself', '1', '$begin', '$end')";
			$result = mysqli_query($conn, $sql);
			//输出结果是否成功
			if (!$result) {
				printf("Error: %s\n", mysqli_error($conn));
				exit();
			}else{
				echo "获取数据成功";
			}
		}else {
			//存在用户则更新开始时间和结束时间
			echo "存在用户";
			$sql = "UPDATE paidusers SET starttime = '$begin', endtime = '$end' WHERE username = '$myself'";
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				printf("Error: %s\n", mysqli_error($conn));
				exit();
			}else{
				echo "获取数据成功";
			}
		}
	
		$conn->close();
		//注销cookie
		setcookie("time", "", time()-3600);
		//setcookie("permissions", "", time()-3600);
	}else {
		echo "trade_status=".$_GET['trade_status'];
	}

	echo "<h3>感谢您的购买，您现在可以返回主页去查看你的会员</h3><br/>";
}
else {
	//验证失败
	echo "<h3>验证失败，请重试！</h3>";
}
?>
	</body>
</html>