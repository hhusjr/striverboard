<?php
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="none" />
        <title>错误啦！</title>
        <style type="text/css">
         body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre,
         form, fieldset, input, textarea, p, blockquote, th, td {
             padding: 0;
             margin: 0;
         }
         body {
             word-wrap: break-word;
             word-break: break-all;
             font-family: Helvetica, Tahoma, Arial, "Heiti SC", "Microsoft YaHei", "WenQuanYi Micro Hei";
         }
         .main {
             text-align: center;
             margin-top: 50px;
         }
         h1 {
             font-size: 80px;
         }
         a {
             color: #ff3e00;
             text-decoration: none;
         }
         p {
             margin-top: 20px;
         }
        </style>
    </head>
    <body>
        <div class="main">
            <h1>:(</h1>
            <p>出现错误。原因可能是系统故障，不具备访问权限，或者参数非法。请尝试<a href="<?php echo ($a->U)('Index', 'Index'); ?>">回到主页</a></p>
        </div>
    </body>
</html>
