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
<table border="1">
    <tr>
        <td>标题</td>
        <td>关键字</td>
        <td>操作</td>
    </tr>
    <tbody class="nei">
    <?php foreach ($arr['data'] as $key=>$val){?>
    <tr>
        <td><?php echo $val['ntitle']?></td>
        <td><?php echo $val['nguanjian']?></td>
        <td>
            <a href="xiunews?id=<?php echo $val['nid']?>">修改</a>|<a href="javascript:void(0)" id="del" where="<?php echo $val['nid']?>">删除</a>
        </td>
    </tr>
    <?php }?>
    </tbody>
</table>
<div id="page">
    <a href="javascript:void(0)" where="<?php echo $arr['page']['first']?>" class="page">首页</a>
    <a href="javascript:void(0)" where="<?php echo $arr['page']['prev']?>" class="page">上一页</a>
    <font id="f"><?php echo $arr['page']['p']?></font>
    <a href="javascript:void(0)" where="<?php echo $arr['page']['next']?>" class="page">下一页</a>
    <a href="javascript:void(0)" where="<?php echo $arr['page']['pagesum']?>" class="page">尾页</a>
</div>
</body>
</html>
<script src="/hapi/day/basic/web/bootstrap/js/jq.js"></script>
<script>
    $(document).on("click",".page",function(){
      var page=$(this).attr("where");
      //alert(page);
       var str="";
       var pa="";
        $.ajax({
          url:"shownews",
          type:"get",
          data:{page:page},
          dataType:"json",
          success:function(e){
              $.each(e['data'],function(k,v){
                  str+="<tr>";
                  str+="<td>"+v['ntitle']+"</td>";
                  str+="<td>"+v['nguanjian']+"</td>";
                  str+="<td>";
                  str+='<a href="xiunews?id='+v['nid']+'">修改</a>|<a href="javascript:void(0)" id="del" where="'+v['nid']+'">删除</a>';
                  str+="</td></tr>";
              });
              $(".nei").empty();
              $(".nei").append(str);
                pa+='<a href="javascript:void(0)" where="'+e['page']['first']+'" class="page">首页</a>';
              pa+='<a href="javascript:void(0)" where="'+e['page']['prev']+'" class="page">上一页</a>';
              pa+='<font id="f">'+e['page']['p']+'</font>';
              pa+='<a href="javascript:void(0)" where="'+e['page']['next']+'" class="page">下一页</a>';
              pa+='<a href="javascript:void(0)" where="'+e['page']['pagesum']+'" class="page">尾页</a>';
              $("#page").empty();
              $("#page").append(pa);
          }
      })
    });
    $(document).on("click","#del",function(){
        var id=$(this).attr("where");
        var p=$("#f").html();
        var _this=$(this);
        str="";
        $.ajax({
            url:"delnews",
            type:"post",
            data:{id:id,p:p},
            dataType:"json",
            success:function(e){
                str+="<tr>";
                str+="<td>"+e['data'][1]['ntitle']+"</td>";
                str+="<td>"+e['data'][1]['nguanjian']+"</td>";
                str+="<td>";
                str+='<a href="xiunews?id='+e['data'][1]['nid']+'">修改</a>|<a href="javascript:void(0)" id="del" where="'+e['data'][1]['nid']+'">删除</a>';
                str+="</td></tr>";
                _this.parents("tr").remove();
                $(".nei").append(str);
            }
        })
    })
</script>