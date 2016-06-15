<?php
require('../Config.php');
try {
	$redis = new Redis();
	$redis->connect('127.0.0.1');
	$redis->del("obatigol82");
	$redis->del("ochoapp");
	$redis->close();
} catch (Exception $e){
	echo $e->getMessage();
}
?>
