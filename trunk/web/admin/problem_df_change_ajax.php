<?php 
require_once("../include/db_info.inc.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "Please Login First!";
	exit(1);
}
?>
<?php 
$ids = "(" . $_POST['ids'] . ")";
if($_POST['act'] =='Y')
	$sql="update `problem` set `defunct`='Y' where `problem_id` in ".$ids;
else
	$sql="update `problem` set `defunct`='N' where `problem_id` in ".$ids;
pdo_query($sql) ;
echo("success");
?>
