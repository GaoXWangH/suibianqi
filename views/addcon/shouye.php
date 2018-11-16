<?php
//echo 123;
 //var_dump($info);die;
?>
<!doctype html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport"
       content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Document</title>
    <link rel="stylesheet" href="http://39.106.4.210/hapi/advanced/common/bootstrap/css/bootstrap.css">
</head>
<body>
<h2>
 试卷列表页
</h2><br>
<form action="addceshi" method="get">
<input type="submit" class="btn btn-primary tiao" value="添加试题">
</form>
<br>
<table class="table table-striped">
    <thead>
    <tr>
        <th>试卷名称</th>
        <th>试卷月份</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($info as $key=>$val){?>
    <tr>
        <td><a href="dosheng?danyuan=<?php echo $val['dan']?>"><?php echo $val['dan']?></a></td>
        <td><?php echo $val['lesson']?></td>
        <td><button type="button" class="btn btn-link">删除</button></td>
    </tr>
    <?php }?>
    </tbody>
</table>
</body>
</html>
<script src="http://39.106.4.210/hapi/advanced/common/bootstrap/js/bootstrap.js"></script>
<script src="http://39.106.4.210/hapi/advanced/common/bootstrap/js/jq.js"></script>
<script>

</script>