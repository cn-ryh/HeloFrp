<?php
include("../lib/func.php");
islogin_second();
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

<?php
//公告
$sql_frp_gonggao = "SELECT * FROM gonggao";
$result_frp_gonggao = $conn->query($sql_frp_gonggao);
if ($result_frp_gonggao->num_rows > 0) { //遍历目录
  while ($row_gonggao = $result_frp_gonggao->fetch_assoc()) {
    $gongao = $row_gonggao['goggao'];
    //echo $gongao;
    echo '<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">公告</h4>
  '.$gongao.'
</div>';
    
  }
} else {
  echo '<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">公告</h4>
  <p>没有公告！<br></p>
</div>';
}
?>
<hr>
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">HeloFrp 推荐从本网站下载启动器使用</h4>
  <p>购买隧道请加入官方QQ群聊<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></h2>
    我们建议试用免费服务后，确保服务质量能满足您的需求后再购买<br>
    使用表示同意我们的用户协议</p>
  <hr>
  <p class="mb-0">如果你需要请加入官方企鹅群[点击号码加入]:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></p>
</div>
<hr>
<!-- 体验版服务器栏目 -->

<?php
//从server表获取数据id sevname ip permissions description port，然后输出，同时生成一个按钮，通过获取的id，
//然后跳转到ini文件下载页面config_download.php
//这个id是get参数

//首先列出权限permissions为u的服务器
$sql_frp_server = "SELECT * FROM server WHERE permissions='u'";
$result_frp_server = $conn->query($sql_frp_server);
if ($result_frp_server->num_rows > 0) { //遍历目录
  while ($row_server = $result_frp_server->fetch_assoc()) {
    $id = $row_server['id'];
    $sevname = $row_server['sevname'];
    $ip = $row_server['ip'];
    $port = $row_server['port'];
    $description = $row_server['description'];
    echo '<div class="alert alert-primary" role="alert">
  <h4 class="alert-heading">体验版 | 服务器</h4>         
  <p>服务器名：'.$sevname.'<br>服务器描述：'.$description.'<br></p>
  <a href="config_download_tcp.php?id='.$id.'" class="btn btn-primary">生成tcp/udp配置文件</a>
  <a href="config_download_http.php?id='.$id.'" class="btn btn-primary">生成http/https配置文件</a>
</div>';
    
  }
} else {
  echo '<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">服务器</h4>
  <p>没有服务器！<br></p>
</div>';
}

$sql_frp_server = "SELECT * FROM server WHERE permissions='1'";
$result_frp_server = $conn->query($sql_frp_server);
if ($result_frp_server->num_rows > 0) { //遍历目录
  while ($row_server = $result_frp_server->fetch_assoc()) {
    $id = $row_server['id'];
    $sevname = $row_server['sevname'];
    $ip = $row_server['ip'];
    $port = $row_server['port'];
    $description = $row_server['description'];
    echo '<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">个人版版 | 服务器</h4>         
  <p>服务器名：'.$sevname.'<br>服务器描述：'.$description.'<br></p>
  <a href="config_download_tcp.php?id='.$id.'" class="btn btn-primary">生成tcp/udp配置文件</a>
  <a href="config_download_http.php?id='.$id.'" class="btn btn-primary">生成http/https配置文件</a>
</div>';
    
  }
} else {
  echo '<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">个人版服务器</h4>
  <p>没有服务器！<br></p>
</div>';
}




?>

<?php
include("../footer.php");
?>
  <!-- Content here -->
  </div>
</body>

</html>