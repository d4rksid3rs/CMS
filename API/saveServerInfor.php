<?php
$username = $_GET["username"];

require('socket.php');
$service = 0xF900;
$input = "{}";

$content = sendMessage($service, $input);
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
