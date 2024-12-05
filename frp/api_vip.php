<?php
require("../lib/conn.php");
if ($conn->$connect_error) {
    die("Connection failed: " . $conn->$connect_error);
}

//定义一个get，只有get相同的数据才能使用
$key = $_GET["key"];
$page_Password = "bbb";
if($key != $page_Password){
    die("key error");
}
//这个只有购买的人才能使用
//数据库paidusers表包括id username	permissions	starttime endtime

//从paidusers获取购买的人用户名后，去register表获取密码，然后密码是base64解密的
//register表
// 	username索引	
// 	password

//获取用户数据，输出格式  用户名=密码
//先判断是否有数据
//然后判断是否到期

//获取time
$nowtime = time();

//逻辑上输出全部未到期的用户
//到期的判断是判断现在时间是否在开始时间和结束时间之间
echo "<pre>";
echo "xniuwebxipweunbc=biuwxbweuicb\n";
$sql = "SELECT * FROM paidusers";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {

      //判断是否到期
      //开始时间和结束时间需要转换为时间戳才能比较
        $starttime = strtotime($row["starttime"]);
        $endtime = strtotime($row["endtime"]);
        if($nowtime > $starttime && $nowtime < $endtime){
              //密码从register表获取
              $sql = "SELECT * FROM register WHERE username='".$row["username"]."'";
              $result2 = $conn->query($sql);
              $row2 = $result2->fetch_assoc();
                //解密
                $password = base64_decode($row2["password"]);
                echo $row["username"]."=".$password."\n";

      }else{
      }
    }
} else {
    die("error");
}