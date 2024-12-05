<!DOCTYPE html>
<html lang="CN">

<head>
  <meta charset="utf-8" />
  <title><?php include "../lib/config.php"; echo $title;?> - Powered by Simpost</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="../layui/css/layui.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../layui/layui.js"></script>
  <script src="../js/sweetalert.min.js"></script>
</head>

<body>
  <?php
  include("../header-sec.php")
  ?>
  <br>
  <div class="layui-container">
    <div class="layui-row">

      <div class="layui-panel">
        <br>
        <center><img src="../image/furme.png" width="260px" height="98px" class="img-rounded"></center>
        <br>
        <hr>
        <div class="alert">
          <hr>
        </div>
        <center>
          <h2>感谢使用Furme，版权所有侵权必究</H2><br>
          furme的后端构架基于改进后的simpost，由simpost强力驱动本项目，但是由于服务器高昂的费用支出，我们需要您的捐赠！
        </center>
        <hr>
        <H3><span class="label label-info">使用到的项目</span></H3>

        <BR>
        sweetalert弹窗：https://sweetalert.bootcss.com/<br>
        markdown编辑器：https://pandao.github.io/editor.md/<br>
        Strapdown.js解释器：https://github.com/arturadib/strapdown/<br>
        jquery前端：https://jquery.com/<br>
        openzui前端：http://www.openzui.com/<br>
        share.js：http://overtrue.me/share.js/<br>
        layui前端：https://layui.dev/</br>
        MathJax.js数学公式解释器<br>
        phpmailer邮箱模块<br>
        <br>
        <br>
        <?php
        include("../footer.php");
        ?>
      </div>
    </div>

  </div>
  </div>
</body>

</html>