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

<?php

try
{
//選択されたスタッフコードを受け取っています
$staff_code=$_GET['staffcode'];

 //データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//スタッフコードをしぼりこむ
$sql='SELECT name FROM mst_staff WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
$data[]=$staff_code;//？に入る部分
$stmt->execute($data);//実行

//stmtからnameを取り出し$staff_nameとしておく
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$staff_name=$rec['name'];
//データベース切断
$dbh=null;

}
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

スタッフ削除<br />
<br />
スタッフコード<br />
<?php print $staff_code; ?>
<br />
スタッフ名<br />
<?php print $staff_name; ?>
<br />
このスタッフを削除してよろしいですか？<br />
<br />
<!--codeのデータを持ってstaff_delete_done.phpへとぶ
valueで文字を表示-->
<form method="post" action="staff_delete_done.php">
<input type="hidden"name="code" value="<?php print $staff_code; ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>