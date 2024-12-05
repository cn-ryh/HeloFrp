<!DOCTYPE html>
<html lang="CN">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0;">
  <title><?php include "./lib/config.php";
          echo $title; ?>| 用户注册 - Powered by Simpost</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>
<?php
include("./header.php");
require("./lib/conn.php");
if ($conn->$connect_error) {
  die("Connection failed: " . $conn->$connect_error);
}

?>

<body>
  <center>

    <div class="container">
      <div class="card" style="width: 25rem;">
        <div class="card-body">
          <h3><b>用户注册</b></h3>
          <h4>register and enjoy</h4>
          <hr>
          <form method="GET">

            <input type="text" class="form-control" name="username" placeholder="用户名" value="<?php $username = $_GET['username'];
                                                                                              echo $username; ?>"><br>
            <input id="inputEmailExample1" type="email" name="mail" class="form-control" placeholder="Email" value="<?php $mail = $_GET['mail'];
                                                                                                                    echo $mail; ?>"><br>
            <input name="password" type="password" class="form-control" placeholder="密码" value="<?php $password = $_GET['password'];
                                                                        echo $password; ?>"><br>
            <input type="text" class="form-control" name="code" value="<?php $code = $_GET['code'];
                                                                        echo $code; ?>" placeholder="验证码"><br>
            <input class="btn btn-success" value="获取验证码" type="submit" name="getcode">
            <input class="btn btn-info" type="submit" name="submit"><br><br><a href="login.php">已有账号？马上登录</a>
          </form>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-body">
          我们将第一时间发布新动态，如果你需要请加入官方企鹅群:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a>
        </div>
      </div>
      <?php
      include("./footer.php");
      ?>
    </div>
</body>

</html>

<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

global $conn;
if ($_GET["submit"]) {
  $id = mt_rand(2000000, 999999999999999999);
  $username = $_GET['username'];
  $mail_1 = $_GET['mail'];
  $password = $_GET['password'];
  $codes = $_GET['code'];
  $base64_pwd = base64_encode($password);
  //-------cravatar头像服务器----------
  $address = strtolower(trim($mail_1));
  $hash = md5($address);
  $icon_url = 'https://cravatar.cn/avatar/' . $hash;
  //==================================
  $sf = "u";
  $gold = "1";
  $sql_get_code = "SELECT t.* FROM (SELECT email,max(time) as time FROM emailcode WHERE email='$mail_1' GROUP BY email ) a LEFT JOIN emailcode t ON t.email=a.email and t.time=a.time"; //这里是限制帖子
  $result_ed = $conn->query($sql_get_code);
  $rows_ed = $result_ed->fetch_assoc();
  $s_code = $rows_ed['code'];


  if (!($username and $mail_1 and $base64_pwd)) {
    echo '<script language="JavaScript">
    swal({
      title: "输入不能为空",
      text: "输入不能为空",
      icon: "error",
      button: "确定",
    });
    </script>';
    //echo "用户名" . $username . "电子邮件" . $mail_1 . "密码" . $base64_pwd;
  } else {
    if ($codes == $s_code) {
      $sqlstr_reg = "insert into register values('" . $id . "','" . $username . "','" . $mail_1 . "','" . $base64_pwd . "','" . $sf . "','" . $icon_url . "','" . $gold . "','无昵称','这个人很懒，什么也不想写~喵~') ";
      $result_reg = mysqli_query($conn, $sqlstr_reg);
      if ($result_reg) {
        echo '<script language="JavaScript">
 swal({
   title: "注册成功",
   text: "您的账号注册成功！",
   icon: "success",
   button: "确定",
 })
 .then((willDelete) => {
   location.href="./login.php";
   }
 );
 </script>';
      } else {
        echo '<script language="JavaScript">
 swal({
   title: "注册失败",
   text: "您的账号注册失败，可能存在相同的ID,EMAIL,用户名等",
   icon: "error",
   button: "确定",
 })
 .then((willDelete) => {
   location.href="./login.php";
   }
 );
 </script>';
      }
    } else {
      echo '<script language="JavaScript">
    swal({
      title: "验证码错误,
      text: "验证码错误",
      icon: "error",
      button: "确定",
    });
    </script>';
    }
  }
  //echo"$id $username $mail $password";
}

if ($_GET["getcode"]) {
  $mail_1 = $_GET['mail'];
  $sql_get_da = "SELECT t.* FROM (SELECT email,max(time) as time FROM emailcode WHERE email='$mail_1' GROUP BY email ) a LEFT JOIN emailcode t ON t.email=a.email and t.time=a.time"; //这里是限制帖子
  $result_da = $conn->query($sql_get_da);
  $rows_da = $result_da->fetch_assoc();
  $da_code = $rows_da['time'];
  $zero1 = strtotime(date('Y-m-d H:i:s')); //当前时间
  $zero2 = strtotime($da_code);
  $the60s = ($zero1 - $zero2);
  if ($the60s <= 60) {
    echo '<script language="JavaScript">
 swal({
   title: "没到时间",
   text: "没到时间！60秒内只能发送一次！",
   icon: "error",
   button: "确定",
 });
 </script>';
  } else {
    $mail_seeder = $_GET['mail'];
    require './lib/PHPMailer/src/Exception.php';
    require './lib/PHPMailer/src/PHPMailer.php';
    require './lib/PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
      include "./lib/config.php";
      $mail->SMTPOptions = array(  
    'ssl' => array(  
        'verify_peer' => false,  
        'verify_peer_name' => false,  
        'allow_self_signed' => true,  
    )  
);
      //服务器配置
      $mail->CharSet = "UTF-8"; //设定邮件编码
      $mail->SMTPDebug = 0; // 调试模式输出
      $mail->isSMTP(); // 使用SMTP
      $mail->Host = $smtp_dm; // SMTP服务器
      $mail->SMTPAuth = true; // 允许 SMTP 认证
      $mail->Username = $email_name; // SMTP 用户名  即邮箱的用户名
      $mail->Password = $psss_em; // SMTP 密码  部分邮箱是授权码(例如163邮箱)
      $mail->SMTPSecure = 'tls'; // 允许 TLS 或者ssl协议
      $mail->Port = 587; // 服务器端口 25 或者465 具体要看邮箱服务器支持
      $mail->setFrom($email_name, '何乐源码'); //发件人
      $mail->addAddress($mail_seeder, 'for you'); // 收件人
      //$mail->addAddress('ellen@example.com');// 可添加多个收件人
      $mail->addReplyTo($email_name, 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
      //$mail->addCC('cc@example.com');//抄送
      //$mail->addBCC('bcc@example.com');//密送
      //发送附件
      // $mail->addAttachment('../xy.zip');// 添加附件
      // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');// 发送附件并且重命名
      //Content
      $code = mt_rand(4000, 80000);
      $mail->isHTML(true); // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
      $mail->Subject = '何乐源码 | HeloFrp';
      $mail->Body = '<h1>欢迎使用何乐源码HeloFrp，您正在申请发送验证码，请在制定位置输入验证码，验证码涉及个人隐私，请勿泄露！</h1><br><br>本次请求时间' . date('Y-m-d H:i:s') . '<br><br><h1>你的验证码是：' . $code . '</h1><br><br>如果本次请求并非由您发起，请忽略，谢谢！';
      $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

      $mail->send();

      $time = date('Y-m-d H:i:s');
      $cookie_register = $_COOKIE['register'];
      $sqlstr_code = "insert into emailcode values('" . $code . "','" . $time . "','" . $mail_seeder . "') ";
      $result_code = mysqli_query($conn, $sqlstr_code);
      echo '<script>
			alert("邮件发送成功")
		</script>';
      //echo $code;
    } catch (Exception $e) {
      echo '<script>
			alert(">邮件发送失败：' . $mail->ErrorInfo . '")
		</script:';
    }
  }
}


?>