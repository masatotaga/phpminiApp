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
//データベース障害対策
try
{
//前の画面から受け取った入力データを変数にコピー
$staff_name=$_POST['name'];
$staff_pass=$_POST['pass'];

//入力データに安全対策を実施
$staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
$staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

//データベースに接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//sql文を使ってコードを追加
$sql='INSERT INTO mst_staff (name,password) VALUES (?,?)';
$stmt=$dbh->prepare($sql);//準備
//？に入る部分
$data[]=$staff_name;
$data[]=$staff_pass;
$stmt->execute($data);//実行

//データベースから切断します。
$dbh=null;

//○○さんを追加しました。
print $staff_name;
print 'さんを追加しました。<br />';

}
//データベース障害発生時
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>
<!--スタッフ一覧画面へ戻る-->
<a href="staff_list.php"> 戻る</a>

</body>
</html>