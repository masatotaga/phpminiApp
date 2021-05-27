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

//プロダクトコードでしぼりこんでいる
$sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$stmt->execute($data);

//stmtから取り出しスタッフ名を変数にコピー
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_price=$rec['price'];
$pro_gazou_name_old=$rec['gazou'];

//データベース切断
$dbh=null;

//$pro_gazou_name_oldがなかったら$disp_gazouもないことにする
if($pro_gazou_name_old=='')
{
	$disp_gazou='';
}
else
{
	//$pro_gazou_name_oldがあったらパスを通したものを$disp_gazouにする
	$disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
}

}
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

商品修正<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
<br />
<!--enctype="multipart/form-data"アップロードする時のデータの種類
   input type においてhiddenとtextの違いを考える-->
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?php print $pro_code; ?>">
<input type="hidden" name="gazou_name_old" value="<?php print $pro_gazou_name_old; ?>">
商品名<br />
<input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br />
価格<br />
<input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>">円<br />
<br />
<?php print $disp_gazou; ?>
<br />
画像を選んでください。<br />
<input type="file" name="gazou" style="width:400px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>