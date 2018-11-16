<?php
header("content-type:text/html;charset=utf-8");
//var_dump($data);die;
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
<form action="ceshi" method="post">
    <input type="text" style="display: none" value="<?php echo $data['dan']?>" name="dan">
    <?php foreach($data['info'] as $key=>$val){?>
        <P>
            <?php if($val['type']=='1-单选'){?>
             单选题、<?php echo $key+1?>.<?php echo $val['ti']?>(<?php echo $val['fen']?>分)<br>
            <input type="radio" name="<?php echo $key?>" value="A">
            A.<?php echo $val['xuan_A']?><br>
            <input type="radio" name="<?php echo $key?>" value="B">
                B.<?php echo $val['xuan_B']?><br>
            <input type="radio" name="<?php echo $key?>" value="C">
                C.<?php echo $val['xuan_C']?><br>
            <input type="radio" name="<?php echo $key?>" value="D">
                D.<?php echo $val['xuan_D']?><br>
                <?php if($val['xuan_E']!=""){?>
                    <input type="radio" name="<?php echo $key?>" value="E">
                    E.<?php echo $val['xuan_E']?><br>
                <?php }?>
                <?php if($val['xuan_F']!=""){?>
                    <input type="radio" name="<?php echo $key?>" value="F">
                    F.<?php echo $val['xuan_F']?><br>
                <?php }?>
            <?php }?>
            <?php if($val['type']=='2-多选'){?>
                多选题、<?php echo $key+1?>.<?php echo $val['ti']?>(<?php echo $val['fen']?>分)<br>
                <input type="checkbox" name="<?php echo $key?>[]" value="A">A.<?php echo $val['xuan_A']?><br>
                <input type="checkbox" name="<?php echo $key?>[]" value="B">B.<?php echo $val['xuan_B']?><br>
                <input type="checkbox" name="<?php echo $key?>[]" value="C">C.<?php echo $val['xuan_C']?><br>
                <input type="checkbox" name="<?php echo $key?>[]" value="D">D.<?php echo $val['xuan_D']?><br>
                <?php if($val['xuan_E']!=""){?><input type="checkbox" name="<?php echo $key?>[]" value="E">E.<?php echo $val['xuan_E']?><br><?php }?>
                <?php if($val['xuan_F']!=""){?><input type="checkbox" name="<?php echo $key?>[]" value="F">F.<?php echo $val['xuan_F']?><br><?php }?>
            <?php }?>
           <?php if($val['type']=='0-判断'){?>
               判断、<?php echo $key+1?>.<?php echo $val['ti']?>(<?php echo $val['fen']?>分)<br>
               <input type="radio" name="<?php echo $key?>" value="A">A.<?php echo $val['xuan_A']?><br>
               <input type="radio" name="<?php echo $key?>" value="B">B.<?php echo $val['xuan_B']?><br>
            <?php }?>
        </P><br>
    <?php }?>
    <input type="submit" value="提交试卷">
</form>
</body>
</html>