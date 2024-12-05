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
        echo $title; ?> 升级用户 - Powered by Simpost
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

    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">注意!</h4>
        <p>请确认并确认体验用户后再购买，为了避免纠纷，我们不支持退款，我们是统一网络渠道，请不要上当受骗，如果需要请加入官方企鹅群：<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=FFjTm3UOOkZxF0hZI8E6qi47Rj26Hq6x&authKey=2FWqxy11LQzSxoHZNaKwYZPBlNnC0vCmTPp75m%2B8gYEa1KTWnqF3gx6nSmDQb%2FnM&noverify=0&group_code=875662451" target="_blank">875662451[点击加入]</a></p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h4>体验版 / 任何用户免费 / FREE</h4>
                        <hr>
                        10-100Mbps<br>
                        无限流量限制,不限速<br>
                        无隧道条数限制<br>
                        支持 TCP/UDP/STCP 隧道，部分支持HTTP/HTTPS<br>
                        体验版服务器开放使用|公益|免费<br>
                        体验服务器不提供任何质量担保！<br>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h4>正式版 / 个人用户 / ￥8</h4>
                        <hr>
                        10-200Mbps<br>
                        无限流量限制,不限速<br>
                        无隧道条数限制，更多节点<br>
                        支持 TCP/UDP/STCP 隧道，部分支持HTTP/HTTPS<br>
                        正式版服务器提供个人工程测试<br>
                        玩家多人联机临时使用<br>
                        个人网站，远程控制等<br>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
            <form name=alipayment action="./pay/epayapi.php" method=post target="_blank">
                        <input type="hidden" name="WIDsubject" value="Helofrp个人版"/>
					<h4>支付方式：</h4>
                    <hr>
                    <dd>
                        <label><input type="radio" name="type" value="alipay" checked="">支付宝</label>&nbsp;
                         <!-- <label><input type="radio" name="type" value="qqpay">QQ钱包</label>&nbsp;
                         <label><input type="radio" name="type" value="wxpay">微信支付</label>&nbsp;
                         <label><input type="radio" name="type" value="bank">云闪付</label> -->
                    </dd>

                    <dd>
                        <label><input type="radio" name="time" value="one" checked="">一个月</label>&nbsp;
                         <label><input type="radio" name="time" value="three">三个月</label>&nbsp;
                         <label><input type="radio" name="time" value="year">一年</label>&nbsp;
                    </dd>

                  
                            <button type="submit" class="btn btn-success">确 认</button>
</form>
</div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php
    include("../footer.php");
    ?>
    </body>

</html>