<?php

if (isset($_GET["username"])) {
    $username = $_GET["username"];
}

require('socket.php');
$service = 0xF900;
$input = "{}";
require('db.class.php');
$content = sendMessage($service, $input);
$decode = json_decode($content, true);
var_dump($decode);die;
$current_time = date("Y-m-d H:i:s");
$sql = "INSERT INTO `user_online_history` (`type`, `dateOnline`, `online`, `times`) VALUES ('s1-All', '{$current_time}', '{$decode['online']}', '0'); ";
$db->query($sql);
if (isset($content) && strlen($content) > 1000) {
    $filename = "../sdata";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}
?>
