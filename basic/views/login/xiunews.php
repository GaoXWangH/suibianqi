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
<form action="doxiunews" method="post" enctype="multipart/form-data">
    <input type="text"  name="nid" value="<?php echo $info['nid']?>" style="display: none">
    新闻标题：<input type="text" name="ntitle" value="<?php echo $info['ntitle']?>"><br>
    新闻描述：<input type="text" name="ndescription" value="<?php echo $info['ndescription']?>"><br>
    新闻内容：<input type="text" name="ninfo" value="<?php echo $info['ninfo']?>"><br>
    新闻关键字：<input type="text" name="nguanjian" value="<?php echo $info['nguanjian']?>"><br>
    <input type="submit" value="修改">
</form>
</body>
</html>
