<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];


    try {
        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>Username</td><td>Chip</td>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='25%'>" . $row['username'] . "</td>";
            $html .= "<td width='25%'>" . $row['coin'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";        
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "Không tìm thấy dữ liệu";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "<b>Chưa nhập ngày</b>";
}