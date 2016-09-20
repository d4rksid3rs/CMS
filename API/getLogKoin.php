<?php

require('../Config.php');
require('db.class.php');
if ($_GET['username']) {
    $username = $_GET['username'];
} else {
    echo "<b>Chưa nhập Username</b>";
    exit;
}
$today = date('Y-m-d', time());
$date = '';
if (!empty($_GET['date'])) {
    if ($today != $_GET['date'])
    $date = '.' . $_GET['date'];
}
$type = $_GET['type'];
try {
    $found = false;
    include('Net/SSH2.php');

    $server = __HOST;
    $remote = "ms002";
    $password = "U6wRdEWHws4qLafWAde3";
    $command = "ps";

    $ssh = new Net_SSH2($server);
    if (!$ssh->login($remote, $password)) {
        exit('Login Failed');
    }
    if ($type == 1) {
        $cmd = "cat beme/logs/money.log$date | grep \" u_$username \" > $username.txt";
    } else if ($type == 2) {
        $cmd = "cat beme/logs/moneyvip.log$date | grep \" u_$username \" > $username.txt";
    }
    $ssh->exec($cmd);
    $log = $ssh->exec("cat $username.txt");
    $ssh->exec("rm $username.txt");
    $lines = split("\n", $log);
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>Thời điểm</td><td>Thay đổi</td><td>Giá trị mới</td><td>Lý do</td>";
    $i = 0;
    foreach ($lines as $line) {
        if (!empty($line)) {
            $part = preg_split("/[\t]/", $line);                        
            $info = explode(' ', $part[1]);
            $time = $part[0];
            $count = count($info);
            $change = $info[$count - 1];
            $new_record = $info[$count - 2];
            unset($info[$count - 1]);
            unset($info[$count - 2]);
            unset($info[$count - 3]);
            $reason = implode(' ', $info);
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $time . "</td>";
            $html .= "<td width='5%'>" . $change . "</td>";
            $html .= "<td width='5%'>" . $new_record . "</td>";
            $html .= "<td width='6%'>" . $reason . "</td>";
            $html .= "</tr>";
        }
    }
    $html .= "</table>";
    if ($found == true) {
        echo $html;
        exit;
    }
    if ($found == false) {
        echo "Không tìm thấy log!";
    }
//    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}
   