<?php require("admin-header.php");
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
if(isset($_GET['keyword']))
	$keyword=$_GET['keyword'];
else
	$keyword="";
//static  $OJ_MARKET=array(array("http://tk.wxy1.cn/","changkeyId1"),array("http://oj.wxy1.cn/","changkeyId2"));
$json = @file_get_contents('http://tk.wxy1.cn/problem_market_json.php');
$result = json_decode($json,true);
// $page_cnt=100;
// $result=pdo_query($sql);
// $row=$result[0];
// $cnt=intval($row['upid'])-1000;
// $cnt=intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);
if (isset($_GET['page'])){
    $page=intval($_GET['page']);
  }else $page=$cnt;
 $pstart=1000+$page_cnt*intval($page-1);
 $pend=$pstart+$page_cnt;
 echo "<div class='container'>";
 echo "<form action=problem_list.php>";
 if($keyword) {
	 $keyword="%$keyword%";
 }else{
	// $result=pdo_query($sql,$pstart,$pend);
}
?>
<input name=keyword><input type=button value="<?php echo $MSG_SEARCH?>" ></form>

<?php
echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td colspan=8>";
echo "<input type=checkbox onchange='$(\"input[type=checkbox]\").prop(\"checked\", this.checked)'>";
echo "<tr><td>PID<td>Title<td>AC<td>submit<td>source<td>Date<td>pull";
foreach($result as $row){
        echo "<tr>";
        echo "<td>".$row['problem_id'];
        echo "<input type=checkbox name='pid[]' value='".$row['problem_id']."'>";
        echo "<td><a href=".$row['host']."/problem.php?id=".$row['problem_id'].">".$row['title']."</a>";
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
<script src='../template/bs3/jquery.min.js' ></script>
<script>
$(document).ready(function(){
  $(".pullproblem").click(function(){
        var problem_id=$(this).attr('problem-id');
		var host_id=$(this).attr('host-id');
		console.log(host_id);
		console.log(problem_id);
        $.post("problem_import_xml_byId_ajax.php",
                {problem_id:problem_id,host_id:host_id},
                function(data,status){
                        //location.reload();
                 //       console.log(data);
					alert(data);
                }
        );
  });
});
</script>
</div>
