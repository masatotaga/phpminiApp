<?php

try
{
//コードを受け取る
$staff_code=$_POST['code'];
$staff_pass=$_POST['pass'];

//安全化
$staff_code=htmlspecialchars($staff_code,ENT_QUOTES,'UTF-8');
$staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

//パスワード文字替え
$staff_pass=md5($staff_pass);

//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//codeとpassのデータとってくる（かつ）
$sql='SELECT name FROM mst_staff WHERE code=? AND password=?';
$stmt=$dbh->prepare($sql);
$data[]=$staff_code;
$data[]=$staff_pass;
$stmt->execute($data);

//データベース切断
$dbh=null;

//stmtから取り出す
$rec=$stmt->fetch(PDO::FETCH_ASSOC);

//コードとパスうまく取り出せてない＝間違った入力だったら」
if($rec==false)
{
	print 'スタッフコードかパスワードが間違っています。<br />';
	print '<a href="staff_login.html"> 戻る</a>';
}
//上手くコードとパスがあったら
else
{
	session_start();//session開始
	//sessionにデータ保存
	$_SESSION['login']=1;
	$_SESSION['staff_code']=$staff_code;
	$_SESSION['staff_name']=$rec['name'];
	//Location:staff_top.phpへとぶ
	header('Location:staff_top.php');
	exit();
}

}
//障害時
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>