<!--logout-->
<?php
//session開始
session_start();
//sessionの中0にするリセット
$_SESSION=array();
//cookieにsession-name残ってたら
if(isset($_COOKIE[session_name()])==true)
{
	//session-nameを消す
	setcookie(session_name(),'',time()-42000,'/');
}
//sessionも消す
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

ログアウトしました。<br />
<br />
<a href="../staff_login/staff_login.html">ログイン画面へ</a>

</body>
</html>