<?php
namespace app\controllers;
use Yii;
use app\libs\Curl;
use app\libs\Token;
use yii\web\Controller;
class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        //echo 123;die;
        $session = Yii::$app->session;
        $session->open();
        $userinfo=$session['user'];
        $atoken=$userinfo['access_token'];
        $openid=$userinfo['openid'];
        //echo 123;die;
       //var_dump($userinfo);
      if (!isset($atoken)){
         Token::code();
        }
        $sql="SELECT * from user_ww where openid='$openid'";
        $source=Yii::$app->db->createCommand($sql);
        $userin=$source->queryOne();
        //var_dump($userin);die;
      if(!$userin){
           $this->redirect("inputuse");
       }else{
          $token123=Token::gettoken();
         $url11="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token123&openid=$openid&lang=zh_CN";
         $va=Curl::_get($url11);
         $va=json_decode($va,true);
         return $this->render("showinfo",['info'=>$va]);
      }
    }
    public function actionInputuse(){
        if(Yii::$app->request->post()){
          $name=Yii::$app->request->post("use_name");
            $session = Yii::$app->session;
            $session->open();
            $userinfo=$session['user'];
            $openid=$userinfo['openid'];
            $sql="insert into user_ww values(NULL,'$openid','$name') ";
            $info=Yii::$app->db->createCommand($sql)->execute();
            if($info){
                $this->redirect("index");
            }
        }
     return $this->render("useinput");
    }
    public function actionToken(){
        //echo 123;die;
        $session = Yii::$app->session;
        $session->open();
        $userinfo=$session['user'];
        //echo 123;die;
        if(!isset($userinfo['access_token']) || empty($userinfo['access_token'])){
            //echo 123;die;
            $ustoken=Token::ustoken();
            $ustoken=json_decode($ustoken,true);
            $session['user']=$ustoken;
        }
        //var_dump($session['user']);die;
        $this->redirect("index");
    }
    public function actionCheck(){
        $session = Yii::$app->session;
        $session->open();
        $userinfo=$session['user'];
        $atoken=$userinfo['access_token'];
        $openid=$userinfo['openid'];
        $url1="https://api.weixin.qq.com/sns/auth?access_token=$atoken&openid=$openid";
        $data1=Curl::_get($url1);
        $data1=json_decode($data1,true);
        var_dump($data1);
    }
}