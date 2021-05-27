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
//入力データを受け取って変数にコピー
$pro_name=$_POST['name'];
$pro_price=$_POST['price'];
$pro_gazou=$_FILES['gazou'];

//入力データに安全対策実施
$pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
$pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

//もしスタッフ名が入力されなかったら、されたら
if($pro_name=='')
{
	print '商品名が入力されていません。<br />';
}
else
{
	print '商品名:';
	print $pro_name;
	print '<br />';
}

//もし半角数字じゃなかったら
//preg_match(/正規表現パターン/,検索対象の文字列,[配列],[動作フラグ],[検索開始位置])
//matchすれば返り値１しなければ０
if(preg_match('/\A[0-9]+\z/',$pro_price)==0)
{
	print '価格をきちんと入力してください。<br />';
}
else
{
	print '価格:';
	print $pro_price;
	print '円<br />';
}

//画像ファイルチェック機能
//画像があるか
if($pro_gazou['size']>0)
{
	//画像が大きくないか
	if($pro_gazou['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		//アップロードされたファイルはまず、/tmpなどの一時フォルダに保存される
		//一時的に保存されている場所から、実際のディレクトリに移動させる関数
		move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
		print '<img src="./gazou/'.$pro_gazou['name'].'">';
		print '<br />';
	}
}

//入力に問題あったら戻るボタンだけを表示します
if($pro_name=='' || preg_match('/\A[0-9]+\z/',$pro_price)==0 || $pro_gazou['size']>1000000)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
//入力に問題がなかったらＯＫと戻るボタンを表示します。
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="pro_add_done.php">';
	//name,price,gazouのデータを送る、表示はしない
	print '<input type="hidden" name="name" value="'.$pro_name.'">';
	print '<input type="hidden" name="price" value="'.$pro_price.'">';
	print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'] .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>
</body>
</html>