<?php
$menu=$data['menu'];
//var_dump($data['menu']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/hapi/day/basic/web/bootstrap/css/bootstrap.css">
</head>
<body>
<button type="button" class="btn btn-info addone">添加一级菜单</button>
<br><br>
<form action="saveaddmenu" method="post">
    <div class="shenti">
        <?php foreach($menu['button'] as $key=>$val){
            $keys=array_keys($val);
            ?>
        <div class="yiji" id="<?php echo $key?>">
            <div class="neirong">
                菜单名称<input type="text" name="name[]" value="<?php echo $menu['button'][$key]['name']?>">
                <select name="type[]">
                    <option value="parent">父级菜单</option>
                    <option value="view" <?php if(isset($menu['button'][$key]['type'])&&$menu['button'][$key]['type']=='view')echo 'selected';?>>视图事件</option>
                    <option value="click" <?php if(isset($menu['button'][$key]['type'])&&$menu['button'][$key]['type']=='click')echo 'selected';?>>点击事件</option>
                </select>值：<input type="text" name="value[]" value="<?php if(empty($menu['button'][$key]['sub_button']))echo $val[$keys[2]]?>"><input type="button" class="btn btn-success addson" value="[+]">
            </div>
            <?php if(!empty($val['sub_button']))foreach($val['sub_button'] as $k=>$v){
                $keyss=array_keys($v);
                ?>
                <p class="neirong">
                    菜单名称<input type="text" name="sub_name[<?php echo $key?>][]" value="<?php echo $v['name']?>">
                    <select name="sub_type[<?php echo $key?>][]">
                        <option value="view" <?php if(isset($v['type'])&&$v['type']=='view')echo 'selected';?>>视图事件</option>
                        <option value="click" <?php if(isset($v['type'])&&$v['type']=='click')echo 'selected';?>>点击事件</option>
                    </select>值：<input type="text" name="sub_value[<?php echo $key?>][]" value="<?php echo $v[$keyss[2]]?>"><input type="button" class="btn btn-danger delson" value="[-]">
                </p>
            <?php }?>
        </div>
        <?php }?>
    </div>
    <input type="submit" class="btn btn-info" value="添加菜单">
</form>
</body>
</html>
<script src="/hapi/day/basic/web/bootstrap/js/bootstrap.js"></script>
<script src="/hapi/day/basic/web/bootstrap/js/jq.js"></script>
<script>
    $(".addone").click(function(i){
        var num=$(".yiji").length;
        //alert(2123);
        if(num<3){
            str="";
            str+='<div class="yiji" id="'+num+'">';
            str+='<div class="neirong">';
            str+='菜单名称<input type="text" name="name[]">';
            str+='<select name="type[]">';
            str+='<option value="parent">父级菜单</option>';
            str+='<option value="view">视图事件</option>';
            str+='<option value="click">点击事件</option>';
            str+='</select>值：<input type="text" name="value[]">　<input type="button" class="btn btn-success addson" value="[+]"><input type="button" class="btn btn-danger delone" value="[-]">';
            str+='</div>';
            str+='</div>';
            $(".shenti").append(str);
        }else{
            alert("一级菜单最多为3个");
        }
    });
    $(document).on("click",".delone",function(){
        $(this).parents(".yiji").remove()
    });
    $(document).on("click",".addson",function(){
        var n=$(this).parents(".yiji").children("p").length;
        if(n<5){
            var id = $(this).parents(".yiji").attr("id");
            str = "";
            str += '<p class="neirong">&nbsp;&nbsp;&nbsp;&nbsp;';
            str += '菜单名称<input type="text" name="sub_name[' + id + '][]">';
            str += '<select name="sub_type[' + id + '][]">';
            str += '<option value="view">视图事件</option>';
            str += '<option value="click">点击事件</option>';
            str += '</select>值：<input type="text" name="sub_value['+id+'][]">　<input type="button" class="btn btn-danger delson" value="[-]">';
            str += '</p>';
            $(this).parents(".yiji").append(str);
        }else{
            alert("最多只有五个二级菜单")
        }
    });
    $(document).on("click",".delson",function(){
        $(this).parents(".neirong").remove()
    });
</script>