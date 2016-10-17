<?php

require('../Config.php');
require('db.class.php');

$type = $_GET['type'];
$num = 20;
if (isset($_GET['num'])) {
    $num =  $_GET['num'];
}
if ($type == 'vip') {
    $sql = "SELECT au.*, u.screen_name, u.vip, auv.sum_money FROM auth_user au JOIN user u ON au.username = u.username JOIN auth_user_vip auv ON au.id = auv.auth_user_id "
            . "ORDER BY u.vip, auv.sum_money DESC LIMIT 0, {$num} ";
} else if ($type == 'chip') {
    $sql = "SELECT au.*, u.screen_name, u.vip FROM auth_user au JOIN user u ON au.username = u.username ORDER BY au.koin_vip DESC LIMIT 0, {$num}";
}
$users = array();
foreach ($db->query($sql) as $row) {
    $users[]['username'] = $row['username'];
    $users[]['screen_name'] = $row['screen_name'];
    $users[]['vip'] = $row['vip'];
    $users[]['balancexu'] = $row['koin'];
    $users[]['balancechip'] = $row['koin_vip'];
}
$json = json_encode($users);
echo $json;