<?php 
ini_set('display_errors',1);            //错误信息  
ini_set('display_startup_errors',1);    //php启动错误信息  
error_reporting(-1);                    //打印出所有的 错误信息  

require("admin-header.php");
        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }
require_once("../include/set_get_key.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])
                ||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])
                ||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])
                )){
        echo "<a href='../loginpage.php'>Please Login First!</a>";
        exit(1);
}

class MarketUser
{
	public $host;
	public $username;
	public $password;
	public $secret_key;
}
$file_path = "../config/market.php";
$str = file_get_contents($file_path);
$str = str_replace("//","\\/\\/",$str);
$markets= json_decode($json,true);
if(count($markets,1) == 0){
	$markets[0] = new MarketUser();
	$markets[0]->host = "http://tk.wxy1.cn";
	$markets[0]->username = "wxy";
	$markets[0]->password = "123456abcdefg";
	$markets[0]->secret_key = "吴晓阳";
}
// if (is_writable($file_path)) {
	// $str = json_encode($markets,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	// $str = str_replace("\\","",$str);
	// file_put_contents($file_path,$str);  
// }else{
	// echo "请检查zhidao.txt文件是否有写入权限！";
// }
if(isset($_GET['keyword']))
	$keyword=$_GET['keyword'];
else
	$keyword="";
$oj_market_host = $markets[0]->host;
$oj_market_username = $markets[0]->username;
$oj_market_password = $markets[0]->password;
$page=1;
if (isset($_GET['page'])){
    $page=intval($_GET['page']);
  }else $page=$cnt;
 $pstart=1000+$page_cnt*intval($page-1);
 $pend=$pstart+$page_cnt;
 echo "<div class='container'>";
 echo "<form action=problem_market_index.php>";
 if($keyword) {
	 $keyword="%$keyword%";
 }else{
	// $result=pdo_query($sql,$pstart,$pend);
}
?>
<input name=keyword><input type=button value="<?php echo $MSG_SEARCH?>" ></form>

<nav id="page" class="center">
	<ul class="pagination">
		<li class="page-item"><a href="problem_market_index.php?page=1">&lt;&lt;</a></li>
		<?php  
		$pagecount = intval(@file_get_contents($oj_market_host.'/problem_market_json.php?getPageCount=1'));
		if($pagecount == 0)$pagecount=1;
		for ($i = 1; $i <= $pagecount; $i++) {
		?>
					<li class="page-item <?php if($page == $i){echo "active";} ?> "><a href="problem_market_index.php?page=<?php echo $i ?> ">
					<?php echo $i ?> 
					</a></li>
		<?php		
		}
		?>
		<li class="page-item"><a href="problem_market_index.php?page=<?php echo $pagecount ?>">&gt;&gt;</a></li>
	</ul>
</nav>

<?php
 $login_url = $oj_market_host .'/login.php';   //登录页面地址
 $cookie_file = dirname(__FILE__)."/config/cookie";    //cookie文件存放位置（自定义）
echo curl_getinfo();
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $login_url);
 curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
 curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
 curl_exec($ch);
 curl_close($ch);
  
$json = @file_get_contents($oj_market_host . '/problem_market_json.php?page='.$page);
$result = json_decode($json,true);

echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td colspan=8>";
echo "<input type=checkbox onchange='$(\"input[type=checkbox]\").prop(\"checked\", this.checked)'>";
echo "<tr><td>PID<td>Title<td>AC<td>submit<td>source<td>Date<td>pull";
foreach($result as $row){
        echo "<tr>";
        echo "<td>".$row['problem_id'];
        echo "<input type=checkbox name='pid[]' value='".$row['problem_id']."'>";
        echo "<td><a target='_blank' href=".$row['host']."/problem.php?id=".$row['problem_id'].">".$row['title']."</a>";
        echo "<td>".$row['accepted'];
		echo "<td>".$row['submit'];
		echo "<td>".$row['source'];
        echo "<td>".$row['in_date'];
		echo "<td>";
		echo "<input type=button class='pullproblem' value='pull' host-id=".$row['host']." problem-id=".$row['problem_id'].">";
        echo "</tr>";
}
echo "<tr><td colspan=8>";
echo "</tr>";
echo "</table></center>";
?>
<nav id="page" class="center">
	<ul class="pagination">
		<li class="page-item"><a href="problem_market_index.php?page=1">&lt;&lt;</a></li>
		<?php  
		$pagecount = intval(@file_get_contents($oj_market_host.'/problem_market_json.php?getPageCount=1'));
		if($pagecount == 0)$pagecount=1;
		for ($i = 1; $i <= $pagecount; $i++) {
		?>
					<li class="page-item <?php if($page == $i){echo "active";} ?> "><a href="problem_market_index.php?page=<?php echo $i ?> ">
					<?php echo $i ?> 
					</a></li>
		<?php		
		}
		?>
		<li class="page-item"><a href="problem_market_index.php?page=<?php echo $pagecount ?>">&gt;&gt;</a></li>
	</ul>
</nav>
<script src='../template/bs3/jquery.min.js' ></script>
<script>
$(document).ready(function(){
  $(".pullproblem").click(function(){
        var problem_id=$(this).attr('problem-id');
		var host_id=$(this).attr('host-id');
		console.log(host_id);
		console.log(problem_id);
		var _self = $(this);
        $.post("problem_import_xml_byId_ajax.php",
                {problem_id:problem_id,host_id:host_id},
                function(data,status){
                        //location.reload();
                 //       console.log(data);
					_self.val('ok');
					_self.attr('title',data);
					//alert(data);
                }
        );
  });
});
</script>
</div>
