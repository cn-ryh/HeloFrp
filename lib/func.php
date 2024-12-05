<?php
require("conn.php");
if ($conn->$connect_error) {
  die("Connection failed: " . $conn->$connect_error);
}
$user = $_COOKIE['key'];
function index_get_tie()
{

  global $conn;
  global $from;
  global $end;
  global $page_get;
  $page_get = $_COOKIE["page"];
  if ($_POST["shang"]) { //上一页
    $new_page_get = $page_get - 1;
    setcookie("page", $new_page_get, "");
    if ($new_page_get <= 0) {
      setcookie("page", "1", "");
      Header("Location:./index.php"); //刷新
    }
    Header("Location:./index.php"); //刷新
  }
  if ($_POST["xia"]) { //下一页
    $page_get_xia = $_COOKIE["page"];
    $new_page_get_xia = $page_get_xia + 1; //加一就行
    setcookie("page", $new_page_get_xia, "");
    Header("Location:./index.php"); //刷新

  }
  if ($page_get == NULL) { //如果为空，自动设置为1
    setcookie("page", "1", "");
    Header("Location:./index.php"); //刷新
  }
  if ($page_get == "1") { //前端限制不允许访问前面
    $from = 0;
    $end = 5;
  } else {
    //等差数列
    $from = $page_get * 5 - 4; //起始
    $end = $page_get * 5; //终止
  }
  if ($_POST["number"]) {
    $number = $_POST["number"];
    setcookie("page", $number, "");
    Header("Location:./index.php"); //刷新
  }
  if ($page_get > "10") { //不允许查看10页以后的内容
    setcookie("page", "10", "");
    echo '<script language="JavaScript">
swal({
  title: "我们不允许查看10页以后的内容",
  text: "请自行搜索相关内容，首页只展示10页",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
  location.href="./index.php";
}
);
</script>';
  }
  //终止判断
  $sql_num_get_1 = "SELECT COUNT(*) FROM tie"; //输入表
  $result_num_get_1 = $conn->query($sql_num_get_1);
  $row_num_get_1 = $result_num_get_1->fetch_row();
  //echo $row_num_get_1[0];//调试输出行数
  $num_row_get_2 = $row_num_get_1[0];
  $page_num_ax = $num_row_get_2 / 5; //获得页数
  //echo Ceil($page_num_ax);//向上取整
  //echo $page_get;//调试页数
  if (Ceil($page_num_ax) >= $page_get) { //比较输入
  } else {
    setcookie("page", $page_get - 1, "");
    //Header("Location:./index.php");
    echo '<script language="JavaScript">
swal({
  title: "后面没有页面啦！",
  text: "后面没有页面啦，往前看看吧！",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
  location.href="./index.php";
}
);
</script>';
  }
  $sql = "SELECT * FROM tie order by time desc limit $from,$end"; //这里是限制帖子
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { //遍历目录
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['title'];
      $code = $row['tid'];
      $time = $row['time'];
      $icon = $row['icon'];
      $neirong = $row['neirong'];
      $sql_co_tids_index = "SELECT COUNT(*) FROM likes WHERE tid='$code'";
      $result_tids_index = $conn->query($sql_co_tids_index);
      $row_tids_index = $result_tids_index->fetch_row();
      $sub = substr($neirong, 0, 270);
      echo '
<div class="layui-card" >
<div class="layui-card-body" style="box-shadow: 1px 1px 4px; border-radius:24px;">
<div class="layui-container">  
<div class="layui-row">
  <div class="layui-col-md3">
<a href="./user/user_center.php?name=' . $names . '"><img width="60px" height="60px" style="box-shadow: 3px 2px 10px; border-radius:24px;" src=' . $icon . '></a><br>
ID:' . $code . '<br>
帖子作者:' . $names . '<br>
发帖时间:' . $time . '<br>
<h3><i class="layui-icon layui-icon-heart-fill"></i> 点赞:' . $row_tids_index[0] . '</h3>
  </div>
  <div class="layui-col-md9">
  <div class="layui-fluid">
  <h2><a href="./tie.php?tid=' . $code . '">' . $title . '</a></h2><br><hr>
  <div class="layui-panel">
  <div style="padding: 30px;"><p style="white-space:normal; word-break:break-all;overflow:hidden;"><a href="./tie.php?tid=' . $code . '">' . $sub . '......</a></p></div>
</div>  
<br>
  </div>
  </div>
</div>


</div>
</div>

<hr>';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
          <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}
function exit_username()
{
  setcookie("key", "", "");
  setcookie("password", "", "");
  echo '<script language="JavaScript">
swal({
  title: "已经退出登录",
  text: "已经退出登录！",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
    location.href="../index.php";
  }
);
</script>';
  exit();
}

function getPic() //获取图片
{
  global $conn;
  $sql = "SELECT * FROM pic";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { //遍历
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['pic-name'];
      $link = $row['pic-link'];
      $id = $row['pic-id'];
      $icon = $row['icon'];
      $time = $row['data'];
      echo '      
<div class="layui-col-md4">
  <div class="layui-card">
  <div class="layui-card-header"><h2>' . $title . '</h2></div>
  <div class="layui-card-body">
  <div class="layui-anim layui-anim-scale"><img src="' . $link . '" width="300" higth="300" style="border-radius:24px;"><br></div>
  <hr>
  <span class="layui-badge layui-bg-orange">' . $time . '</span><br>
  <i class="layui-icon layui-icon-layer"> 用户名/user:</i><span class="layui-badge layui-bg-blue">' . $names . '</span><br>
  <i class="layui-icon layui-icon-fonts-code"> id:</i><span class="layui-badge layui-bg-black">' . $id . '</span><br>
  </div>
</div>
</div>
    ';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
            <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function upload_Pict() //上传图片
{
  global $user;
  $title = $_POST["title"];
  //===========================
  if ($_POST["submit"]) {
    if ($user == "") {
      echo '<script language="JavaScript">
    swal({
      title: "登录后您才能发布帖子",
      text: "只有您登录后您才能发布帖子，请登录",
      icon: "error",
      button: "确定",
    })
    .then((willDelete) => {
        location.href="./login.php";
      }
    );
    </script>';
    } else if ($title == null) {
      echo '<script language="JavaScript">
    swal({
      title: "标题未输入",
      text: "只有您输入话题后才可以发布本文章",
      icon: "error",
      button: "确定",
    });
    </script>';
    } else {
      include "userinfo.php";
      //$id=md5(uniqid());
      $icon = $user_icon;
      $name_user = $user_name;
      $time = date("Y-m-d H:i:s");
      $shangchuan = $_FILES['file'];
      if ($shangchuan['type'] == "image/jpg" or $shangchuan['type'] == "text/plain") {
        echo '失败--类型不符';
        die();
      }
      if ($shangchuan['size'] > 8 * 1024 * 1024 * 1024) {
        echo '失败--大小不符';
        die();
      }
      $name = md5(date("Y/m/d") . $shangchuan['name'] . uniqid() . rand(100, 50000000000));
      copy($shangchuan['tmp_name'], './upload-pic/' . $name . '.png');
      echo '输出：成功';
      $link = './upload-pic/' . $name . '.png';
      $sqlstr_pic = "insert into pic values('" . $name_user . "','" . $title . "','" . $link . "','" . $name . "','" . $time . "','" . $icon . "') ";
      $result_pic = mysqli_query($conn, $sqlstr_pic);
      if ($result_pic) {
        echo '<script language="JavaScript">
      swal({
        title: "文章发布成功",
        text: "您的文章已经发布成功\n您可以在首页看到这篇文章的全部！",
        icon: "success",
        button: "确定",
      })
      .then((willDelete) => {
          location.href="./index.php";
        }
      );
      </script>';
      } else {
        echo '<script language="JavaScript">
      swal({
        title: "文章发布失败",
        text: "您的文章已经发布失败\n",
        icon: "error",
        button: "确定",
      });
      </script>';
      }
    }
  }
}


function Write()
{
  global $conn;
  global $user;
  $title = $_POST["title"];
  $edit = $_POST["show"];

  //===========================
  if ($_POST["submit"]) {
    if ($user == "") {
      echo '<script language="JavaScript">
swal({
  title: "登录后您才能发布帖子",
  text: "只有您登录后您才能发布帖子，请登录",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
    location.href="./login.php";
  }
);
</script>';
    } else if ($edit == null) {
      echo '<script language="JavaScript">
swal({
  title: "文章内容未输入",
  text: "只有您输入文章内容后才可以发布本文章",
  icon: "error",
  button: "确定",
});
</script>';
    } else if ($title == null) {
      echo '<script language="JavaScript">
swal({
  title: "话题未输入",
  text: "只有您输入话题后才可以发布本文章",
  icon: "error",
  button: "确定",
});
</script>';
    } else {
      include "userinfo.php";
      $id = md5(uniqid());
      $icon = $user_icon;
      $time = date("Y-m-d H:i:s");
      $xss_ban1 = str_replace("<script>", "&ltscript&gt", $edit);
      $xss_ban2 = str_replace("</script>", "&lt/script&gt", $xss_ban1);
      $xss_ban3 = str_replace("<", "&lt", $xss_ban2);
      $xss_ban4 = str_replace(">", "&gt", $xss_ban3);
      $xss_ban5 = str_replace("&", "&amp", $xss_ban4);
      $xss_ban6 = str_replace("\\", "\\\\", $xss_ban5);
      $sqlstr_tie = "insert into tie values('" . $id . "','" . $title . "','" . $user . "','" . $xss_ban6 . "','" . $time . "','" . $icon . "') ";
      $result_tie = mysqli_query($conn, $sqlstr_tie);
      if ($result_tie) {
        echo '<script language="JavaScript">
  swal({
    title: "文章发布成功",
    text: "您的文章已经发布成功\n您可以在首页看到这篇文章的全部！",
    icon: "success",
    button: "确定",
  })
  .then((willDelete) => {
      location.href="./index.php";
    }
  );
  </script>';
      } else {
        echo '<script language="JavaScript">
  swal({
    title: "文章发布失败",
    text: "您的文章已经发布失败\n",
    icon: "error",
    button: "确定",
  });
  </script>';
      }
    }
  }
}

function myLoved()
{
  global $conn;
  $user_get_name = $_COOKIE['key']; //获取用户cookie
  $sql_get_my = "SELECT * FROM love WHERE my='$user_get_name'"; //从数据库筛选用户信息
  $result_get_my = $conn->query($sql_get_my); //重新定义一个变量
  if ($result_get_my->num_rows > 0) {
    while ($row_get_my = $result_get_my->fetch_assoc()) { //只有这样才能取得一个列表！遍历一次
      $name = $row_get_my['mylove'];
      $sql = "SELECT * FROM tie WHERE user ='$name'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $names = $row['user'];
          $title = $row['title'];
          $code = $row['tid'];
          $time = $row['time'];
          $icon = $row['icon'];
          echo '
      <div class="card">
          <div class="item">
            <div class="item-heading">
              <h4><a href="./user_center.php?name=' . $names . '"><img width="50px" height="50px" class="img-thumbnail" src=' . $icon . '></a> <a href="./tie.php?tid=' . $code . '">' . $title . '</a></h4>
            </div>
            <div class="item-footer">
              <br><a href="#" class="text-muted"><i class="icon-comments"></i> 文章ID:</a> &nbsp; <span class="text-muted">' . $code . '</span>
          <br><a href="#" class="text-muted"><i class="icon-comments"></i> 帖子作者:</a> &nbsp; <span class="text-muted">' . $names . '</span>
          <br><a href="#" class="text-muted"><i class="icon-comments"></i> 发帖时间:</a> &nbsp; <span class="text-muted">' . $time . '</span>
            </div>
        </div>
        </div>';
        }
      }
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
        <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function islogin()
{
  $user_islogin_nosuer = $_COOKIE['key'];
  if ($user_islogin_nosuer == "") {
    @Header("Location:./login.php");
  }
}

function islogin_second()
{
  $user_islogin_nosuer = $_COOKIE['key'];
  if ($user_islogin_nosuer == "") {
    @Header("Location:../login.php");
  }
}

function fenList()
{
  global $conn;
  global $user;
  $sql_get_my = "SELECT * FROM love WHERE mylove='$user'"; //因为是我的粉丝列表，所以要从被关注者的名单里筛选，而不是我的my里筛选
  $result_get_my = $conn->query($sql_get_my); //重新定义一个变量
  if ($result_get_my->num_rows > 0) {
    while ($row_get_my = $result_get_my->fetch_assoc()) { //只有这样才能取得一个列表！遍历一次
      $name = $row_get_my['my']; //这里指的my是指关注我的人，因为前面已经筛选出的是关注自己的人的行，而不是自己关注的人的行，这里一定要记清
      $sql = "SELECT * FROM register WHERE username ='$name'"; //从register表里筛选
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $names = $row['username'];
          $code = $row['id'];
          $icon = $row['icon'];
        } //=====================================================
        echo '
      <div class="card">
          <div class="item">
            <div class="item-heading">
              <h4><a href="../user_center.php?name=' . $names . '"><img width="50px" height="50px" class="img-thumbnail" src=' . $icon . '></a></h4>
            </div>
            <div class="item-footer">
              <br><a href="#" class="text-muted"><i class="icon-comments"></i> 用户ID:</a> &nbsp; <span class="text-muted">' . $code . '</span>
          <br><a href="#" class="text-muted"><i class="icon-comments"></i> ta的用户名:</a> &nbsp; <span class="text-muted">' . $names . '</span>
            </div>
        </div>
        </div>
        ';
      } else {
        echo '<div align="center"><h3>空空如也~<h3></div><center><img src="../image/kong.png"class="img-rounded" alt="kong"><center>';
        //有bug的一个功能
      }
    }
  }
}

function loveList()
{
  global $conn;
  global $user;
  $sql_get_my = "SELECT * FROM love WHERE my='$user'"; //从数据库筛选用户信息，我的关注
  $result_get_my = $conn->query($sql_get_my); //重新定义一个变量
  if ($result_get_my->num_rows > 0) {
    while ($row_get_my = $result_get_my->fetch_assoc()) { //只有这样才能取得一个列表！遍历一次
      $name = $row_get_my['mylove'];
      $sql = "SELECT * FROM register WHERE username ='$name'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $names = $row['username'];
      $code = $row['id'];
      $icon = $row['icon'];
      echo '
   <div class="layui-panel">
  <h4><a href="./user_center.php?name=' . $names . '"><img width="50px" height="50px" style="box-shadow: 3px 2px 10px; border-radius:24px;" class="img-thumbnail" src=' . $icon . '></a></h4>
  <form action="unlove_user.php" method="POST">
  <input type="text" class="form-control" placeholder="" name="getname" value="' . $names . '" readonly="readonly" style = "display:none">
  <center><input type="submit" name="del" class="layui-btn layui-btn-warm" value="取消关注"/></center>
  </form>
  <br><a href="#" class="text-muted"><i class="icon-comments"></i> 用户ID:</a> &nbsp; <span class="text-muted">' . $code . '</span>
   <br><a href="#" class="text-muted"><i class="icon-comments"></i> 我的关注:</a> &nbsp; <span class="text-muted">' . $names . '</span>
   </div>
        ';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
        <center><img src="../image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function unloved()
{
  global $conn;
  global $user;
  $mylove_get_pack = $_POST["getname"];
  //echo $user_get_name."<br>";
  //echo $mylove_get_pack;
  //上面是调试输出用户名和关注的用户
  $sqlstr_un = "DELETE from love WHERE (my='$user') AND (mylove='$mylove_get_pack')"; //删除
  $result_un = mysqli_query($conn, $sqlstr_un);
  if ($result_un) {
    echo '<script language="JavaScript">
       swal({
         title: "取消关注成功",
         text: "已经成功的从列表中移除该用户",
         icon: "success",
         button: "确定",
       })
       .then((willDelete) => {
         location.href="./love.php";
       }
     );
       
       </script>';
  } else {
    echo '<script language="JavaScript">
        swal({
          title: "取消关注错误",
          text: "取消关注失败",
          icon: "error",
          button: "确定",
        })
        .then((willDelete) => {
          location.href="./love.php";
        }
      );
        
        </script>';
  }
}

function frpList()
{
  global $conn;
  global $user;
  $sql_frp_myself = "SELECT * FROM sev_config_qian WHERE username='$user'";
  $result_frp_myself = $conn->query($sql_frp_myself);
  if ($result_frp_myself->num_rows > 0) {
    while ($row_frp_myself = $result_frp_myself->fetch_assoc()) {
      $id_frp = $row_frp_myself['sev_id'];
      $type_frp = $row_frp_myself['type'];
      $local_frp = $row_frp_myself['local_port'];
      $remote_frp = $row_frp_myself['remote_port'];
      $names = $row_frp_myself['frp_name'];
      $remote_frp_nei_ip = $row_frp_myself['ip'];
      
      $sql_is = "SELECT * FROM sev_config WHERE id ='$id_frp'";
      $result_is = $conn->query($sql_is);
      $row = $result_is->fetch_assoc();
      $name_frp = $row['sev_name'];
      $ip_frp = $row['ip'];
      echo '
      <div class="card">
      <div class="card-body">
      ID:' . $id_frp . '| ' . $names . '
      隧道服务器:' . $name_frp . '<br>
      ip地址/域名:<span class="badge badge-danger">' . $ip_frp . '</span><br>
      本地IP:<span class="badge badge-danger">' . $remote_frp_nei_ip . '</span><br>
      映射方式:<span class="badge badge-dark">' . $type_frp . '</span><br>
      本地端口:<span class="badge badge-primary">' . $local_frp . '</span><br>
      服务器端口:<span class="badge badge-primary">' . $remote_frp . '</span>
      <hr>
      <form action="unfrp.php" method="POST">
      <input type="hidden" name="name" value="' . $names . '" />
      <input type="hidden" name="type" value="' . $type_frp . '" />
      <input type="hidden" name="id" value="' . $id_frp . '" />
      <input type="hidden" name="remote" value="' . $remote_frp . '" />
      <input type="submit" name="del_frp" class="btn btn-danger" style="float:right;" value="删除隧道"/>
      </form>
      </div>
      </div>
      <br>';
    }
  } else {
    echo '<div align="center"><h3>你什么服务器也没有添加~~<h3></div><br>
        <center><img src="../image/NULL.png"class="img-rounded" alt="kong"><center>';
  }
}

function frpList_http()
{
  global $conn;
  global $user;
  $sql_frp_myself_http = "SELECT * FROM http_https WHERE username='$user'";
  $result_frp_myself_http = $conn->query($sql_frp_myself_http);
  if ($result_frp_myself_http->num_rows > 0) {
    while ($row_frp_myself_http = $result_frp_myself_http->fetch_assoc()) {
      $id_frp_http = $row_frp_myself_http['sev_id'];
      $type_frp_http = $row_frp_myself_http['type'];
      $local_frp_http = $row_frp_myself_http['local_port'];
      $remote_frp_http = $row_frp_myself_http['custom_domains'];
      $names_http = $row_frp_myself_http['frpname'];
      $sql_is_http = "SELECT * FROM sev_config WHERE id ='$id_frp_http'";
      $result_is_http = $conn->query($sql_is_http);
      $row_http = $result_is_http->fetch_assoc();
      $name_frp_http = $row_http['sev_name'];
      $ip_frp_http = $row_http['ip'];
      echo '
      <div class="card">
      <div class="card-body">
      ID:' . $id_frp_http . '| ' . $names_http . '
      隧道服务器:' . $name_frp_http . '<br>
      域名需要绑定的 A/CNAME 记录:<span class="badge badge-danger">' . $ip_frp_http . '</span><br>
      映射方式:<span class="badge badge-dark">' . $type_frp_http . '</span><br>
      本地端口:<span class="badge badge-primary">' . $local_frp_http . '</span><br>
      绑定域名:<span class="badge badge-primary">' . $remote_frp_http . '</span>
      <hr>
      <form action="unfrp_http.php" method="POST">
      <input type="hidden" name="name" value="' . $names_http . '" />
      <input type="hidden" name="type" value="' . $type_frp_http . '" />
      <input type="hidden" name="id" value="' . $id_frp_http . '" />
      <input type="hidden" name="custom_domains" value="' . $remote_frp_http . '" />
      <input type="submit" name="del_frp" class="btn btn-danger" style="float:right;" value="删除隧道"/>
      </form>
      </div>
      </div>
      <br>';
    }
  } else {
    echo '<div align="center"><h3>你什么服务器也没有添加~~<h3></div><br>
        <center><img src="../image/NULL.png"class="img-rounded" alt="kong"><center>';
  }
}


function unfrp()
{
  global $conn;
  global $user;
  $name = $_POST["name"]; //frpname
  $types = $_POST["type"]; //type
  $id = $_POST["id"]; //id
  $remote = $_POST["remote"]; //id
  $sqlstr_un = "DELETE from sev_config_qian WHERE (username='$user') AND (frp_name='$name') AND (type ='$types') AND (sev_id='$id')AND (remote_port='$remote')"; //删除
  $result_un = mysqli_query($conn, $sqlstr_un);
  if ($result_un) {
    echo '<script language="JavaScript">
       swal({
         title: "删除TCP/UDP隧道成功",
         text: "已经成功的从列表中移除该隧道",
         icon: "success",
         button: "确定",
       })
       .then((willDelete) => {
         location.href="./user.php";
       }
     );
       
       </script>';
  } else {
    echo '<script language="JavaScript">
        swal({
          title: "取消错误",
          text: "取消失败",
          icon: "error",
          button: "确定",
        })
        .then((willDelete) => {
          location.href="./user.php";
        }
      );
        
        </script>';
  }
}

function unfrp_http()
{
  global $conn;
  global $user;
  $name = $_POST["name"]; //frpname
  $types = $_POST["type"]; //type
  $id = $_POST["id"]; //id
  $remote = $_POST["custom_domains"]; //id
  $sqlstr_un = "DELETE from http_https WHERE (username='$user') AND (frpname='$name') AND (type ='$types') AND (sev_id='$id')AND (custom_domains='$remote')"; //删除
  //ECHO $sqlstr_un;
  $result_un = mysqli_query($conn, $sqlstr_un);
  if ($result_un) {
    echo '<script language="JavaScript">
       swal({
         title: "删除HTTP/HTTPS隧道成功",
         text: "已经成功的从列表中移除该隧道",
         icon: "success",
         button: "确定",
       })
       .then((willDelete) => {
         location.href="./user.php";
       }
     );
       
       </script>';
  } else {
    echo '<script language="JavaScript">
        swal({
          title: "取消错误",
          text: "取消失败",
          icon: "error",
          button: "确定",
        })
        .then((willDelete) => {
          location.href="./user.php";
        }
      );
        
        </script>';
  }
}

function safety() //安全中心~
{
  global $conn;
  global $user;
  $password = $_COOKIE["password"];
  $user_get_key_name = $_COOKIE['key'];
  $user_get_key_pass = $_COOKIE['password'];
  $sql_user_get = "SELECT * FROM register WHERE (username ='$user_get_key_name') AND (password='$user_get_key_pass')";
  $result_sql_first = $conn->query($sql_user_get);
  $row_get = $result_sql_first->fetch_assoc();
  $user_passw = $row_get['password'];
  if ($password == $user_passw) {
    echo "";
  } else {
    echo '<script language="JavaScript">
swal({
  title: "非法登录",
  text: "非法登录！禁止更改cookie等关键安全因素！\n如果需要接着使用，请手动清空cookie！",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
  location.href="./index.php";
}
);
</script>';
  }
}

function loginOK()
{
  global $conn;
  if ($_POST['uname']) {
    $name = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $base64_pwd = base64_encode($pwd);
    $sql = "SELECT * FROM register WHERE (mail ='$name') AND (password='$base64_pwd')";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $names = $row['username'];
        $time = 1 * 60 * 60 * 24 * 365;
        setcookie("key", $names, time() + $time);
        setcookie("password", $base64_pwd, time() + $time);
        setcookie("page", "1", "");
        //Header("Location:./user/user.php");
        echo '<script language="JavaScript">
      swal({
        title: "登录成功",
        text: "您登录成功\n您可以马上开始使用！",
        icon: "success",
        button: "确定",
      })
      .then((willDelete) => {
          location.href="./user/user.php";
        }
      );
      </script>';
      }
    } else {
      echo '<script language="JavaScript">
      swal({
        title: "登录失败",
        text: "您登录失败\n您可以注册后开始使用！或者检查是否密码账号错误",
        icon: "error",
        button: "确定",
      });
      </script>';
    }
  } else {
  }
}

function searchOK()
{
  global $conn;
  $keyword = $_GET["keyword"];
  $sql = "select * from tie where title like '%" . $keyword . "%'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['title'];
      $code = $row['tid'];
      $time = $row['time'];
      $icon = $row['icon'];
      $name = $row['username'];
      $neirong = $row['neirong'];
      $sub = substr($neirong, 0, 270);
      echo '
<div class="layui-card" >
<div class="layui-card-body" style="box-shadow: 1px 1px 4px; #b6b3b3 border-radius:24px;">
<div class="layui-container">  
<div class="layui-row">
  <div class="layui-col-md3">
<a href="./user/user_center.php?name=' . $names . '"><img width="60px" height="60px" style="box-shadow: 3px 2px 10px; border-radius:24px;" src=' . $icon . '></a><br>
ID:' . $code . '<br>
帖子作者:' . $names . '<br>
发帖时间:' . $time . '<br>
  </div>
  <div class="layui-col-md9">
  <div class="layui-fluid">
  <h3><a href="./tie.php?tid=' . $code . '">' . $title . '</a></h3><br><hr>
  <div class="layui-panel">
  <div style="padding: 30px;"><p style="white-space:normal; word-break:break-all;overflow:hidden;">' . $sub . '......</p></div>
</div>  
  
  </div>
  </div>
</div>


</div>
</div>
<hr>
';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
    <center><img src="../image/sno.png" class="top_end" alt="kong" width="300px" height="300px"><center>';
  }
}

function mytie()
{
  global $conn;
  global $user;
  $sql = "SELECT * FROM tie WHERE user='$user' order by time desc";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['title'];
      $code = $row['tid'];
      $time = $row['time'];
      $icon = $row['icon'];
      $neirong = $row['neirong'];
      $sub = substr($neirong, 0, 270);
      echo '
      <div class="layui-card" >
  <div class="layui-card-body" style="box-shadow: 1px 1px 4px; border-radius:24px;">
  <div class="layui-container">  
  <div class="layui-row">
    <div class="layui-col-md3">
  <a href="../user/user_center.php?name=' . $names . '"><img width="60px" height="60px" style="box-shadow: 3px 2px 10px; border-radius:24px;" src=' . $icon . '></a><br>
  ID:' . $code . '<br>
  帖子作者:' . $names . '<br>
  发帖时间:' . $time . '<br>
    </div>
    <div class="layui-col-md9">
    <div class="layui-fluid">
    <h3><a href="../tie.php?tid=' . $code . '">' . $title . '</a></h3><br><hr>
    <div class="layui-panel">
    <div style="padding: 30px;"><p style="white-space:normal; word-break:break-all;overflow:hidden;">' . $sub . '......</p></div>
  </div>  
    <br>
    </div>
    </div>
  </div>
  </div>
</div>
<hr>';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
            <center><img src="../image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function othertie()
{
  //get
  global $conn;
  $user_g = $_GET['name'];
  $sql = "SELECT * FROM tie WHERE user='$user_g'"; //取得用户目录
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['title'];
      $code = $row['tid'];
      $time = $row['time'];
      $icon = $row['icon'];
      $neirong = $row['neirong'];
      $sub = substr($neirong, 0, 270);
      echo '
      <div class="layui-card" >
  <div class="layui-card-body" style="box-shadow: 1px 1px 4px; border-radius:24px;">
  <div class="layui-container">  
  <div class="layui-row">
    <div class="layui-col-md3">
  <a href="../user/user_center.php?name=' . $names . '"><img width="60px" height="60px" style="box-shadow: 3px 2px 10px; border-radius:24px;" src=' . $icon . '></a><br>
  ID:' . $code . '<br>
  帖子作者:' . $names . '<br>
  发帖时间:' . $time . '<br>
    </div>
    <div class="layui-col-md9">
    <div class="layui-fluid">
    <h3><a href="../tie.php?tid=' . $code . '">' . $title . '</a></h3><br><hr>
    <div class="layui-panel">
    <div style="padding: 30px;"><p style="white-space:normal; word-break:break-all;overflow:hidden;">' . $sub . '......</p></div>
  </div>  
    <br>
    </div>
    </div>
  </div>
  </div>
</div>
<hr>';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
            <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function getfen_number()
{
  global $conn;
  global $user;
  $sql_co_fen = "SELECT COUNT(*) FROM love WHERE mylove='$user'"; //读取在别人关注列表里的自己信息
  $result_fen = $conn->query($sql_co_fen);
  $row_fen = $result_fen->fetch_row();
  echo '<h3><center><i class="layui-icon layui-icon-find-fill"></i> 粉丝:' . $row_fen[0] . '</center></h3>';
}

function getlove_number()
{
  global $conn;
  global $user;
  $sql_co_love = "SELECT COUNT(*) FROM love WHERE my='$user'";
  $result_love = $conn->query($sql_co_love);
  $row_love = $result_love->fetch_row();
  echo '<h3><center><i class="layui-icon layui-icon-heart-fill"></i> 我的关注:' . $row_love[0] . '</center></h3>';
}

function user_setup()
{
  include "userinfo.php";
  $st_name = $_POST['nc'];
  //$st_username = $_POST['username'];
  $st_mail = $_POST['mail'];
  $st_jianjie = $_POST['jianjie'];
  $st_user = $_COOKIE['key'];
  $st_id = $user_id_get;
  if ($_POST["submit"]) {
    $st_sql = "UPDATE register SET jianjie='" . $st_jianjie . "',mail='" . $st_mail . "', nicheng='" . $st_name . "' WHERE id='" . $st_id . "'";
    $result_st = mysqli_query($conn, $st_sql); //插入到评论表中
    if ($result_st) {
      //如果返回数据成功，执行下面sql查询
      //$sqlstr_msg = "insert into msg values('" . $tid . "','" . $user1 . "','" . $name_who . "','" . $edit1 . "','" . $time_pl . "','" . $icon_get . "','1') ";
      //mysqli_query($conn, $sqlstr_msg); //执行插入数据到msg表中
      echo '<script language="JavaScript">
            swal({
            title: "成功",
            text: "修改成功！",
            icon: "success",
            button: "确定",
            })
            </script>';
    } else { //评论失败
      echo '<script language="JavaScript">
    swal({
    title: "失败",
    text: "修改失败",
    icon: "error",
    button: "确定",
    })
    </script>';
    }
  }
}

function getMsg()
{
  global $conn;
  global $user;
  //=========================================
  //who表存储的是谁给了我们消息
  //user记录的是谁，发表了这个评论，who记录谁的
  $sql = "SELECT * FROM msg WHERE who='$user'";
  //==========================================
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    //=========================================================
    while ($row = $result->fetch_assoc()) {
      $who = $row['who'];
      $fromid = $row['fromid'];
      $text = $row['text'];
      $time = $row['time'];
      $icon = $row['icon'];
      echo '
      <div class="card">
          <div class="item">
            <div class="item-heading">
            <h4><a href="../user_center.php?name=' . $who . '"><img width="50px" height="50px" class="img-circle" src=' . $icon . '></a> | <span class="label label-primary">用户' . $who . '发表评论</span> | ' . $text . '</h4>
            <CENTER><span class="label label-badge label-primary label-outline"><a href="../tie.php?tid=' . $fromid . '">来源帖子ID:' . $fromid . '</a></span></CENTER>
            </div>
        </div>
        </div>';
    }
    //===============================================
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
            <center><img src="../image/kong.png"class="img-rounded" alt="kong"><center>';
  }

  if ($_POST["del"]) {
    $sql_del = "DELETE from msg where who='$user'";
    //==========================================
    $result_del = $conn->query($sql_del);
    @Header("Location:./msg_pl.php");
  }
}


function get_tie_neirong()
{
  $tid = $_GET["tid"];
  global $conn;
  $sql_getname = "SELECT * FROM tie WHERE tid='$tid'";
  $result_getname = $conn->query($sql_getname);
  $row_u = $result_getname->fetch_assoc();
  $uname = $row_u['user'];
  $sql = "SELECT * FROM tie,register WHERE (tie.tid='$tid') and (register.username='$uname')";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $names = $row['user'];
      $title = $row['title'];
      $code = $row['tid'];
      $time = $row['time'];
      $icon = $row['icon'];
      $name = $row['username'];
      $show = $row['neirong'];
      $nicheng = $row['nicheng'];
      echo '
<div class="layui-card">
<div id="section">
<img width="100px" height="100px" class="img-thumbnail" style="box-shadow: 3px 2px 10px; border-radius:24px;" src=' . $icon . '>
</div>
<div id="user">
<div style="text-align:right;" ><span class="label label-warning">帖子作者:' . $nicheng . '</span></div>
<div style="text-align:right;" ><span class="label label-primary label-outline">文章ID:' . $code . '</span></div>
<div style="text-align:right;" ><span class="label label-primary">发帖时间:' . $time . '</span></div>
</div>
<style type="text/css">
#section {
    width:160px;
	height:130px;
    float:left;
}
#user {
	height:130px;
}
</style>
<br><br>
<hr>
<br>
<h1><div>' . $title . ' </div></h1>
<div>
<div class="text">

<article style="display:none;"><p>
' . $show . '
</p>
</article >
</div>
</div>
<div id="out">
</div>
<div>
';
    }
  } else {
    echo '<div align="center"><h3>空空如也~<h3></div>
            <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}

function love_bt()
{
  global $conn;
  $tid_love = $_GET["tid"];
  $sql_getname_love = "SELECT * FROM tie WHERE tid='$tid_love'";
  $result_getname_love = $conn->query($sql_getname_love);
  $row_u_love = $result_getname_love->fetch_assoc();
  $uname_love = $row_u_love['user']; //得到本帖子的用户信息
  //=============================================
  $user_get_name_myself = $_COOKIE['key'];
  $sql_get_my = "SELECT * FROM love WHERE my='$user_get_name_myself' AND mylove='$uname_love'"; //从数据库筛选用户信息
  $result_get_my = $conn->query($sql_get_my); //重新定义一个变量
  if ($result_get_my->num_rows > 0) {
    echo '<form method="post">
  <center><input type="submit" name="have_loved" class="layui-btn layui-btn-warm" value="已关注"/></center>
  </form>';
  } else {
    echo '<form method="post">
  <center><input type="submit" name="love" 	class="layui-btn layui-btn-danger" value="关注"/>
  </center>
  </form>';
  }
  if ($_POST["have_loved"]) {
    echo '<script language="JavaScript">
swal({
  title: "您已经关注了这个用户",
  text: "您不能再关注一个已经关注了的用户！",
  icon: "error",
  button: "确定",
});
location.replace();
</script>';
  }

  if ($_POST["love"]) {
    $sqlstr = "insert into love values('" . $user_get_name_myself . "','" . $uname_love . "') ";
    $result = mysqli_query($conn, $sqlstr);

    if ($result) {
      echo '<script language="JavaScript">
swal({
  title: "关注成功",
  text: "您已经成功的关注了这个用户",
  icon: "success",
  button: "确定",
}).then((willDelete) => {
  location.href="./tie.php?tid=' . $tid_love . '";
}
);
</script>';
    } else {
      echo '<script language="JavaScript">
swal({
  title: "您已经关注了这个用户",
  text: "您不能再关注一个已经关注了的用户！",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
  location.href="./tie.php?tid="' . $tid_love . ';
}
);
</script>';
    }
  }
}

function likes_number()
{
  global $conn;
  global $user;
  $tids_gets = $_GET["tid"];
  $sql_co_tids = "SELECT COUNT(*) FROM likes WHERE tid='$tids_gets'";
  $result_tids = $conn->query($sql_co_tids);
  $row_tids = $result_tids->fetch_row();
  echo '<h3><center><i class="layui-icon layui-icon-heart-fill"></i> 点赞:<span class="layui-badge layui-bg-orange">' . $row_tids[0] . '</span> </center></h3>';
}
function likes()
{
  global $conn;
  $tids = $_GET["tid"];
  $user_myself_td = $_COOKIE['key'];
  $sql_get_my_tid = "SELECT * FROM likes WHERE id='$user_myself_td' AND tid='$tids'";
  $result_get_my_tid = $conn->query($sql_get_my_tid);
  if ($result_get_my_tid->num_rows > 0) {
    echo '<form method="POST">
  <center><input type="submit" name="UNLK" class="layui-btn layui-btn-warm" value="已点赞"/></center>
  </form>';
  } else {
    echo '<form method="POST">
  <center><input type="submit" name="LIK" class="layui-btn layui-btn-danger" value="点赞"/>
  </center>
  </form>';
  }

  if ($_POST["UNLK"]) {
    $sqlstr_unlikes = "DELETE from likes WHERE (id='$user_myself_td') AND (tid='$tids')"; //删除
    $result_unlikes = mysqli_query($conn, $sqlstr_unlikes);
    if ($result_unlikes) {
      echo '<script language="JavaScript">
       swal({
         title: "取消点赞成功",
         text: "已经成功的从点赞列表中移除该用户",
         icon: "success",
         button: "确定",
       })
       .then((willDelete) => {
        location.href="./tie.php?tid=' . $tids . '";
       }
     );
       
       </script>';
    } else {
      echo '<script language="JavaScript">
        swal({
          title: "取消点赞错误",
          text: "取消点赞失败",
          icon: "error",
          button: "确定",
        })
        .then((willDelete) => {
          location.href="./tie.php?tid=' . $tids . '";
        }
      );
        
        </script>';
    }
  }

  if ($_POST["LIK"]) {
    $sqlstr_likes_my = "insert into likes values('" . $user_myself_td . "','" . $tids . "') ";
    $result_likes_my = mysqli_query($conn, $sqlstr_likes_my);

    if ($result_likes_my) {
      echo '<script language="JavaScript">
swal({
  title: "点赞成功",
  text: "您已经成功的点赞了这个帖子",
  icon: "success",
  button: "确定",
}).then((willDelete) => {
  location.href="./tie.php?tid=' . $tids . '";
}
);
</script>';
    } else {
      echo '<script language="JavaScript">
swal({
  title: "您已经点赞了这个帖子",
  text: "您不能再点赞一个已经赞了的帖子！",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
  location.href="./tie.php?tid="' . $tids . ';
}
);
</script>';
    }
  }
}

function comments_put()
{
  global $conn;
  //获取内容
  $edit1 = $_POST["pinglunneirong"];
  $user1 = $_COOKIE['key']; //自己的用户名
  $tid = $_GET["tid"];
  //$fromid = $_GET["tid"];

  //===========================
  if ($_POST["submit"]) {
    if ($user1 == "") {
      echo '<script language="JavaScript">
swal({
  title: "登录后您才能发布评论",
  text: "只有您登录后您才能发布评论，请登录",
  icon: "error",
  button: "确定",
})
.then((willDelete) => {
    location.href="./index.php";
  }
);

</script>';
    } else {
      $time_pl = date("Y-m-d H:i:s");
      //==============================================
      $sql_who = "SELECT * FROM tie WHERE tid='$tid'";
      $result_who = $conn->query($sql_who); //获取帖子用户名
      $row_who = $result_who->fetch_assoc();
      $name_who = $row_who['user']; //这个是发布原帖子的作者用户名
      $leixing = 1; //类型1是评论
      $user_key = $_COOKIE['key'];
      $sql_user_1 = "SELECT * FROM register WHERE username='$user_key'";
      $result_user_1 = $conn->query($sql_user_1); //获取帖子用户名，在数据库里查询相关字段
      $row_user_1 = $result_user_1->fetch_assoc(); //将字段取得一行作为关联 |数组|（重要）
      $icon_get = $row_user_1['icon']; //这个是发布者的头像获取
      //===========================================
      $sqlstr_pl = "insert into pinglun values('" . $tid . "','" . $user1 . "','" . $name_who . "','" . $edit1 . "','" . $time_pl . "','" . $icon_get . "') ";
      $result_pl = mysqli_query($conn, $sqlstr_pl); //插入到评论表中
      if ($result_pl) { //如果返回数据成功，执行下面sql查询
        $sqlstr_msg = "insert into msg values('" . $tid . "','" . $user1 . "','" . $name_who . "','" . $edit1 . "','" . $time_pl . "','" . $icon_get . "','1') ";
        mysqli_query($conn, $sqlstr_msg); //执行插入数据到msg表中
      } else { //评论失败
        echo '<script language="JavaScript">
swal({
  title: "评论发布失败",
  text: "您的评论已经发布成功\n您可以在帖子下看到评论的全部！",
  icon: "error",
  button: "确定",
})
</script>';
      }
    }
  }
}

function comment_get()
{
  global $conn;
  $tid = $_GET["tid"]; //取得id
  $sql_plq = "SELECT * FROM pinglun WHERE tid='$tid'"; //从评论表中筛选和文章id相同的评论
  $result_plq = $conn->query($sql_plq); //查询
  if ($result_plq->num_rows > 0) {
    while ($row_plq = $result_plq->fetch_assoc()) {
      $names_plq = $row_plq['user'];
      $neirong_plq = $row_plq['neirong'];
      $time_plq = $row_plq['time'];
      $icon_plq = $row_plq['icon'];
      echo '
  <div class="layui-panel">
  <img width="50px" height="50px" class="img-thumbnail" src=' . $icon_plq . '>
    <div class="pull-right text-muted">' . $time_plq . '</div>
    <div><a href="###"><strong>' . $names_plq . '</strong></a> <span class="text-muted">回复的本帖子</div>
    <div class="text">' . $neirong_plq . '</div>
</div>
<br>';
    }
  } else {
    echo '<div align="center"><h3>还没有评论，快来抢沙发吧~<h3></div>
            <center><img src="./image/kong.png"class="img-rounded" alt="kong"><center>';
  }
}
function user_pic_get() //用户头像获取
{
  include "userinfo.php";
  $icon = $user_icon;
  echo $icon;
}
