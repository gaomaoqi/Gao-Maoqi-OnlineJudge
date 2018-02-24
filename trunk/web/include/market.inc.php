<?php 
class MarketUser
{
	public $host;
	public $username;
	public $password;
	public $secret_key;
}
$file_path = "../config/market.php";
$json = file_get_contents($file_path);
$markets= json_decode($json,true);
//echo $errorinfo = json_last_error(); 
if(count($markets,1) == 0){
	$markets[0] = new MarketUser();
	$markets[0]->host = "http://tk.wxy1.cn";
	$markets[0]->username = "hustoj";
	$markets[0]->password = "e10adc3949ba59abbe56e057f20f883e";
	$markets[0]->secret_key = "hustoj";
}
$oj_market_host = $markets[0]["host"];
$oj_market_username = $markets[0]["username"];
$oj_market_password = $markets[0]["password"];
// if (is_writable($file_path)) {
	// $str = json_encode($markets,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	// //$str = str_replace("\\","",$str);
	// file_put_contents($file_path,$str);  
// }else{
	// echo "请检查zhidao.txt文件是否有写入权限！";
// }
$oj_market_password = $oj_market_password;
$login_url = $oj_market_host .'/login_tk.php';   //登录页面地址
$cookie_file = dirname(dirname(__FILE__)) . "/config/cookie.txt";    //cookie文件存放位置（自定义）

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_exec($ch);
curl_close($ch);

// $post = "isLogin=1";
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $login_url);
// curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);         //提交方式为post
// curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
// $isLogin = curl_exec($ch);
// curl_close($ch);
// echo "isLogin=".$isLogin;
// if($isLogin !='isLogin')
{
	$post = "user_id=" .$oj_market_username. "&password=".$oj_market_password;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $login_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);         //提交方式为post
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
	$msg = curl_exec($ch);
	curl_close($ch);
}
?>
