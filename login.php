<!DOCTYPE html>
<html lang="CN">

<head>
  <meta charset="utf-8" />
  <title><?php include "./lib/config.php";
          echo $title; ?> - Powered by Simpost</title>
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
?>

<body>

  <div class="container">

    <center>
      <div class="card" style="width: 25rem;">
        <div class="card-body">

          <form method="POST">
            <h3><b>用户登录</b></h3>
            <h4>login and upload</h4>
            <hr>
            <br>
              <input type="email" name="uname" class="form-control" placeholder="Email/邮箱地址" aria-describedby="sizing-addon2">
              <br>
              <input type="password" name="pwd" class="form-control" placeholder="PassWord/密码" aria-describedby="sizing-addon2">
            <hr>
            <input class="btn btn-info" type="submit" name="submit" value="登录/login"><br><br>
            <a href="register.php">没有账号？注册一个！</a>
            <hr>
            <a href="re_password.php">忘记密码？找回吧！</a>

          </form>
        </div>
      </div>
    </center>
    <br>
    <br>
    <br>
    <br>

    <?php
    include("./footer.php");
    ?>
  </div>
</body>

</html>
<?php
include("./lib/func.php");
loginOK();
?>
<?php
//获取内容
$user1 = $_COOKIE['key'];
if ($user1 == "") {
} else {
  Header("Location:./user/user.php");
}
?>