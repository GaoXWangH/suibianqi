<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\libs\Curl;

class AddconController extends Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        //echo 123;
        $sql="select DISTINCT dan from exam";
        $info=Yii::$app->db->createCommand($sql)->queryAll();
        //var_dump($info);die;
        foreach ($info as $key=>$val){
            $sql1="SELECT * from exam where dan='".$val['dan']."'";
            $e=Yii::$app->db->createCommand($sql1)->queryOne();
            $arr[$key]['lesson']=$e['month'];
            $arr[$key]['dan']=$val['dan'];
        }
       // var_dump($arr);die;
        return $this->render("shouye",array('info'=>$arr));
    }
    public function actionAddceshi(){
        return $this->render("index");
    }
    public function actionAddinfo(){
        //echo 234;die;
        $file=$_FILES['f'];
        $lesson=Yii::$app->request->post("lesson");
        $danyuan=Yii::$app->request->post("danyuan");
        //var_dump($lesson);die;
        $url="/phpstudy/www/hapi/advanced/api/web/ceshiti/".$file['name'];
        //echo $url;die;
        move_uploaded_file($file['tmp_name'],$url);
        //echo 123;
        $api_url="http://39.106.4.210/hapi/advanced/api/web/index.php/ceshi/index?filename=".$file['name']."&lesson=".$lesson."&danyuan=".$danyuan;
        $data=file_get_contents($api_url);
        $data=json_decode($data,true);
        echo $data['res'];
    }
    public function actionDosheng(){
        $dan=Yii::$app->request->get("danyuan");
        $url="http://39.106.4.210/hapi/advanced/api/web/index.php/ceshi/dosheng?danyuan=".$dan;
       // echo $url;die;
       $data=Curl::_get($url);
       $data=json_decode($data,true);
       return $this->render("show",['data'=>$data]);
    }
    public function actionCeshi(){
     $post=Yii::$app->request->post();
    // var_dump($post);die;
     $dan=$post['dan'];
     unset($post['dan']);
     //var_dump($post);echo $dan;die;
     for($i=10;$i<=14;$i++){
         $post[$i]=implode('',$post[$i]);
     }
     //var_dump($post);
     $sql="select * from exam inner join answer on exam.id=answer.id where exam.dan='".$dan."'";
     $info=Yii::$app->db->createCommand($sql)->queryAll();
     $sum=0;
     foreach($info as $key=>$val){
         if($val['is_yes']==$post[$key]){
             $sum+=$val['fen'];
         }
     }
     $jieguo="您的成绩为：".$sum." 分";
     return $this->render('jieguo',array('jieguo'=>$jieguo));
    }
}