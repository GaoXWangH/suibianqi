<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="doaddnews" method="post" enctype="multipart/form-data">
    新闻标题：<input type="text" name="ntitle"><br>
    新闻描述：<input type="text" name="ndescription"><br>
    新闻图片：<input type="file" name="nimg"><br>
    新闻内容：<input type="text" name="ninfo"><br>
    新闻关键字：<input type="text" name="nguanjian"><br>
    图片地址：<input type="text" name="nimgurl"><br>
    <input type="submit" value="添加">
</form>
</body>
</html>
