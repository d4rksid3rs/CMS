<?php
//error_reporting(-1);
//ini_set('display_errors', 'On');
require('db.class.php');
//$end_date = date('Y-m-d');
//
//$end_date = date("Y-m-d", strtotime("-1 day", strtotime($end_date)));
//
////$date_start = date ("Y-m-d",strtotime("yesterday"));
//
//$date_start = date("Y-m-d", strtotime("-7 day", strtotime($end_date)));
//
//$start_date = $date_start;
//
//$week = array();
//while (strtotime($date_start) < strtotime($end_date)) {
//    $date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
//    $week[] = $date_start;
//}

$today = date('Y-m-d');
//$today = date('2016-06-26');
$yesterday = date("Y-m-d", strtotime("-1 day", strtotime($today)));
$yesterday_start = $yesterday . ' 00:00:00';
$yesterday_end = $yesterday . ' 23:59:59';
$sql = "select type, sum(money) as sum_money from log_nap_koin "
        . "where  created_on >= '{$yesterday_start}' AND created_on <= '{$yesterday_end}' group by type";
$stmt = $db->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    foreach ($stmt as $row) {           
        $sql_insert = "INSERT INTO revenue (date_created, type, partner, k2, mv, total) VALUES ('{$yesterday}', '{$row['type']}', 'partner', '0', '0', '{$row['sum_money']}')";
        $db->exec($sql_insert);
    }
    echo 'Success !!!!';
} else {
    $sql_insert = "INSERT INTO revenue (date_created, type, partner, k2, mv, total) VALUES ('{$yesterday}', '0', 'partner', '0', '0', '0')";
    $db->exec($sql_insert);
    echo 'No Moeny for Today !!';
}
