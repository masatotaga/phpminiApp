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

try
{
//codeを取得し変数に置き換える
$pro_code=$_POST['code'];
$pro_gazou_name=$_POST['gazou_name'];

//データベースに接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//削除するものを取り出し実行
$sql='DELETE FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
$data[]=$pro_code;//？に入る部分
$stmt->execute($data);//実行

//データベース切断
$dbh=null;

//もし画像があったら削除
if($pro_gazou_name!='')
{
	unlink('./gazou/'.$pro_gazou_name);
}

}
//障害発生時
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

削除しました。<br />
<br />
<a href="pro_list.php"> 戻る</a>

</body>
</html>