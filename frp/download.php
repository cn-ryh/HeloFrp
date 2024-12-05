<?php
include("../lib/func.php");
safety();
?>
<!DOCTYPE html>
<html lang="CN">

<head>
  <meta charset="utf-8" />
  <title>
    <?php include "../lib/config.php";
    echo $title; ?> 创建隧道 - Powered by Simpost
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>

<?php
include("../header-sec.php");
?>


<div class="container">

  <div class="alert alert-success" role="alert">
    <h4 class="alert-heading">HeloFrp 推荐从本网站下载启动器使用</h4>
    我们建议试用免费服务后，确保服务质量能满足您的需求后再购买<br>
    使用表示同意我们的用户协议<br>
    如果你需要请加入官方企鹅群[点击号码加入]:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a>
  </div>


  <div class="card">
    <div class="card-header">
      Windows
    </div>
    <div class="card-body">
      <a class="btn btn-dark" href="./down/frp_0.51.0_windows_386.zip">下载启动器/windows_386</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_windows_amd64.zip">下载启动器/windows_amd64</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_windows_arm64.zip">下载启动器/windows_arm64</a>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header">
      freebsd
    </div>
    <div class="card-body">
      <a class="btn btn-dark" href="./down/frp_0.51.0_freebsd_386.zip">下载启动器/freebsd_386</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_freebsd_amd64.zip">下载启动器/freebsd_amd64</a>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header">
      linux
    </div>
    <div class="card-body">
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_386.zip">下载启动器/linux_386</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_amd64.zip">下载启动器/linux_amd64</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_arm64.zip">下载启动器/linux_arm64</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_arm.zip">下载启动器/linux_arm32</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_mips64le.zip">下载启动器/linux_mips64le</a>
      <hr>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_mipsle.zip">下载启动器/linux_mipsle</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_linux_riscv64.zip">下载启动器/linux_riscv64</a>
    </div>
  </div>
  <br>

  <div class="card">
    <div class="card-header">
      MacOS
    </div>
    <div class="card-body">
      <a class="btn btn-dark" href="./down/frp_0.51.0_darwin_arm64.zip">下载启动器/darwin_arm64</a>
      <a class="btn btn-dark" href="./down/frp_0.51.0_darwin_amd64.zip">下载启动器/darwin_amd64</a>
    </div>
  </div>
  <br>
  <hr>


  <?php
  include("../footer.php");
  ?>

</div>
</div>
</body>

</html>