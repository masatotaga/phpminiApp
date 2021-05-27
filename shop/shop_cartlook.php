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

try
//障害対策
{

//sessionにcartデータが保存されていたら
if(isset($_SESSION['cart'])==true)
{
    //sessionに保存されているcartデータを変数に置き換える(sessionから取り出す)
	$cart=$_SESSION['cart'];
	$kazu=$_SESSION['kazu'];
    //cart配列に入っている要素の個数を$maxと変数をおく
	$max=count($cart);
}
else
{
    //cart配列に入っている要素の個数を0とする
	$max=0;
}

//cart配列に入っている要素の個数が0の時
if($max==0)
{
	print 'カートに商品が入っていません。<br />';
	print '<br />';
	print '<a href="shop_list.php">商品一覧へ戻る</a>';
	exit();
}
//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//データベースから配列に要素を入れるループ
//$cart配列を$key(配列の番号キー)順に$val(値)と共に処理していく
foreach($cart as $key=>$val)
{
    //データベース操作
	$sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
	$stmt=$dbh->prepare($sql);
	$data[0]=$val;
	$stmt->execute($data);

    //stmtから取り出す
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);

    //取り出したものを配列に追加していく
	$pro_name[]=$rec['name'];
	$pro_price[]=$rec['price'];
    //画像がなかったら
	if($rec['gazou']=='')
	{
        //空の画像を入れておく
		$pro_gazou[]='';
	}
	else  //画像があったら
	{
        //パスを通して変数に代入
		$pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
	}
}
//ここまでループ
//データベース切断
$dbh=null;
}
//障害時
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

カートの中身<br />
<br />
<form method="post" action="kazu_change.php">
<table border="1">
<tr>
<td>商品</td>
<td>商品画像</td>
<td>価格</td>
<td>数量</td>
<td>小計</td>
<td>削除</td>
</tr>

<!--配列から１つずつ取り出し表示
　　$pro_name配列のindex１番　=> $pro_name[1]
    $pro_name配列のindex i番　=> $pro_name[$i]
	shop_form.htmlにとぶ
-->
<?php for($i=0;$i<$max;$i++)
	{
?>
<tr>
	<td><?php print $pro_name[$i]; ?></td>
	<td><?php print $pro_gazou[$i]; ?></td>
	<td><?php print $pro_price[$i]; ?>円</td>
	<td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
	<td><?php print $pro_price[$i]*$kazu[$i]; ?>円</td>
	<td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
</tr>
<?php
	}
?>
</table>
<input type="hidden" name="max" value="<?php print $max; ?>">
<input type="submit" value="数量変更"><br />
<input type="button" onclick="history.back()" value="戻る">
</form>
<br />
<a href="shop_form.html">ご購入手続きへ進む</a><br />

</body>
</html>