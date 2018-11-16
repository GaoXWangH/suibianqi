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
<form action="addinfo" method="post" enctype="multipart/form-data">
    试题的课程：<select name="lesson">
        <option value="移动项目实战">移动项目实战</option>
        <option value="开源产品二次开发">开源产品二次开发</option>
        <option value="电子商城">电子商城</option>
        <option value="项目优化">项目优化</option>
        <option value="框架项目实战">框架项目实战</option>
    </select><br>
    所在单元：<input type="text" name="danyuan"><br>
    要添加的题库：<input type="file" name="f"><br>
    <input type="submit" value="上传">
</form>
</body>
</html>
