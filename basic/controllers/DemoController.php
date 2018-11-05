<?php 
namespace app\controllers;
use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\libs\Ceshi;
use app\libs\Curl;
use app\models\ContactForm;
class DemoController extends Controller
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
                echo $get['echostr'];
            }
        }
        $xml=file_get_contents("php://input");
        $xml=simplexml_load_string($xml);
        switch($xml->MsgType){
            case "text":$this->text($xml);break;
            case "event":$this->event($xml);break;
            case "image":$this->image($xml);break;
        }
    }
    public function event($xml){
	    if($xml->Event=="subscribe"){
	        $openid=$xml->FromUserName;
            $token=Ceshi::token();
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid&lang=zh_CN";
            $info=Curl::_get($url);
            $info=json_decode($info,true);
            if($info['sex']=='1'){
                $sex="小男生";
            }elseif ($info['sex']=='2'){
                $sex="小女生";
            }else{
                $sex="小RY";
            }
            if($info['province']==""){
                $province="XX";
            }else{
                $province=$info['province'];
            }
            if($info['city']==""){
                $city="XX";
            }else{
                $city=$info['city'];
            }
            echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>text</MsgType>
               <Content>你好'.$info['nickname'].'，我猜你是'.$province.'省'.$city.'市的'.$sex.'</Content>
              </xml>';exit;
        }
    }
    public function text($xml){
	    if($xml->Content=="图片"){
            $sql="select * from material where id=1";
            $info=Yii::$app->db->createCommand($sql)->queryOne();
            $media_id=$info['media_id'];
            echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>image</MsgType>
               <Image>
                     <MediaId><![CDATA['.$media_id.']]></MediaId>
               </Image>
               </xml>';exit;
        }elseif($xml->Content=="认输" ||$xml->Content=="服了"){
            echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>text</MsgType>
               <Content>小样,还和我斗图</Content>
              </xml>';exit;
        }else{
            echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>text</MsgType>
               <Content>'.$xml->Content.'</Content>
              </xml>';exit;
        }
    }
    public function image($xml){
        $sql="select * from material where id=1";
        $info=Yii::$app->db->createCommand($sql)->queryOne();
        $media_id=$info['media_id'];
        echo '<xml>
               <ToUserName>'.$xml->FromUserName.'</ToUserName>
               <FromUserName>'.$xml->ToUserName.'</FromUserName>
               <CreateTime>'.time().'</CreateTime>
               <MsgType>image</MsgType>
               <Image>
                     <MediaId><![CDATA['.$media_id.']]></MediaId>
               </Image>
               </xml>';exit;
    }
    public function actionImgadd(){
	  return $this->render("imgadd");
    }
    public function actionAddfile(){
	    $media=$_FILES['media'];
	    $type=Yii::$app->request->post("type");
	    //var_dump($media);die;
        //echo $media['tmp_name'];die;
        $access_token=Ceshi::token();
        $flurl="/phpstudy/www/hapi/day/basic/web/img/".$media['name'];
        move_uploaded_file($media['tmp_name'],"/phpstudy/www/hapi/day/basic/web/img/".$media['name']);
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=$type";
        $data=Curl::_post($url,array(),array($flurl));
        $data=json_decode($data,true);
        $media_id=$data['media_id'];
        $type=time();
        $sql="insert into material values(NULL,'$media_id','$type')";
        $res=Yii::$app->db->createCommand($sql)->execute();
        if($res){
           echo "素材添加成功";
         }else{
            echo "素材添加失败";
        }
    }
    public function actionLl(){
	    $sql="select * from material where id=1";
	    $info=Yii::$app->db->createCommand($sql)->queryOne();
	    var_dump($info);
    }
    public function actionAddmenu(){
	    return $this->render("addmenu");
    }
    public function actionDoaddmenu()
    {
        $data=Yii::$app->request->post();
        //var_dump($data);die;
        foreach($data['name'] as $key=>$val){
            if($data['type'][$key]=="parent"){
                $arr[$key]['name']=$data['name'][$key];
                foreach ($data['sub_name'][$key] as $k=>$v){
                   $array=array();
                   $array['name']=$data['sub_name'][$key][$k];
                   $array['type']=$data['sub_type'][$key][$k];
                   if($data['sub_type'][$key][$k]=="view"){
                       $array['url']=$data['sub_value'][$key][$k];
                   }else{
                       $array['key']=$data['sub_value'][$key][$k];
                   }
                   $arr[$key]['sub_button'][]=$array;
                }
            }else{
                $arr[$key]['name']=$data['name'][$key];
                $arr[$key]['type']=$data['type'][$key];
                if($data['type'][$key]=="view"){
                    $arr[$key]['url']=$data['value'][$key];
                }else{
                    $arr[$key]['key']=$data['value'][$key];
                }
            }
        }
        $menu['button']=$arr;
        $menu=json_encode($menu,JSON_UNESCAPED_UNICODE);
        $access_token=Ceshi::token();
        //var_dump($access_token);die;
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $res=Curl::_post($url,$menu);
        $res=json_decode($res,true);
        if($res['errmsg']=="ok"){
            $this->redirect("showmenu");
        }else{
            $this->redirect("addmenu");
        }
    }
    public function actionShowmenu(){
        $access_token=Ceshi::token();
	    $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$access_token";
	    $data=Curl::_get($url);
	    $data=json_decode($data,true);
	    //var_dump($data);die;
        return $this->render("showmenu",['data'=>$data]);
    }
    public function actionDelmenu(){
        $access_token=Ceshi::token();
	    $url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
	    $data=Curl::_get($url);
	    $res=json_decode($data,true);
        if($res['errmsg']=="ok"){
            echo "删除成功";
        }else{
            echo "删除失败";
        }
    }
    public function actionSaveaddmenu()
    {
        $data=Yii::$app->request->post();
        //var_dump($data);die;
        foreach($data['name'] as $key=>$val){
            if($data['type'][$key]=="parent"){
                $arr[$key]['name']=$data['name'][$key];
                foreach ($data['sub_name'][$key] as $k=>$v){
                    $array=array();
                    $array['name']=$data['sub_name'][$key][$k];
                    $array['type']=$data['sub_type'][$key][$k];
                    if($data['sub_type'][$key][$k]=="view"){
                        $array['url']=$data['sub_value'][$key][$k];
                    }else{
                        $array['key']=$data['sub_value'][$key][$k];
                    }
                    $arr[$key]['sub_button'][]=$array;
                }
            }else{
                $arr[$key]['name']=$data['name'][$key];
                $arr[$key]['type']=$data['type'][$key];
                if($data['type'][$key]=="view"){
                    $arr[$key]['url']=$data['value'][$key];
                }else{
                    $arr[$key]['key']=$data['value'][$key];
                }
            }
        }
        $menu['button']=$arr;
        $menu=json_encode($menu,JSON_UNESCAPED_UNICODE);
        $access_token=Ceshi::token();
        //var_dump($access_token);die;
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $res=Curl::_post($url,$menu);
        $res=json_decode($res,true);
        if($res['errmsg']=="ok"){
            echo "修改成功";
        }else{
            $this->redirect("showmenu");
        }
    }
}
?>