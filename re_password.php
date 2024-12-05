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

  <div class="container">
    <center>
      <div class="card" style="width: 25rem;">
        <div class="card-body">
          <h3><b>找回密码</b></h3>
          <hr>
          <h4>在这里可以找回密码</h4>
          <h4>Here you can retrieve the password</h4>
          <hr>
          <br>
          <form method="GET">
            <div class="input-group mb-3">

              <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
              </div>
              <input type="email" name="mail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" class="form-control" placeholder="Email" value="<?php $mail = $_GET['mail'];
                                                                                                                                                                              echo $mail; ?>">
            </div>

            <div class="input-group mb-3">

              <div class="input-group-prepend">
                <span class="input-group-text">新密码</span>
              </div>
              <input type="password" name="password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" class="form-control" placeholder="新的密码" value="<?php $mail = $_GET['password'];
                                                                                                                                                                                    echo $password; ?>">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">验证码</span>
              </div>
              <input type="text" name="code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" class="form-control" placeholder="验证码" value="<?php $code = $_GET['code'];
                                                                                                                                                                          echo $code; ?>">
            </div>
            <input class="btn btn-primary" value="获取验证码" type="submit" name="getcode">
            <input class="btn btn-info" value="确认找回" type="submit" name="submit"><br><br><a href="login.php">找回成功？马上登录</a>
          </form>

        </div>

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
  //获取验证码的模块
  $sql_get_code = "SELECT t.* FROM (SELECT email,max(time) as time FROM emailcode WHERE email='$mail_1' GROUP BY email ) a LEFT JOIN emailcode t ON t.email=a.email and t.time=a.time"; //这里是限制帖子
  $result_ed = $conn->query($sql_get_code);
  $rows_ed = $result_ed->fetch_assoc();
  $s_code = $rows_ed['code'];


  if (!($mail_1 and $base64_pwd)) {
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
      $sqlstr_reg = "UPDATE register SET `password` = '$base64_pwd' WHERE `register`.`mail` = '$mail_1'";
      $result_reg = mysqli_query($conn, $sqlstr_reg);
      if ($result_reg) {
        echo '<script language="JavaScript">
 swal({
   title: "找回成功",
   text: "您的账号找回成功！可以返回首页登录！",
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
   title: "找回密码失败",
   text: "您的账号找回密码失败",
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
      $mail->Subject = '何乐源码找回密码 | HeloFrp';
      $mail->Body = '<h1>欢迎使用何乐源码HeloFrp，您正在申请发送找回密码，验证码涉及个人隐私，请勿泄露！</h1><br><br>本次请求时间' . date('Y-m-d H:i:s') . '<br><br><h1>你的验证码是：' . $code . '</h1><br><br>如果本次请求并非由您发起，请忽略，谢谢！';
      $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

      $mail->send();
      $time = date('Y-m-d H:i:s');
      $cookie_register = $_COOKIE['register'];
      $sqlstr_code = "insert into emailcode values('" . $code . "','" . $time . "','" . $mail_seeder . "') ";
      $result_code = mysqli_query($conn, $sqlstr_code);
      echo '<script language="JavaScript">
 swal({
   title: "邮件发送成功",
   text: "邮件发送成功",
   icon: "success",
   button: "确定",
 });
 </script>';
      //echo $code;
    } catch (Exception $e) {
      echo '<script language="JavaScript">
      swal({
        title: "邮件发送失败",
        text: "邮件发送失败，错误代码:' . $mail->ErrorInfo . '",
        icon: "error",
        button: "确定",
      });
      </script>';
    }
  }
}


?>