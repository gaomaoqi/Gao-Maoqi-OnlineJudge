<?php 
require_once ("../include/db_info.inc.php");
require_once("../include/set_get_key.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])
                ||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])
                ||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])
                )){
        echo "Please Login First!";
        exit(1);
}

$title_md5="nooooooooooooooooooo";
if (isset($_POST ['title_md5'])) {
	$title_md5 = $_POST['title_md5'];
	require_once("../include/market.inc.php");
	
	$data_url = $oj_market_host . '/market/hasProblem_api.php';
	$post = "title_md5=" .$title_md5;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $data_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);         //提交方式为post
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
	$msg = curl_exec($ch);
	echo $msg;
	exit(1);
}
echo $title_md5;
?>

