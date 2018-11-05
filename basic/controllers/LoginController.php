<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\libs\Ceshi;
use app\libs\Curl;
use app\models\ContactForm;
class LoginController extends Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        return $this->render("login");
    }
    //登录验证
    public function actionLogindo()
    {
        $uname=Yii::$app->request->post("uname");
        $upwd=Yii::$app->request->post("upwd");
        $sql="select * from user where uname='$uname'";
        $data=Yii::$app->db->createCommand($sql)->queryOne();
        if($data){
            if($upwd==$data['upwd']){
                $session = Yii::$app->session;
                $session['uname']=$uname;
                $this->redirect("addnews");
            }else{
                echo "密码错误";
            }
        }else{
            echo "用户名有误";
        }
    }
    public function actionAddnews(){
     return $this->render("addnews");
    }
    //添加
    public function actionDoaddnews(){
        $nimg=$_FILES['nimg'];
        //var_dump($nimg);die;
        $ntitle=Yii::$app->request->post("ntitle");
        $ndescription=Yii::$app->request->post("ndescription");
        $ninfo=Yii::$app->request->post("ninfo");
        $nguanjian=Yii::$app->request->post("nguanjian");
        $ntu=Yii::$app->request->post("nimgurl");
        $nimgurl="/phpstudy/www/hapi/day/basic/web/img/".$nimg['name'];
        move_uploaded_file($nimg['tmp_name'],$nimgurl);
        $sql="insert into news values(NULL,'$ntitle','$ntu','$ndescription','$ninfo','$nguanjian')";
        $res=Yii::$app->db->createCommand($sql)->execute();
        if($res){
            $this->redirect("shownews");
        }else{
            echo "添加失败";
        }
    }
    //展示
    public function actionShownews(){
        $p=Yii::$app->request->get("page");
        $page=isset($p)?$p:1;
        $size=2;
        $limit=($page-1)*$size;
        $sql="select * from news";
        $info=Yii::$app->db->createCommand($sql)->queryAll();
        $count=count($info);
        $pagesum=ceil($count/$size);
        $sql1="select * from news limit $limit,$size";
        $data=Yii::$app->db->createCommand($sql1)->queryAll();
        $first=1;
        $page=array(
            'first'=>$first,
            'pagesum'=>$pagesum,
            'next'=>$page+1>$pagesum?$pagesum:$page+1,
            'prev'=>$page-1<1?1:$page-1,
            'p'=>$page
        );
        if(isset($p)){
            $arr['data']=$data;
            $arr['page']=$page;
            $arr=json_encode($arr);
            echo $arr;
        }else{
            $arr['data']=$data;
            $arr['page']=$page;
            return $this->render("shownews",['arr'=>$arr]);
        }
    }
    //删除
    public function actionDelnews(){
       $id=Yii::$app->request->post("id");
       $page=Yii::$app->request->post("p");
       $sql="delete from news where nid='$id'";
       $r=Yii::$app->db->createCommand($sql)->execute();
        $size=2;
        $limit=($page-1)*$size;
        $sql1="select * from news limit $limit,$size";
        $data=Yii::$app->db->createCommand($sql1)->queryAll();
        $arr['data']=$data;
        echo json_encode($arr);
    }
    public function actionXiunews(){
        $id=Yii::$app->request->get("id");
        $sql="select * from news where nid='$id'";
        $info=Yii::$app->db->createCommand($sql)->queryOne();
        return $this->render("xiunews",['info'=>$info]);
    }
    //修改
    public function actionDoxiunews(){
        $ntitle=Yii::$app->request->post("ntitle");
        $ndescription=Yii::$app->request->post("ndescription");
        $ninfo=Yii::$app->request->post("ninfo");
        $nguanjian=Yii::$app->request->post("nguanjian");
        $nid=Yii::$app->request->post("nid");
        $sql="update news set ntitle='$ntitle',ndescription='$ndescription',ninfo='$ninfo',nguanjian='$nguanjian' where nid='$nid'";
        $res=Yii::$app->db->createCommand($sql)->execute();
        if($res){
            echo "修改成功";
        }
    }
    public function actionXianginfo(){
        $id=Yii::$app->request->get("nid");
        $session = Yii::$app->session;
        $session['id']=$id;
        $nid=$session['id'];
        $sql="select * from news where nid='$nid'";
        $res=Yii::$app->db->createCommand($sql)->queryOne();
        return $this->render("xiang",['res'=>$res]);
    }
}