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
<title>ろくまる農園</title>
</head>
<body>
<!--入力ホーム-->
商品追加<br />
<br />
<!--enctype="multipart/form-data"アップロードする時のデータの種類-->
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
商品名を入力してください。<br />
<input type="text" name="name" style="width:200px"><br />
価格を入力してください。<br />
<input type="text" name="price" style="width:50px"><br />
画像を選んでください。<br />
<input type="file" name="gazou" style="width:400px"><br />
<br />
<!--戻るボタンとＯＫボタン-->
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>