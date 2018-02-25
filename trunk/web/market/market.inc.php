<?php

class MarketUser
{
    public $host;
    public $username;
    public $password;
    public $secret_key;
}

function http_request($URI, $header = false, $post = false)
{
    $cookie_file = dirname(__FILE__) . "/../config/cookie.txt";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URI);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);          //单位 秒，也可以使用
	#curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
	#curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
    #curl_setopt($ch, CURLOPT_HEADER, $isHeader);
    if($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    if(strpos($URI, 'https') === 0){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    if($post){
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
    }
    $result = curl_exec($ch);
    if (curl_errno($ch)) {//出错则显示错误信息
        print curl_error($ch);
    }
    curl_close($ch);
    return $result;
}
// if (is_writable($file_path)) {
// $str = json_encode($markets,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
// //$str = str_replace("\\","",$str);
// file_put_contents($file_path,$str);
// }else{
// echo "请检查zhidao.txt文件是否有写入权限！";
// }
static $oj_market_host = "http://tk.wxy1.cn";
static $oj_market_username = "hustoj";
static $oj_market_password = "e10adc3949ba59abbe56e057f20f883e";
function market_account_init()
{
    global $oj_market_host;
    global $oj_market_username;
    global $oj_market_password;

    $file_path = dirname(__FILE__) ."/../config/market.php";
    $json = file_get_contents($file_path);
    $markets= json_decode($json,true);
    if(count($markets,1) > 0){
        $oj_market_host = $markets[0]["host"];
        $oj_market_username = $markets[0]["username"];
        $oj_market_password = $markets[0]["password"];
    }
}
function market_isLogin()
{
    global $oj_market_host;
    $post = "checkLogin=1";
    $login_url = $oj_market_host .'/login_tk.php';   //登录页面地址
    return http_request($login_url,false,$post);
}
function market_login()
{
    global $oj_market_host,$oj_market_username,$oj_market_password;
    $post = "user_id=" .$oj_market_username. "&password=".$oj_market_password;
    $login_url = $oj_market_host .'/login_tk.php';   //登录页面地址
    return http_request($login_url,false,$post);
}
market_account_init();
?>
