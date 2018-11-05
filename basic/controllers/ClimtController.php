<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\libs\Ceshi;
use app\libs\Curl;
class ClimtController extends Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $get=Yii::$app->request->get();
        if(isset($get['echostr'])){
           //个人的token值
            $token="hapi";
            $tmpArr = array($token,$get['timestamp'], $get['nonce']);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );
            if($tmpStr == $get['signature']){
                echo $get['echostr'];
            }
        }
        $xml=file_get_contents("php://input");
        $xml=simplexml_load_string($xml);
        switch($xml->MsgType){
            case "event":$this->event($xml);break;
            case "text":$this->text($xml);break;
        }
    }
    public function event($xml){
         if($xml->EventKey=="qiandao"){
             $sql="select * from qiandao where openid='$xml->FromUserName'";
             $res=Yii::$app->db->createCommand($sql)->queryOne();
             if($res){
                 if($res['addtime']<=strtotime(date('Ymd').'23:59:59') && $res['addtime']>strtotime(date('Ymd'))){
                     echo '<xml>
                           <ToUserName>'.$xml->FromUserName.'</ToUserName>
                           <FromUserName>'.$xml->ToUserName.'</FromUserName>
                           <CreateTime>'.time().'</CreateTime>
                           <MsgType>text</MsgType>
                           <Content>今天你已经签过到了</Content>
                          </xml>';exit;
                 }else{
                     $sql2="update qiandao set addtime='$xml->CreateTime' where openid='$xml->FromUserName'";
                     $r=Yii::$app->db->createCommand($sql2)->execute();
                     $sql5="select * from qiandaojifen where openid='$xml->FromUserName'";
                     $re2=Yii::$app->db->createCommand($sql5)->queryOne();
                     $num=$re2['integ']+10;
                     $sql4="update qiandaojifen set integ='$num' where openid='$xml->FromUserName'";
                     $rww=Yii::$app->db->createCommand($sql4)->execute();
                     echo '<xml>
                           <ToUserName>'.$xml->FromUserName.'</ToUserName>
                           <FromUserName>'.$xml->ToUserName.'</FromUserName>
                           <CreateTime>'.time().'</CreateTime>
                           <MsgType>text</MsgType>
                           <Content>签到成功</Content>
                          </xml>';exit;
                 }
             }else{
                 $sql1="insert into qiandao values(NULL,'$xml->FromUserName','$xml->CreateTime')";
                 $re=Yii::$app->db->createCommand($sql1)->execute();
                 $sql3="insert into qiandaojifen values(NULL,'$xml->FromUserName',10)";
                 $re=Yii::$app->db->createCommand($sql3)->execute();
                 echo '<xml>
                       <ToUserName>'.$xml->FromUserName.'</ToUserName>
                       <FromUserName>'.$xml->ToUserName.'</FromUserName>
                       <CreateTime>'.time().'</CreateTime>
                       <MsgType>text</MsgType>
                       <Content>签到成功</Content>
                      </xml>';exit;
             }
         }elseif($xml->EventKey=="chaxun"){
             $sql="select * from qiandaojifen where openid='$xml->FromUserName'";
             $res=Yii::$app->db->createCommand($sql)->queryOne();
             if($res){
                 echo '<xml>
                       <ToUserName>'.$xml->FromUserName.'</ToUserName>
                       <FromUserName>'.$xml->ToUserName.'</FromUserName>
                       <CreateTime>'.time().'</CreateTime>
                       <MsgType>text</MsgType>
                       <Content>您的积分为：'.$res['integ'].'</Content>
                      </xml>';exit;
             }else{
                 echo '<xml>
                       <ToUserName>'.$xml->FromUserName.'</ToUserName>
                       <FromUserName>'.$xml->ToUserName.'</FromUserName>
                       <CreateTime>'.time().'</CreateTime>
                       <MsgType>text</MsgType>
                       <Content>您还没有签过到</Content>
                      </xml>';exit;
             }
         }elseif($xml->EventKey=="chakecheng"){
          $access_token=Ceshi::token();
          $openid=$xml->FromUserName;
             $sql="select * from lessonbiao inner join lesson on lesson.lesson_id=lessonbiao.lesson_id where openid='$openid' ORDER BY lessonbiao.id asc";
             $res=Yii::$app->db->createCommand($sql)->queryAll();
             $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
             $data=Curl::_get($url);
             $data=json_decode($data,true);
             $res=$data['nickname']."同学，您当前的课程安排如下：
".$res[0]['lesson_time'].":".$res[0]['lesson_name'].",
".$res[1]['lesson_time'].":".$res[1]['lesson_name'].",
".$res[2]['lesson_time'].":".$res[2]['lesson_name'].",
".$res[3]['lesson_time'].":".$res[3]['lesson_name']."";
             echo '<xml>
                       <ToUserName>'.$xml->FromUserName.'</ToUserName>
                       <FromUserName>'.$xml->ToUserName.'</FromUserName>
                       <CreateTime>'.time().'</CreateTime>
                       <MsgType>text</MsgType>
                       <Content>'.$res.'</Content>
                      </xml>';exit;
         }
    }
    public function actionLl(){
        $access_token=Ceshi::token();
        $openid="ouCHV1DMmSTusOYsiSezbT8RkpjI";
        $sql="select * from lessonbiao inner join lesson on lesson.lesson_id=lessonbiao.lesson_id where openid='$openid' ORDER BY lessonbiao.id asc";
        $res=Yii::$app->db->createCommand($sql)->queryAll();
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $data=Curl::_get($url);
        $data=json_decode($data,true);
        $res=$data['nickname']."同学，您当前的课程安排如下：
".$res[0]['lesson_time'].":".$res[0]['lesson_name'].",
".$res[1]['lesson_time'].":".$res[1]['lesson_name'].",
".$res[2]['lesson_time'].":".$res[2]['lesson_name'].",
".$res[3]['lesson_time'].":".$res[3]['lesson_name']."";
        echo $res;
    }
    public function actionGuanlesson(){
        $session = Yii::$app->session;
        $session->open();
        $userinfo=$session['info'];
        if(!isset($userinfo['access_token'])) {
            Ceshi::user_token();
        }
        $openid=$userinfo['openid'];
        return $this->render("guanli",["openid"=>$openid]);
    }
    public function actionAccesstoken(){
        $session = Yii::$app->session;
        $session->open();
        if(!isset($session['info']['access_token'])){
            $ustoken=Ceshi::ustoken();
            $session['info']=$ustoken;
        }
        $this->redirect("guanlesson");
    }
    public function actionDoaddlesson(){
        $data=Yii::$app->request->get();
        //var_dump($data);die;
        $openid=$data['openid'];
        $one=$data['onelesson'];
        $two=$data['twolesson'];
        $three=$data['threelesson'];
        $four=$data['fourlesson'];
        $sql="select * from lessonbiao where openid='$openid'";
        $res=Yii::$app->db->createCommand($sql)->queryAll();
        //var_dump($res);die;
        if($res){
             $sql1="update lessonbiao set lesson_id='$one' where openid='$openid' and lesson_time='第一节课'";
            $res1=Yii::$app->db->createCommand($sql1)->execute();
            $sql1="update lessonbiao set lesson_id='$two' where openid='$openid' and lesson_time='第二节课'";
            $res1=Yii::$app->db->createCommand($sql1)->execute();
            $sql1="update lessonbiao set lesson_id='$three' where openid='$openid' and lesson_time='第三节课'";
            $res1=Yii::$app->db->createCommand($sql1)->execute();
            $sql1="update lessonbiao set lesson_id='$four' where openid='$openid' and lesson_time='第四节课'";
            $res1=Yii::$app->db->createCommand($sql1)->execute();
            if($res1){
                echo "课程修改成功";
            }else{
                echo "课程修改成功";
            }
        }else{
            $sql2="insert into lessonbiao values(NULL,'$openid','$one','第一节课')";
            $res2=Yii::$app->db->createCommand($sql2)->execute();
            $sql2="insert into lessonbiao values(NULL,'$openid','$two','第二节课')";
            $res2=Yii::$app->db->createCommand($sql2)->execute();
            $sql2="insert into lessonbiao values(NULL,'$openid','$three','第三节课')";
            $res2=Yii::$app->db->createCommand($sql2)->execute();
            $sql2="insert into lessonbiao values(NULL,'$openid','$four','第四节课')";
            $res2=Yii::$app->db->createCommand($sql2)->execute();
            if($res2){
                echo "课程添加成功";
            }else{
                echo "课程添加成功";
            }
        }
    }
}