<?php
session_start();

$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : date('Y-m-d');
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : date('Y-m-d');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê tin nhắn</title>
<?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });
        </script>

    </head>
    <body>
        <div class="pagewrap">
<?php require_once('topMenu.php'); ?>                
            <div class="box grid">
            <?php require_once('topMenu.sub2.php'); ?>
                <div class="box_header"><a href="javascript:void(0);">Thống kê Charge</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                UserName:
                                <input type="text" name="username" style="width: 100px;" />
                                Từ ngày:
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>" readonly="true"/> 
                                (00:00:00)
                                Tới ngày:
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>" readonly="true"/> 
                                (23:59:59)
                                <input type="submit" value="Submit" name="cmd" class="input_button"/>
                            </form>
                            <div style="height: 10px;"></div>

<?php
require("connectdb_gimwap.php");
$cmd = isset($_REQUEST["cmd"]) ? trim($_REQUEST["cmd"]) : NULL;
if ($cmd != NULL && $cmd == "Submit") {
    $a = isset($_REQUEST["fromDate"]) ? trim($_REQUEST["fromDate"]) : NULL;
    $b = isset($_REQUEST["toDate"]) ? trim($_REQUEST["toDate"]) : NULL;
    $usern = isset($_REQUEST["username"]) ? trim($_REQUEST["username"]) : NULL;

    $fDate = $a . " 00:00:00";
    $tDate = $b . " 23:59:59";

    $sql5 = "SELECT count(*) AS count FROM koin_charge WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";

    $rs5 = mysql_query($sql5) or die("Không thống kế đc");
    $row5 = mysql_fetch_array($rs5);
    $sms = $row5["count"];
    ?>
                                <div style="height: 20px; text-align: right; padding-right: 9px;"><b><font color="#FFFFFF"> Tổng: <?php echo $sms . " user"; ?> </font></b></div>
                                <div id="chart_div" style="width: 900px; ">
                                <?php
                                $sql = "SELECT * FROM log_nap_koin WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                //echo $sql;
                                $rs = mysql_query($sql) or die("Không thống kê được");
                                if (mysql_num_rows($rs) <= 0)
                                    echo "";
                                else {
                                    echo "<table width='100%' border='1' align='center' cellpadding='0' cellspacing='0'>" .
                                    "<tr>" .
                                    "<th>UserName</th>" .
                                    "<th>Koin</th>" .
                                    "<th>Partner</th>" .
                                    "<th>Money</th>" .
                                    "<th>Ngày Charge</th>" .
                                    "</tr>";

                                    $sobanghitrentrang = 30;
                                    $soluongtrang = ceil(mysql_num_rows($rs) / $sobanghitrentrang);
                                    $sotrang = isset($_REQUEST["p"]) ? trim($_REQUEST["p"]) : 0;
                                    if ($sotrang <= 0)
                                        $sotrang = 1;
                                    if ($sotrang > $soluongtrang)
                                        $sotrang = $soluongtrang;
                                    $sql1 = $sql . " limit " . ($sotrang - 1) * $sobanghitrentrang . "," . $sobanghitrentrang;
                                    $rs2 = mysql_query($sql1) or die("Không có người dùng nào thỏa mãn điều kiện!");
                                    while ($row = mysql_fetch_array($rs2)) {
                                        echo "<tr>" .
                                        "<td align='center'>" . $row["username"] . "</td>" .
                                        "<td align='center'>" . $row["koin_added"] . "</td>" .
                                        "<td align='center'>" . $row["partner"] . "</td>" .
                                        "<td align='center'>" . $row["money"] . "</td>" .
                                        "<td align='center'>" . $row["created_on"] . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                }
                                echo "<br/>Trang: ";
                                for ($i = 1; $i <= $soluongtrang; $i++) {
                                    if ($i == $sotrang)
                                        echo "&nbsp;<font color='red'><b>{$i}</b></font>&nbsp;";
                                    else {
                                        echo "&nbsp;<a href='koin_charge.php?p={$i}&cmd={$cmd}&username={$usern}&fromDate={$a}&toDate={$b}'>$i</a>&nbsp;";
                                    }if ($i % 30 == 0) {
                                        echo "<br/>";
                                    }
                                }
                            }
                            ?>
                                <div style="height: 20px;"></div>
                            </div>

                        </div>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>
