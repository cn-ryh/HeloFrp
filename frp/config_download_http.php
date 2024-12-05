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
<!-- 提示下载配置页面 -->
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">HeloFrp 需要搭配官方的启动器使用</h4>
  <p>购买隧道请加入官方QQ群聊<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></h2>
    我们建议试用免费服务后，确保服务质量能满足您的需求后再购买<br>
    请清楚我们节点的配置后再进入创建页面，不符规则的端口将不会被映射[也会被创建]<br>
    使用表示同意我们的用户协议</p>
  <hr>
  <p class="mb-0">如果你需要请加入官方企鹅群[点击号码加入]:<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451</a></p>
</div>
<?php
//从server表获取数据id sevname ip permissions description port
//这个id是get参数,通过id获取数据，然后生成ini文件下载
//查询数据库的时候where id = $_GET["id"]

//先get id
$id = $_GET["id"];

//获取我的权限，先去paidusers里面寻找
global $permissions;
$username = $_COOKIE["key"];
$sql = "SELECT * FROM paidusers WHERE username='" . $username . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
         $nowtime = time();
                $starttime = strtotime($row["starttime"]);
        $endtime = strtotime($row["endtime"]);
        if($nowtime > $starttime && $nowtime < $endtime){
        $permissions = $row["permissions"];
        }else{
            $permissions = "u";
        }
    }
} else {
    $permissions = "u";
}
//获取此id下的服务器数据，先判断权限，u权限可以获取u的，1权限可以获取u和1的
global $sql_frp_server;
if ($permissions == "u") {
    $sql_frp_server = "SELECT * FROM server WHERE permissions='u' AND id='" . $id . "'";
} else {
    $sql_frp_server = "SELECT * FROM server WHERE id='" . $id . "'";
}

$result_frp_server = $conn->query($sql_frp_server);
if ($result_frp_server->num_rows > 0) { //遍历目录
    while ($row_server = $result_frp_server->fetch_assoc()) {
        $sevname = $row_server['sevname'];
        $ip = $row_server['ip'];
        $port = $row_server['port'];
        $description = $row_server['description'];
        //输出的时候需要留有创建的输入框和选择框，选择框是选择tcp/udp隧道还是http/https隧道
        //当选择框是tcp/udp时是本地端口，本地ip，远程端口
        //当选择框是http/https时是本地端口，本地ip，域名
        //然后生成ini文件下载
        //$local_ip = $_GET["local_ip"];
        $local_port = $_GET["local_port"];
        $custom_domains = $_GET["custom_domains"];

        echo '<div class="card">
    <div class="card-header">
      创建隧道
    </div>
    <div class="card-body">
      <h5 class="card-title">服务器名：' . $sevname . '</h5>
      <p class="card-text">服务器IP：' . $ip . '</p>
      <p class="card-text">服务器端口：' . $port . '</p>
      <p class="card-text">服务器描述：' . $description . '</p>
      <form action="config_download_tcp.php" method="get">
      <div class="form-group">
        <label for="local_port">本地端口</label>
        <input type="text" class="form-control" id="local_port" name="local_port" placeholder="本地端口" value="'.$local_port.'">
      </div>
      <div class="form-group">
        <label for="remote_port">绑定域名</label>
        <input type="text" class="form-control" id="custom_domains" name="custom_domains" placeholder="域名" value="'.$custom_domains.'">
      </div>
      <div class="form-group">
        <label for="protocol">协议</label>
        <select class="form-control" id="protocol" name="protocol">
          <option value="http">HTTP</option>
          <option value="https">HTTPS</option>
        </select>
      </div>
      <input type="hidden" name="id" value="' . $id . '">
      <button type="submit" class="btn btn-primary">创建</button>
    </form>
    </div>
  </div>';
  //生成配置文件
  //生成ini文件
  //ini文件格式
// [common]
// server_addr = xgp.furme.top
// server_port = 7000
// user = aaa
// metatoken = bbb

// [ssh]
// type = tcp
// local_port = 22
// remote_port = 6000

//随机文本字符替换[ssh]，账号密码从数据库获取
//用户名
$username = $_COOKIE['key'];
global $password;
//从register获取账号密码，密码需要base64解密
$sql = "SELECT * FROM register WHERE username='" . $username . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $password = base64_decode($row["password"]);
    }
  }
  //生成ini文件
  $ini = "
  [common]
  server_addr = " . $ip . "
  server_port = " . $port . "
  user = " . $username . "
  meta_token = " . $password . "
  
  [ssh]
  type = " . $_GET["protocol"] . "
  local_port = " . $_GET["local_port"] . "
  custom_domains = " . $_GET["custom_domains"] . "";
  //红色的警告提示，提示用户剪贴板复制里面包含账号密码，请不要泄露
  echo '<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">警告</h4>
  <p>请不要泄露配置文件里面的账号密码</p>
  <hr>
  <p class="mb-0">请不要泄露配置文件里面的账号密码，这是您的账号密码，泄露后可能会被盗用，请妥善保管您的信息</p>
</div>';
  //输出到card里面，点击按钮复制到剪贴板
  echo '
  <div class="card">
  <div class="card-header">
    配置文件
  </div>
  <div class="card-body">
    <h5 class="card-title">配置文件</h5>
    <p class="card-text">请复制到剪贴板</p>
    <textarea class="form-control" id="ini" rows="13">' . $ini . '</textarea>
    <button class="btn btn-primary" onclick="copyToClipboard()">复制</button>
  </div>
</div>';
  //js复制到剪贴板事件，点击按钮复制
  echo '<script>
  function copyToClipboard() {
    var copyText = document.getElementById("ini");
    copyText.select();
    document.execCommand("copy");
    swal("复制成功", "已经复制到剪贴板", "success");
  }
  </script>';

    }

} else {
    echo '<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">服务器</h4>
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