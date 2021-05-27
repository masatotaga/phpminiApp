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
//入力データを受け取って変数にコピー
$staff_name=$_POST['name'];
$staff_pass=$_POST['pass'];
$staff_pass2=$_POST['pass2'];

//入力データに安全対策実施
$staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
$staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');
$staff_pass2=htmlspecialchars($staff_pass2,ENT_QUOTES,'UTF-8');

//もしスタッフ名が入力されなかったら、されたら
if($staff_name=='')
{
	print 'スタッフ名が入力されていません。<br />';
}
else
{
	print 'スタッフ名：';
	print $staff_name;
	print '<br />';
}

//もしパスワードが入力されなかったら
if($staff_pass=='')
{
	print 'パスワードが入力されていません。<br />';
}

//もしパスワードが一致されなかったら
if($staff_pass!=$staff_pass2)
{
	print 'パスワードが一致しません。<br />';
}

//入力に問題あったら戻るボタンだけを表示します
if($staff_name=='' || $staff_pass=='' || $staff_pass!=$staff_pass2)
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
//入力に問題がなかったらＯＫと戻るボタンを表示します。
else
{
	//パスワード暗号化
	$staff_pass=md5($staff_pass);
	print '<form method="post" action="staff_add_done.php">';
	print '<input type="hidden" name="name" value="'.$staff_name.'">';
	print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>

</body>
</html>