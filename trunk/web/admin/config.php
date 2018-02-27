<?php
require_once(dirname(__FILE__) ."/../include/db_info.inc.php");
if (!isset($_SESSION[$OJ_NAME.'_'.'administrator']))
{
    echo "<a href='../loginpage.php'>Please Login First!</a>";
    exit(1);
}
$filename = dirname(__FILE__)."/../config/system.conf";
if(isset($_POST['config']))
{
    $str = $_POST['config'];
    if($tmp) {
        file_put_contents($filename,$str);
        echo '保存成功';
    }
    else
        echo "配置文件有错，没有保存";
    exit(1);
}
require("admin-header.php");
if(isset($OJ_LANG)){
    require_once("../lang/$OJ_LANG.php");
}
//$str = file_get_contents($filename);

echo "<title>System Config</title>";
echo "<center><h2>System Config</h2></center>";
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <form id="myform" method="post" role="form" >
                <div class="form-group">
                    <label for="exampleInputEmail1">如果你不熟悉配置文件请不要轻易修改此文件</label>
                    <textarea id="config" class="form-control" rows="30" cols="800" style="width: 900px;" style="overflow-x:scroll ；overflow-y:scroll ">

                    </textarea>
                </div>
                <button id="submit" type="button" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
require("../oj-footer.php");
?>
<script>
    $(function(){
        $('#submit').click(function(){
            var txt=$('#config').val();
            $.post('config.php',{config:txt},function(result){
                alert(result);
                console.log(result);
            });
        })
    })
</script>

