<?php
namespace app\libs;
class Curl{

    //curl 对象
    public static $curl;
    public static $url;

    public static function _init($url){

        //给当前类属性赋值
        self::$url = $url;

        //初始化CURL
        self::$curl = curl_init();

        //设置header
        curl_setopt(self::$curl, CURLOPT_HEADER, 0);

        //设置返回数据 or 直接输出数据 1返回 0输出
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, 1);

        //设置为FALSE 禁止 cURL 验证对等证书
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYPEER, false);

        //设置为FALSE 不检查服务器SSL证书
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYHOST, false);

    }


    //get请求地址
    public static function _get($url, $param = array()){

        //验证curl对象是否存在
        if(!self::$curl) self::_init($url);

        //验证是否有要发送的数据
        if(!empty($param)) self::$url .= (new Curl())->getBuildParam($param);

        //设置要请求的URL
        curl_setopt(self::$curl, CURLOPT_URL, self::$url);

        //执行
        $data = curl_exec(self::$curl);

        //关闭请求源
        (new Curl())->_close();

        return $data;
    }

    //post请求地址
    public static function _post($url, $param = array(), $file = array()){

        //验证curl对象是否存在
        if(!self::$curl) self::_init($url);

        //设置要请求的URL
        curl_setopt(self::$curl, CURLOPT_URL, self::$url);

        //使用POST方式发送请求
        curl_setopt(self::$curl, CURLOPT_POST, 1);

        //如果需要上传文件
        if(!empty($file)){

            //将有发送的数据和文件合并到一起
            $param = array_merge($param, (new Curl())->sendFile($file));

            //设置curl上传功能
            curl_setopt(self::$curl, CURLOPT_SAFE_UPLOAD, true);
        }

        //验证是否要发送数据，则赋值
        if(!empty($param)) curl_setopt(self::$curl, CURLOPT_POSTFIELDS, $param);

        //执行
        $data = curl_exec(self::$curl);

        //关闭请求源
        (new Curl())->_close();

        return $data;
    }

    //发送文件
    private function sendFile($file){

        $c_file = array();

        //兼容发送多个文件
        foreach($file as $k=>$v){
            $c_file[$k] = new \CURLFile($v);
        }

        return $c_file;
    }

    //处理get方式的数组传参
    private function getBuildParam($param){

        //验证要请求的链接中是否存在?
        $str = strstr(self::$url, '?') ? '&' : '?';

        //循环将参数拼接为链接
        foreach($param as $k=>$v){
            $str .= $k.'='.$v.'&';
        }

        //截取最后一个&符
        $param_str = substr($str, 0, -1);

        return $param_str;
    }

    //关闭curl请求源
    private function _close(){

        //关闭curl链接源
        curl_close(self::$curl);

        self::$curl = false;
    }
}