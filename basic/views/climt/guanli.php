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
<form action="doaddlesson" method="get">
    <input type="text" style="display: none" name="openid" value="<?php echo $openid?>">
    <table>
        <tr>
            <td>第一节课：</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                <select name="onelesson">
                    <option value="1">PHP</option>
                    <option value="2">语文</option>
                    <option value="3">数学</option>
                    <option value="4">英语</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>第二节课：</td>
            <td></td>
            <td>
                <select name="twolesson">
                    <option value="1">PHP</option>
                    <option value="2">语文</option>
                    <option value="3">数学</option>
                    <option value="4">英语</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>第三节课：</td>
            <td></td>
            <td>
                <select name="threelesson">
                    <option value="1">PHP</option>
                    <option value="2">语文</option>
                    <option value="3">数学</option>
                    <option value="4">英语</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>第四节课：</td>
            <td></td>
            <td>
                <select name="fourlesson">
                    <option value="1">PHP</option>
                    <option value="2">语文</option>
                    <option value="3">数学</option>
                    <option value="4">英语</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>

</form>
</body>
</html>
