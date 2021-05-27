<?php
//session開始
session_start();
//session変数を空っぽにする
$_SESSION=array();
//session_nameがcookie側に保存されていたら(基本sessionはcookieにも保存される)
if(isset($_COOKIE[session_name()])==true)
{
    //パソコン側のセッションid(合言葉)をクッキーから削除
	setcookie(session_name(),'',time()-42000,'/');
}
//セッションを破壊する(サーバーと自分のパソコンの関係を断ち切る)
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

カートを空にしました。<br />

</body>
</html>