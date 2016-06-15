<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Đăng nhập</title>

<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}
	
	.login_box {
		width: 420px;
		padding: 10px;
		border: 3px solid #CCC;
		font-family:Arial, Helvetica, sans-serif;
		font-size: 10px;
		margin: 100px auto 10px auto;	
		background: #ffffff;
	}
	
	.login_title {
		font-size: 24px;
		font-weight: bold;
	}
	
	.login_text {
		font-size: 18px;
		font-weight: bold;
		color: #999;
	}
	
	.login_input {
		width: 390px;
		padding: 5px;
		margin: 2px 0 2px 0;
		border: 1px solid #999; 
		font-size: 16px;
	}
	
	.error {
		font-size: 20px;
		font-weight: bold;
		color: #C30;
	}
</style>
</head>

<body>
<form action="" method="post">
<div class="login_box">
    <span class="login_title">Beme.net.vn</span><br />
    <br />
    
    <?php $login->error_login(); ?>
    
    <span class="login_text">Tên đăng nhập</span><br />
    <input name="username" type="text" class="login_input" /><br />
    <span class="login_text">Mật khẩu</span><br />
    <input name="password" type="password" class="login_input" /><br />
	<div align="right"><input name="login" type="submit" value="Đăng nhập" /></div>
</div>
</form>
</body>
</html>