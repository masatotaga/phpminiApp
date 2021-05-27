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

//スタッフコードでしぼりこんでいる
$sql='SELECT name FROM mst_staff WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
$data[]=$staff_code;//？に入る部分
$stmt->execute($data);//実行

//stmtから取り出しスタッフ名を変数にコピー
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

スタッフ修正<br />
<br />
スタッフコード<br />
<?php print $staff_code; ?>
<br />
<br />
<!--actionリンク先 name送るデータ valueテキスト表示-->
<form method="post" action="staff_edit_check.php">
<input type="hidden"name="code" value="<?php print $staff_code; ?>">
スタッフ名<br />
<input type="text" name="name" style="width:200px" value="<?php print $staff_name; ?>"><br />
パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう1度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>