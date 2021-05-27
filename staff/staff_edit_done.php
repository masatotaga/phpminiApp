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

<?php
//データベース障害ないとき
try
{
//受け取ったデータを変数に変換
$staff_code=$_POST['code'];
$staff_name=$_POST['name'];
$staff_pass=$_POST['pass'];

//安全対策
$staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
$staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//sql文を使ってコードをアップデート
$sql='UPDATE mst_staff SET name=?,password=? WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
//？に入る部分
$data[]=$staff_name;
$data[]=$staff_pass;
$data[]=$staff_code;
$stmt->execute($data);//実行

//データベース切断
$dbh=null;

}
//エラー障害時
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

修正しました。<br />
<br />
<a href="staff_list.php"> 戻る</a>

</body>
</html>