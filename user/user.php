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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php include "../lib/config.php";
          echo $title; ?> - Powered by Simpost</title>

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
          <div class="title"><span class="label">ID:</span>
            <?php
            include "userinfo.php";
            echo '<span class="badge badge-success">' . $user_id_get . '</span>'; ?>
          </div>
          <div class="title"><span class="label">邮箱:</span>
            <?php
            include "userinfo.php";
            echo $user_mail; ?></div>

          <div class="title"><span class="label">用户名:</span>
            <?php
            include "userinfo.php";
            echo $user_name; ?>
          </div>

          <div class="title"><span class="label">昵称:</span>
            <?php
            include "userinfo.php";
            echo $user_nicheng; ?></div>

          <div class="title"><span class="label">简介:</span>
            <?php
            include "userinfo.php";
            echo $jianjie; ?>
          </div>
          <div class="title"><span class="label">钱包:</span>
            <?php
            include "userinfo.php";
            echo $user_gold . '金币'; ?></div>
          <div class="title"><span class="label">权限:</span>
            <?php
            //权限
            //从paidusers获取permissions，使用username，如果存在并且permissions=1，就是vip个人版用户，否则就是普通用户，输出权限
            //注意time，如果现在的时间，在start和end之间，就是vip用户，否则就是普通用户
            //如果没有找到，就是普通用户
            $username = $_COOKIE["key"];
            $sql = "SELECT * FROM paidusers WHERE username='" . $username . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $permissions = $row["permissions"];
                $start = $row["starttime"];
                $end = $row["endtime"];
                //实际不是时间戳，是时间格式，需要转换
                $time = time();
                $start_s = strtotime($start);
                $end_s = strtotime($end);
                //权限是1
                if ($permissions == 1) {
                  if ($time > $start_s && $time < $end_s) {
                    echo '<span class="badge badge-success">VIP用户</span>';
                    //输出开始时间和结束时间
                    //距离到期还有多少天
                    $days = ($end_s - $time) / 86400;
                    //向下取整
                    $days_e = floor($days);
                   //<div class="alert alert-warning" role="alert">
                    // A simple warning alert—check it out!
                    // </div>
                    //用alert alert-warning
                    echo '<div class="alert alert-warning" role="alert">
                      VIP开始时间：<span class="badge badge-dark">' . $start . '</span>，
                      VIP到期时间：<span class="badge badge-dark">' . $end . '</span>，距离到期还有<span class="badge badge-dark">' . $days_e . '</span>天
                    </div>';

                
                  } else {
                    echo '
                    <div class="alert alert-danger" role="alert">
                      VIP已经到期，亲爱的VIP已经离你而去了，如果你还想继续使用VIP功能，请续费~
                    </div>';
                    //计算已经到期了多少天
                    $days = ($time - $end_s) / 86400;
                    //向下取整
                    $days_e = floor($days);
                    echo '<span class="badge badge-primary">已经到期' . $days_e . '天</span>';
                  }
                } else {
                  echo '<span class="badge badge-primary">普通用户</span>';
                }
              }
            } else {
              echo '<span class="badge badge-primary">普通用户</span>';
            }
            ?>
            <hr>

            <div class="alert alert-success" role="alert">
              <h4 class="alert-heading">NOTICE</h4>
              <p>头像托管于Cravatar头像服务器和Gravatar同步，如果要更改头像，请访问<a href="https://cravatar.cn/">Cravatar</a>进行更改</p>
              <hr>
              <p class="mb-0">欢迎加入官方企鹅群:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></p>
            </div>

            <hr>
          </div>
          <?php
          include("../footer.php");
          ?>
        </div>
      </div>

</body>

</html>