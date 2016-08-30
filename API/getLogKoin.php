<?php

require('../Config.php');
require('db.class.php');
$username = $_GET['username'];
echo $username;


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
    $ssh->exec("cat beme/logs/money.log | grep $username > $username.txt");
    $log = $ssh->exec("cat $username.txt");
    $ssh->exec("rm $username.txt");
    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}
   