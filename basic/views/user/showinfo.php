<?php
//var_dump($info);
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
<h2>个人信息</h2><br>
<hr/>
<p>
    微信姓名：<?php echo $info['nickname']?><br>
    性 别：<?php if($info['sex'] == "1"){?>
        <?php echo "男";?>
    <?php }elseif($info['sex'] == "2"){?>
        <?php echo "女";?>
    <?php }else{?>
        <?php echo "未知";?>
    <?php }?>
    <br>
    地 区：<?php echo $info['country'].$info['province'].$info['city']?><br>
    头 像 ：<img src="<?php echo $info['headimgurl']?>" alt="" width="150px" height="150px">
</p>
</body>
</html>