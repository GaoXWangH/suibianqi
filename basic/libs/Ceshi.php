<?php
namespace app\libs;
use Yii;
use app\libs\Curl;
class Ceshi
{
   public static function token(){
       $appid=Yii::$app->params['token']['appID'];
       $appsecret=Yii::$app->params['token']['appsecret'];
       $session = Yii::$app->session;
       $tokens=$session['token'];
       $time=time();
       if(!$tokens || $session['time']+7200<$time){
           $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
           $data=Curl::_get($url);
           $data=json_decode($data,true);
           $session['token']=$data['access_token'];
           $session['time']=time();
           $tokens=$data['access_token'];
       }
       return $tokens;
   }
   public static function user_token(){
       $appid=Yii::$app->params['token']['appID'];
       $url="http://39.106.4.210/hapi/day/basic/web/index.php/climt/accesstoken";
       $redirect_uri=urlencode($url);
       $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo#wechat_redirect";
       header("location:".$url);
   }
    public static function ustoken(){
        $appid=Yii::$app->params['token']['appID'];
        $appsecret=Yii::$app->params['token']['appsecret'];
        $code=Yii::$app->request->get("code");
       $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
       $data=Curl::_get($url);
       $data=json_decode($data,true);
       return $data;
    }
}