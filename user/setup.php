<?php
include("../lib/func.php");
islogin_second();
user_setup();
safety();
?>
<!DOCTYPE html>
<html lang="CN">

<head>
  <meta charset="utf-8">
  <title><?php include "../lib/config.php";
          echo $title; ?> | 设置 - Powered by Simpost</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>

<body>
  <?php
  include("../header-sec.php");
  ?>

  <br>
  <div class="container">
    <div class="layui-row">
      <?php
      include "userinfo.php";
      $icon = $user_icon;
      echo '<center><img width="130px" height="130px" style="box-shadow: 3px 2px 10px; border-radius:24px;" class="img-circle" src=' . $icon . '></center>';
      ?>
      <br>
      <div class="container">
        <div class="card">

          <form method="post">
            <div class="title"><span class="label">ID:</span>
              <?php
              include "userinfo.php";
              echo '<span class="badge badge-dark">' . $user_id_get . '</span>'; ?>
            </div>
            <div class="title"><span class="label">邮箱:</span>
              <input type="email" name="mail" class="form-control" value="<?php
                                                                          include "userinfo.php";
                                                                          echo $user_mail; ?>">
            </div>

            <div class="title"><span class="label">用户名:</span>
              <?php
              include "userinfo.php";
              echo $user_name; ?>
            </div>

            <div class="title"><span class="label">昵称:</span>
              <input type="text" class="form-control" name="nc" value="<?php
                                                                        include "userinfo.php";
                                                                        echo $user_nicheng; ?>">
            </div>

            <div class="title"><span class="label">简介:</span>
              <input type="text" class="form-control" name="jianjie" value="<?php
                                                                            include "userinfo.php";
                                                                            echo $jianjie; ?>" rows="3">
            </div>
            <hr>
            <center><input class="btn btn-danger" type="submit" name="submit" value="修改信息"></center>
          </form>
          <br>
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">NOTICE</h4>
            <p>头像托管于Cravatar头像服务器和Gravatar同步，如果要更改头像，请访问<a href="https://cravatar.cn/">Cravatar</a>进行更改</p>
            <hr>
            <p class="mb-0">欢迎加入官方企鹅群:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></p>
          </div>

          <hr>
          <?php

          include("../footer.php");
          ?>
        </div>
      </div>

</body>

</html>
