<?php
require("../lib/conn.php");
if ($conn->$connect_error) {
    die("Connection failed: " . $conn->$connect_error);
}
$key = $_GET["key"];
$page_Password = "aaa";
if($key != $page_Password){
    die("key error");
}
//所有人都可以使用的接口
//获取全部的用户名，然后密码是base64解密的
//register表


// 	username索引	
// 	password

//获取用户数据，输出格式  用户名=密码
echo "<pre>";
echo "xniuwebxipweunbc=biuwxbweuicb\n";
$sql = "SELECT * FROM register";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
      //解密
      $password = base64_decode($row["password"]);
      echo $row["username"]."=".$password."\n";
      
    }
} else {
    echo "0 结果";
}


