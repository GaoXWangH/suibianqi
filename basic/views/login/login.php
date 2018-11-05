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
<form action="logindo" method="post">
    用户名：<input type="text" class="name" name="uname"><br>
    密码：<input type="password" class="pwd" name="upwd"><br>
    <input type="button" value="登陆" class="btnn">
</form>
</body>
</html>
<script src="/hapi/day/basic/web/bootstrap/js/jq.js"></script>
<script>
    $(".btnn").click(function(){
        var pwd=$(".pwd").val();
        var name=$(".name").val();
        if(name==""){
            alert("用户名不能为空");
            return false;
        }
        if(pwd =="") {
            alert("密码不能为空");
            return false;
        }
       if(name ==""){
           alert("用户名不能为空");
           return false;
       }
        $("form").submit();
    });
</script>