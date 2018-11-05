<?php
namespace app\libs;
use yii;
use app\libs\Curl;
class Token
{
    public static function gettoken(){
        $appID=Yii::$app->params['token']['appID'];
        $appsecret=Yii::$app->params['token']['appsecret'];
        $session = Yii::$app->session;
        $time=time();
        if(!$session['tokentime'] && !$time<$session['tokentime']+7200){

            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appID&secret=$appsecret";
            $data=Curl::_get($url);
            $session['tokentime']=time();
            $data=json_decode($data,true);
            $session['token']=$data['access_token'];
            $token=$session['token'];
        }else{
            //echo 1;
            $token=$session['token'];
        }
        //var_dump($token);die;
       return $token;
    }
}