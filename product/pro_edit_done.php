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
//データベース障害対策
try
{
//前の画面から受け取った入力データを変数にコピー
$pro_code=$_POST['code'];
$pro_name=$_POST['name'];
$pro_price=$_POST['price'];
$pro_gazou_name_old=$_POST['gazou_name_old'];
$pro_gazou_name=$_POST['gazou_name'];

//入力データに安全対策を実施
$pro_code=htmlspecialchars($pro_code,ENT_QUOTES,'UTF-8');
$pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
$pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

//データベースに接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//sql文を使ってコードを追加
$sql='UPDATE mst_product SET name=?,price=?,gazou=? WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
//？に入る部分
$data[]=$pro_name;
$data[]=$pro_price;
$data[]=$pro_gazou_name;
$data[]=$pro_code;
$stmt->execute($data);//実行

//データベースから切断します。
$dbh=null;

//もし古い画像があれば削除します
//元の画像と新しく追加した画像一致しない
if($pro_gazou_name_old!=$pro_gazou_name)
{
	//元の画像が存在していたら
	if($pro_gazou_name_old!='')
	{
		//元の画像を削除
		unlink('./gazou/'.$pro_gazou_name_old);
	}
}
//修正しました。
print '修正しました。<br />';

}
//データベース障害発生時
catch(Exception$e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>
<!--スタッフ一覧画面へ戻る-->
<a href="pro_list.php">戻る</a>

</body>
</html>