<?php

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
//$today = date('2016-06-24');
$yesterday = date("Y-m-d", strtotime("-1 day", strtotime($today)));
$yesterday_start = $yesterday. ' 00:00:00';
$yesterday_end = $yesterday. ' 23:59:59';
$sql = "select * from request "
        . "where  created_on >= '{$yesterday_start}' AND created_on <= '{$yesterday_end}' and success > 0";
$total = 0;
foreach ($db->query($sql) as $row) {    
    $total = $total + $row['cardvalue'];
}
$sql_insert = "INSERT INTO revenue (date_created, type, partner, k2, mv, total) VALUES ('{$yesterday}', '2', 'partner', '0', '0', '{$total}')";
$result = $db->exec($sql_insert);
if ($result) {
    echo "Get Revenue success !!!!!!!";
} else {
    echo "Get Revenue failed  ???????";
}