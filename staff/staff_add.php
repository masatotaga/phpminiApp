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
	print $_SESSION['staff_name'];//sessionにlogin変数が入っていなかったら
	print 'さんログイン中<br />';
	print '<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>
<!--入力ホーム-->
スタッフ追加<br />
<br />
<!--name,pass,pass2データを持ってstaff_add_check.phpへとぶ-->
<form method="post" action="staff_add_check.php">
スタッフ名を入力してください。<br />
<input type="text" name="name" style="width:200px"><br />
パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう１度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />
<!--戻るボタンとＯＫボタン-->
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>