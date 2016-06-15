<?php
//include 'cache_begin.php';
require('API/db.class.php');
$fromDate = $_REQUEST['fromDate'];
$toDate = $_REQUEST['toDate'];

if (!isset($fromDate)) {
    $fromDate = date('Y-m-d', time());
    $newdate = strtotime('-10 day', strtotime($fromDate));
    $fromDate = date('Y-m-d', $newdate);
}
if (!isset($toDate)) {
    $toDate = date('Y-m-d', time());
}
try {
    $sql = "select * from server_koin_daily where datecreate >= '" . $fromDate . "' and datecreate <= '" . $toDate . "' order by datecreate";
//    echo $sql;
    $chart_data = array();
    //$sql2 = "SELECT type, sum(koin_added) koin_added, date(created_on) as day FROM log_nap_koin  where created_on >= '".$fromDate."' and created_on <= '".$toDate."' GROUP BY day, type order by created_on";
    $sql3 = "SELECT date(date_created) as day, sum(koin) as koinadmin FROM admin_add_koin WHERE date_created >= '" . $fromDate . "' and date_created <= '" . $toDate . "' GROUP BY day";
//    echo $sql3;
    foreach ($db->query($sql) as $row) {
        $obj = json_decode($row['data']);
        $obj->KOINSMS = $row['sms_koin'];
        $obj->KOINCARD = $row['card_koin'];
        $obj->KOINADMIN = $row['admin_koin'];
        /*
          foreach($db->query($sql2) as $row2) {
          if($row['day'] == $row2['day']) {
          if($row2['type'] == 1)
          $obj->KOINSMS = $row2['koin_added'];
          else if($row2['type'] == 2)
          $obj->KOINCARD = $row2['koin_added'];
          }
          }
         */
        /*
          foreach($db->query($sql3) as $row3) {
          if($row['day'] == $row3['day']) {
          $obj->KOINADMIN = $row3['koinadmin'];
          echo $row3['koinadmin'];
          }
          } */
        $chart_data[] = array('day' => $row['datecreate'],
            'data' => json_encode($obj),
            'koin' => $row['diff_server_koin'],
            'regKoin' => $row['reg_koin']);
    }

//   var_dump($obj);
//   var_dump($chart_data);
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
$title = "Thống kê tiền fee";
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script>
        <script>
	        var chart1;
            $(document).ready(function() {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
                //chart 1
                chart1 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-1',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Koin Game'
                    },
                    xAxis: {
                        categories: 
                        [
                        //'Phỏm','TLMN','TLMN DC','TLMB','Poker','BacayCh','INVITE','Bacay','BacayMoi','Lieng','Sam','Binh','BuyItem'
                        <?php
                            foreach ($chart_data as $row) {
                            	echo "'". $row['day'] ."' , ";
                            }
                       ?>
                        ]
                    },
                    yAxis: {
                        title: {
                            text: 'Koin'
                        }
                    },
                    series: [
                    <?php
		                    $output = "";
                            foreach ($chart_data as $row) {
                                /*
$obj = json_decode($row['data']);
                                $output = $output."{name: '".$row['day']."',";
								$output = $output."data:[";
                                $output .= $obj->PHOM . ",";
                                $output .= $obj->TLMN . ",";
                                $output .= $obj->TLMNDC . ",";
                                $output .= $obj->TLMB . ",";
                                $output .= $obj->POKER . ",";
                                $output .= $obj->BACAYCH . ",";
                                $output .= $obj->INVITE . ",";
                                $output .= $obj->BACAY . ",";
                                $output .= $obj->BACAYNEW . ",";
                                $output .= $obj->LIENG . ",";
                                $output .= $obj->SAM . ",";
                                $output .= $obj->MAUBINH . ",";
                                $output .= $obj->BUYITEM;
								$output .= "]}, ";
*/
								
                            	//phom
                                $output .= "{name: 'Phỏm',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                $obj = json_decode($row2['data']);
										$output .= $obj->PHOM . ",";
								}
								$output .= "]}, ";
								//tienlenmiennam
                                $output .= "{name: 'TLMN',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->TLMN . ",";
								}
								$output .= "]}, ";
								//tienlenmiennam dem cay
                                $output .= "{name: 'TLMNDC',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->TLMNDC . ",";
								}
								$output .= "]}, ";
								//ba cay chuong
                                $output .= "{name: 'BACAYCH',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->BACAYCH . ",";
								}
								$output .= "]}, ";
								//invite
                                /*
$output .= "{name: 'INVITE',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->INVITE . ",";
								}
								$output .= "]}, ";
*/
								//bacay
                                $output .= "{name: 'BACAY',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->BACAY . ",";
								}
								$output .= "]}, ";
								//Bacay New
                                /*
$output .= "{name: 'BACAYNew',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->BACAYNEW . ",";
								}
								$output .= "]}, ";
*/
								//lieng
                                $output .= "{name: 'LIENG',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->LIENG . ",";
								}
								$output .= "]}, ";
								//bing
                                $output .= "{name: 'MAUBINH',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->MAUBINH . ",";
								}
								$output .= "]}, ";
								//Sam
                                $output .= "{name: 'SAM',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->SAM . ",";
								}
								$output .= "]}, ";
								//buy item
                                /*
$output .= "{name: 'BUY ITEM',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->BUYITEM . ",";
								}
								$output .= "]}, ";
*/
								
								break;
                            } 
                            echo substr($output, 0, -1);
                        ?>
						]
                    });
                    //chart 2
                chart2 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-2',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Koin Daily Bonus + Register + Koin SMS, Card'
                    },
                    xAxis: {
                        categories: 
                        [
                        //'Daily Bonus','Register'
                        <?php
                            foreach ($chart_data as $row) {
                            	echo "'". $row['day'] ."' , ";
                            }
                       ?>
                        ]
                    },
                    yAxis: {
                        title: {
                            text: 'Koin'
                        }
                    },
                    series: [
                    <?php
		                    $output = "";
                            foreach ($chart_data as $row) {
                            	//daily bonus
                                $output .= "{name: 'Daily Bonus',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                $obj = json_decode($row2['data']);
										$output .= $obj->DAILY_BONUS . ",";
								}
								$output .= "]}, ";
								//register
                                $output .= "{name: 'Register',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $row['regKoin'] . ",";
								}
								$output .= "]}, ";
								//koin sms
                                $output .= "{name: 'KOIN SMS',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->KOINSMS . ",";
								}
								$output .= "]}, ";
								//koin card
                                $output .= "{name: 'KOIN CARD',";
								$output .= "data:[";
								foreach ($chart_data as $row2) {	
                                	$obj = json_decode($row2['data']);
									$output .= $obj->KOINCARD . ",";
								}
								$output .= "]}, ";
								break;
                            } 
                            echo substr($output, 0, -1);
                        ?>
						]
                    });
            });
        </script>       
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php include('topMenu.koin.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê tiền fee"; ?></a></div>
                <div class="box_body">
                    <div style="padding-left:10px;">
                        <form action="" method="post">
                            Từ ngày
                            <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                            (00:00:00)
                            Tới ngày
                            <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                            (23:59:59)
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                    </div>
                    <div>
                        <table width="100%">
                            <tr>
                                <td>Ngày</td>
                                <td>Phỏm</td>
                                <td>TLMN</td>
                                <td>TLMN DC</td>
                                <td>TLMB</td>
                                <td>POKER</td>
                                <td>BACAYCH</td>
                                <td>INVITE</td>
                                <td>Bacay</td>
                                <td>Bacay moi</td>
                                <td>LIENG</td>
                                <td>Sam</td>
                                <td>Binh</td>
                                <td>BuyItem</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Koin game</b></td>

<!--                                <td>Facebook</td>
                                <td>Daily Bonus</td>
                                <td>Exp Event</td>
                                <td>Text Event</td>
                                <td>Koin SMS</td>
                                <td>Koin Card</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Tổng</b></td>-->

                            </tr>
                            <?php
                            foreach ($chart_data as $row) {
                                $obj = json_decode($row['data']);
                                echo "<tr>";
                                echo "<td>{$row['day']}</td>";
                                echo "<td>" . number_format($obj->PHOM) . "</td>";
                                echo "<td>" . number_format($obj->TLMN) . "</td>";
                                echo "<td>" . number_format($obj->TLMNDC) . "</td>";
                                echo "<td>" . number_format($obj->TLMB) . "</td>";
                                echo "<td>" . number_format($obj->POKER) ." </td>";
                                echo "<td>" . number_format($obj->BACAYCH) ." </td>";
                                echo "<td>" . number_format($obj->INVITE) ." </td>";
                                echo "<td>" . number_format($obj->BACAY) . "</td>";
                                echo "<td>" . number_format($obj->BACAYNEW) . "</td>";
                                echo "<td>" . number_format($obj->LIENG) . "</td>";
                                echo "<td>" . number_format($obj->SAM) . "</td>";
                                echo "<td>" . number_format($obj->MAUBINH) . "</td>";
                                echo "<td>" . number_format($obj->BUYITEM) . "</td>";
                                $total = $obj->PHOM + $obj->TLMN + $obj->TLMNDC + $obj->TLMB +$obj->POKER+$obj->BACAYCH+$obj->INVITE+ $obj->BACAY + $obj->BACAYNEW + $obj->LIENG + $obj->SAM + $obj->MAUBINH + $obj->BUYITEM;
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total) . "</b></td>";

                                /*
                                  echo "<td>".number_format($obj->FACEBOOK)."</td>";
                                  echo "<td>".number_format($obj->DAILY_BONUS)."</td>";
                                  echo "<td>".number_format($obj->EXP_MISSION)."</td>";
                                  echo "<td>".number_format($obj->EVENT)."</td>";
                                  echo "<td>".number_format($obj->KOINSMS)."</td>";
                                  echo "<td>".number_format($obj->KOINCARD)."</td>";

                                  $total2 = $total + $obj->FACEBOOK + $obj->DAILY_BONUS + $obj->EXP_MISSION + $obj->EVENT + $obj->KOINSMS + $obj->KOINCARD;
                                  echo "<td style='background-color:#FCD5B4;'><b>".number_format($total2)."</b></td>";
                                 */

                                echo "</tr>";
                            }
                            ?>
                        </table>

                        <table width="100%" style="padding-top:20px">
                            <tr>
                                <td>Ngày</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Koin game</b></td>
                                <td>Facebook</td>
                                <td>Daily Bonus</td>
                                <td>Admin nạp koin</td>
                                <td>Exp Event</td>
                                <td>Text Event</td>
                                <td>Koin SMS</td>
                                <td>Koin Card</td>
                                <td>Register</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Tổng</b></td>
                                <td align="center" style="background-color:#81A0F3;"><b>Diff</b></td>
                            </tr>
                            <?php
                            foreach ($chart_data as $row) {
                                $obj = json_decode($row['data']);
                                echo "<tr>";
                                echo "<td>{$row['day']}</td>";
                                $total = $obj->PHOM + $obj->TLMN + $obj->TLMNDC + $obj->TLMB +$obj->POKER+$obj->BACAYCH+$obj->INVITE+ $obj->BACAY + $obj->BACAYNEW + $obj->LIENG + $obj->SAM + $obj->MAUBINH + $obj->BUYITEM;
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total) . "</b></td>";

                                echo "<td>" . number_format($obj->FACEBOOK) . "</td>";
                                echo "<td>" . number_format($obj->DAILY_BONUS) . "</td>";
                                echo "<td>" . number_format($obj->KOINADMIN) . "</td>";
                                echo "<td>" . number_format($obj->EXP_MISSION) . "</td>";
                                echo "<td>" . number_format($obj->EVENT) . "</td>";
                                echo "<td>" . number_format($obj->KOINSMS) . "</td>";
                                echo "<td>" . number_format($obj->KOINCARD) . "</td>";
                                echo "<td>" . number_format($row['regKoin']) . "</td>";

                                $total2 = $total + $obj->FACEBOOK + $obj->DAILY_BONUS + $obj->EXP_MISSION + $obj->EVENT + $obj->KOINSMS + $obj->KOINCARD + $obj->KOINADMIN + $row['regKoin'];
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total2) . "</b></td>";
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($row['koin']) . "</b></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
						<br />
						<div id="chart-container-1" style="width: <?php echo $size;?>; height: 350px"></div>
						<br />
						<div id="chart-container-2" style="width: <?php echo $size;?>; height: 350px"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php include 'cache_end.php'; ?>

