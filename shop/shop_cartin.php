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
{
//procode受け取る前の画面から
$pro_code=$_GET['procode'];

//empty=>変数が空であるかどうかを検査する isset=>変数がセットされていること、そして NULL でないことを検査する
if(isset($_SESSION['cart'])==true)
{
    //それぞれのsessionを変数に置き換えます,sessionで保存したデータを変えたいとき１回取り出す
	//ちなみに$cart,$kazuは配列の変数
	$cart=$_SESSION['cart'];
	$kazu=$_SESSION['kazu'];

    //$procodeが$cartに入っているか
	if(in_array($pro_code,$cart)==true)
	{
		print 'その商品はすでにカートに入っています。<br />';
		print '<a href="shop_list.php">商品一覧に戻る</a>';
		exit();
	}
}
//$cart,$kazuは配列変数　追加するとき　$kazu[]=1　と記述する　一番後ろのindex番号の後に追加する
//ちなみに３番目を変更したいときは　$kazu[3]=１　と記述する　配列は0から始まる
$cart[]=$pro_code;   //カートに追加します
$kazu[]=1;               //数量１で入れます 
$_SESSION['cart']=$cart;//どの画面からも見れるようにsessionに置き換えます.加工したものをsessionに戻す
$_SESSION['kazu']=$kazu;

}
//障害の時
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>