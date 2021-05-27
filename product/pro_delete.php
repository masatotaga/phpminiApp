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
//選択されたプロダクトコードを受け取っています
$pro_code=$_GET['procode'];

//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//プロダクトコードをしぼりこむ
$sql='SELECT name,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);//準備
$data[]=$pro_code;//？に入る部分
$stmt->execute($data);//実行

//stmtからnameを取り出し$pro_nameとしておく
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_gazou_name=$rec['gazou'];
//データベース切断
$dbh=null;

//$pro_gazou_nameがなかったらパスを通した画像がないことになる
if($pro_gazou_name=='')
{
	$disp_gazou='';
}
else
//$pro_gazou_nameがあったらパスを通し$disp_gazouとする
{
	$disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
}

}
//$障害発生時
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

商品スタッフ削除<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
商品名<br />
<?php print $pro_name; ?>
<br />
<?php print $disp_gazou; ?>
<br />
この商品を削除してよろしいですか？<br />
<br />
<!--code,gazou_nameデータを持ってpro_delete_done.phpへとぶ-->
<form method="post" action="pro_delete_done.php">
<input type="hidden" name="code" value="<?php print $pro_code; ?>">
<input type="hidden" name="gazou_name" value="<?php print $pro_gazou_name; ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>