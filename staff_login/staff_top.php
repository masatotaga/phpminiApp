<!--loginチェック-->
<?php
session_start();//session開始
session_regenerate_id(true);//loginID新しく入れ替え
if(isset($_SESSION['login'])==false)//sessionにlogin変数が入っていなかったら
{
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}
else
{
	print $_SESSION['staff_name'];//sessionに保存されているstaff_nameデータを呼び起こす
	print 'さんログイン中<br />';
	print '<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> ろくまる農園</title>
</head>
<body>

ショップ管理トップメニュー<br />
<br />
<a href="../staff/staff_list.php">スタッフ管理</a><br />
<br />
<a href="../product/pro_list.php">商品管理</a><br />
<br />
<a href="../order/order_download.php">注文ダウンロード</a><br />
<br/>
<a href="staff_logout.php">ログアウト</a><br />

</body>
</html>