<?php
namespace app\controllers;
use app\libs\Token;
use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\libs\Ceshi;
use app\libs\Curl;
use app\models\ContactForm;
class YueController extends Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $get=Yii::$app->request->get();
        if(isset($get['echostr'])){
            $token="hapi";
            $tmpArr = array($token,$get['timestamp'], $get['nonce']);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );
            if($tmpStr == $get['signature']){
                echo $get['echostr'];exit;
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
        if($xml->Event=="subscribe"){
            $access_token=Token::gettoken();
            $opendi=$xml->FromUserName;
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$opendi&lang=zh_CN";
            $data=Curl::_get($url);
            $data=json_decode($data,true);
            if($data['sex']==1){
                $sex="小男生";
            }else{
                $sex="小女生";
            }
            if($data['province']==""){
                $province="XXX";
            }else{
                $province=$data['province'];
            }
            if($data['city']==""){
                $city="XXX";
            }else{
                $city=$data['city'];
            }
            echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>text</MsgType>
               <Content>你好'.$data['nickname'].',我猜你是'.$province.'省'.$city.'市的'.$sex.'。</Content>
              </xml>';exit;
        }
    }
    public function text($xml){
        $zi=$xml->Content;
        $sql="select * from news where nguanjian='$zi'";
        $data=Yii::$app->db->createCommand($sql)->queryOne();
        echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>news</MsgType>
               <ArticleCount>1</ArticleCount>
               <Articles>
               <item>
               <Title><![CDATA['.$data['ntitle'].']]></Title>
               <Description><![CDATA['.$data['ndescription'].']]></Description>
               <PicUrl><![CDATA['.$data['nimgurl'].']]></PicUrl>
               <Url><![CDATA[http://39.106.4.210/hapi/day/basic/web/index.php/login/xianginfo?nid='.$data['nid'].']]></Url>
               </item>
               </Articles>
              </xml>';exit;
    }
}