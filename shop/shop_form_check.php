<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php
//共通関数読み込み
require_once('../common/common.php');

//安全対策(設定した関数使っている)
$post=sanitize($_POST);

//お客様が入力したデータを変数にコピー
$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];

//入力ミスをしたら$okflgフラグをfalseにする
$okflg=true;

//入力されているかチェック
if($onamae=='')
{
	print 'お名前が入力されていません。<br /><br />';
	$okflg=false;
}
else
{
	print 'お名前<br />';
	print $onamae;
	print '<br /><br />';
}

//メールアドレスのチェックの正規表現
if(preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0)
{
	print 'メールアドレスを正確に入力してください。<br /><br />';
	$okflg=false;
}
else
{
	print 'メールアドレス<br />';
	print $email;
	print '<br /><br />';
}

//郵便番号の前半のチェックの正規表現
if(preg_match('/\A[0-9]+\z/',$postal1)==0)
{
	print '郵便番号は半角数字で入力してください。<br /><br />';
	$okflg=false;
}
else
{
	print '郵便番号<br />';
	print $postal1;
	print '-';
	print $postal2;
	print '<br /><br />';
}

//郵便番号の後半のチェックの正規表現
if(preg_match('/\A[0-9]+\z/',$postal2)==0)
{
	print '郵便番号は半角数字で入力してください。<br /><br />';
	$okflg=false;
}

//addressがなかったら
if($address=='')
{
	print '住所が入力されていません。<br /><br />';
	$okflg=false;
}
else
{
	print '住所<br />';
	print $address;
	print '<br /><br />';
}

//電話番号のチェックの正規表現
if(preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/',$tel)==0)
{
	print '電話番号を正確に入力してください。<br /><br />';
	$okflg=false;
}
else
{
	print '電話番号<br />';
	print $tel;
	print '<br /><br />';
}

//入力ミスがなければデータを送るOKボタンを作る(ちなみにOKボタンだけでこの量)
if($okflg==true)
{
	//フォーム
	print '<form method="post" action="shop_form_done.php">';
	//送るデータ(hidden見えない)
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	//戻るボタン
	print '<input type="button" onclick="history.back()" value="戻る">';
	//OKボタン
	print '<input type="submit" value="ＯＫ"><br />';
	print '</form>';
}
else
{
	//入力ミスあったら戻るボタンだけ作成
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}

?>

</body>
</html>