<?php

require('../Config.php');
require('db.class.php');
if ($_GET['username']) {
    $username = $_GET['username'];
} else {
    echo "<b>Chưa nhập Username</b>";
}
$date = '';
if (!empty($_GET['date'])) {
    $date = '.'.$_GET['date'];
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
        $cmd = "cat beme/logs/money.log$date | grep $username > $username.txt";
    } else if ($type == 2) {
        $cmd = "cat beme/logs/moneyvip.log$date | grep $username > $username.txt";
    }
    $ssh->exec($cmd);
    $log = $ssh->exec("cat $username.txt");
    $ssh->exec("rm $username.txt");
    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}
   