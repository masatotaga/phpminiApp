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
else  //sessionIDがmember_loginであったら
{
	print 'ようこそ';
	print $_SESSION['member_name'];
	print '様　';
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
//障害対策
try
{
//procode受け取る前の画面から
$pro_code=$_GET['procode'];

//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//データベース操作
$sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
$data[]=$pro_code;//?に入れるデータ $data配列に追加
$stmt->execute($data);//実行

//stmtから取り出す
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
//取り出したものをそれぞれ変数に置く
$pro_name=$rec['name'];
$pro_price=$rec['price'];
$pro_gazou_name=$rec['gazou'];

//データベース切断
$dbh=null;

//画像がなかったら
if($pro_gazou_name=='')
{
    //空の画像を入れておく
	$disp_gazou='';
}
else  //画像があったらパスを通して変数に代入
{
	$disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
}
//procodeを持ってカートインにとぶ
print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';

}
//障害の時
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

商品情報参照<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
商品名<br />
<?php print $pro_name; ?>
<br />
価格<br />
<?php print $pro_price; ?>円
<br />
<?php print $disp_gazou; ?>
<br />
<br />
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>