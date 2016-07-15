<?php
session_start();

require_once('_login.php');
$u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
if($u == 'nguyet' || $u == 'lam')
header("Location: http://beme.net.vn/bi1/comment.php");

include 'cache_begin.php';

require('API/db.class.php');

//TOP CP trong vong 1 tuan
$sql = "select value from config where `key`='config_iphoneTopup';";

//$cpname = array("x");
foreach ($db->query($sql) as $row) {
	$data = $row['value'];
	break;
}

//sms config
$sql_sms = "SELECT * FROM config WHERE `key` = 'config_smsNap'";
foreach($db->query($sql_sms) as $row)
{
	$data_sms = json_decode($row['value'], true);
	break;
}
//var_dump($data_sms);
$dataObj = json_decode($data);
//var_dump($dataObj);
$versions = $dataObj->topup;

$vers = array();

foreach ($versions as $version){
	$vers[] = $version->cp."@".$version->version;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Monaco</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			
 
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "iPhone dang submit"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
						<?php foreach ($vers as $v){
								echo $v."<br />";

						} ?>
                        </div>
                    </table>
                </div>
				
				</div>
			
			<div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Cấu hình SMS"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
						<?php
							$index = $data_sms['fixed'];
							if($index == -1)
							{
								echo "Random: ";
								$str = "";
								for($i=0; $i< count($data_sms['start']) ; $i++)
								{
									$str .= $data_sms['start'][$i] . 'x' . $data_sms['end'][$i] . " - ";
									
								}
								echo substr($str, 0, -3);
							}
							else
							{
								echo "Đầu số: " . $data_sms['start'][$index] . "x" . $data_sms['end'][$index];
							}
						?>
                        </div>
                    </table>
                </div>
				
				</div>
				
			 <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Doanh thu"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                         <tr>

			<td width=50% align=center><div>The cao MV</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=3">your browser does not support IFRAMEs</iframe></div></td>
			<td width=50% align=center><div>SMS MV</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=1">your browser does not support IFRAMEs</iframe></div></td>
		</tr>
                    </table>
                </div>
            </div>
			
				
				
				
				 <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Biểu đồ lịch sử</a>
                </div>
                <div class="box_body">
					<table width=100%>
						<tr>
						<td width="50%">
						<?php
							$fromDate = $toDate = date('Y-m-d');
						?>
						<iframe height="370" width="100%" frameBorder="0" src="nchart.php?size=500px&fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>">your browser does not support IFRAMEs</iframe></td>
						
						<td width="50%">
						<iframe height="370" width="100%" frameBorder="0" src="koin_data.php">your browser does not support IFRAMEs</iframe></td>
						</tr>
					</table>
					
                </div>
            </div>
				
			
			
			 <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "DAU"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                         <tr>

			<td width=50% align=center><div>Đăng ky</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau_data.php">your browser does not support IFRAMEs</iframe></div></td>
			<td width=50% align=center><div>Đăng nhập</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau1.php">your browser does not support IFRAMEs</iframe></div></td>
		</tr>
                    </table>
                </div>
            </div>
			
			
				
            </div>

        </div>
    </body>
</html>
<?php include 'cache_end.php'; ?>