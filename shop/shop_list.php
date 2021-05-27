<?php
//session開始
session_start();
//現在のセッションIDを新しく生成したものと置き換える
session_regenerate_id(true);
//sessionIDがmember_loginでなかったら
if(isset($_SESSION['member_login'])==false)
{
	print 'ようこそゲスト様　';
	print '<a href="member_login.html">会員ログイン</a><br />';
	print '<br />';
}
else //sessionIDがmember_loginであったら
{
	print 'ようこそ';
	print $_SESSION['member_name'];
	print ' 様　';
	print '<a href="member_logout.php">ログアウト</a><br />';
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
//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//データベース操作
$sql='SELECT code,name,price FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

//データベース切断
$dbh=null;

print '商品一覧<br /><br />';

//ループ
while(true)
{
	//stmtから取り出す
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		//取り出すものがなくなったらbreak
		break;
	}
	print '<a href="shop_product.php?procode='.$rec['code'].'">'; //dataをもったリンク
	print $rec['name'].'---';  //みかん---
	print $rec['price'].'円';  //120円
	print '</a>';  //リンク閉じ
	print '<br />';  //次のやつの前に改行
}
//ここまでループ

//カートにとぶリンク
print '<br />';
print '<a href="shop_cartlook.php">カートを見る</a><br />';

}
//障害の時
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>

</body>
</html>