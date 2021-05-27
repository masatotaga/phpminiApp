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
//障害対策
try
{
//データベースに接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//スタッフの名前を全部取得
$sql='SELECT code,name,price FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);//準備
$stmt->execute();//実行

//データベース切断
$dbh=null;

print '商品一覧<br /><br />';

//修正画面にとべるようにした
print '<form method="post" action="pro_branch.php">';
//無限ループ
while(true)
{
	//$stmtから1レコード取り出しています
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		//もうデータがなければループ脱出
		break;
	}
	//どのスタッフを選んだか分かるようにする
	print '<input type="radio" name="procode" value="'.$rec['code']. '">';
	//スタッフの名前を1レコードずつ取り出しながら表示
	print $rec['name'].'---';
	print $rec['price'].'円';
	print '<br />';
}
print '<input type="submit" name="disp" value="参照">';
print '<input type="submit" name="add" value="追加">';
print '<input type="submit" name="edit" value="修正">';
print '<input type="submit" name="delete" value="削除">';
print '</form>';

}
//障害時
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>

<br />
<a href="../staff_login/staff_top.php">トップメニューへ</a><br />

</body>
</html>