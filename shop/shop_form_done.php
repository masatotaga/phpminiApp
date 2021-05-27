<?php
	session_start();  //sessionスタート
	session_regenerate_id(true);  //session新しいの切り替え
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
//共通関数
require_once('../common/common.php');
//安全対策のメゾット引っ張て来て前のデータ受け取る
$post=sanitize($_POST);

//各々データ受け取る
$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];

//各々表示
print $onamae.'様<br />';
print 'ご注文ありがとうござました。<br />';
print $email.'にメールを送りましたのでご確認ください。<br />';
print '商品は以下の住所に発送させていただきます。<br />';
print $postal1.'-'.$postal2.'<br />';
print $address.'<br />';
print $tel.'<br />';

//自動返信メール文章の本文(配列みたいに追加していってる)
$honbun='';  //空っぽをコピーして初期化
$honbun.=$onamae."様\n\nこのたびはご注文ありがとうございました。\n";
$honbun.="\n";
$honbun.="ご注文商品\n";
$honbun.="--------------------\n";

//ここから注文した商品の情報
//sessionに保存されたデータを変数に置き換える
$cart=$_SESSION['cart'];
$kazu=$_SESSION['kazu'];
$max=count($cart);

//データベース接続
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//データベース操作
//数量分だけループ
for($i=0;$i<$max;$i++)
{
	$sql='SELECT name,price FROM mst_product WHERE code=?';
	$stmt=$dbh->prepare($sql);
	$data[0]=$cart[$i];
	$stmt->execute($data);

    //stmtから取り出したものをそれぞれ変数におとしていく
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);

	$name=$rec['name'];
	$price=$rec['price'];
	$kakaku[]=$price;
	$suryo=$kazu[$i];
	$shokei=$price*$suryo;

    //メール本文の内容に追加していく
	$honbun.=$name.' ';
	$honbun.=$price.'円 x ';
	$honbun.=$suryo.'個 = ';
	$honbun.=$shokei."円\n";
}

//一連のデータ処理の前にロックをかけ安全に処理が行えるようにする
//ロックをかけた２つのテーブルにアクセスできるのはロックをかけた人だけ
$sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE';
$stmt=$dbh->prepare($sql);
$stmt->execute();

//注文データをデータベース(過去のものが蓄積されている)に追加するプログラム
$sql='INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data=array(); //いったん配列の中身をクリア
$data[]=0;
$data[]=$onamae;
$data[]=$email;
$data[]=$postal1;
$data[]=$postal2;
$data[]=$address;
$data[]=$tel;
$stmt->execute($data);

//最新の日時(直近)の番号(code)を取得し、変数$lastcodeに入れておく
$sql='SELECT LAST_INSERT_ID()'; //今追加されたばかりのcodeを取得
$stmt=$dbh->prepare($sql);
$stmt->execute();
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$lastcode=$rec['LAST_INSERT_ID()']; //変数におとしこむ

//注文明細をデータベース(過去のものが蓄積されている)に追加するプログラム
for($i=0;$i<$max;$i++)
{
	$sql='INSERT INTO dat_sales_product (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
	$stmt=$dbh->prepare($sql);
	$data=array(); //いったん配列の中身をクリア
	$data[]=$lastcode;
	$data[]=$cart[$i];
	$data[]=$kakaku[$i];
	$data[]=$kazu[$i];
	$stmt->execute($data);
}
//ロックを解除
$sql='UNLOCK TABLES';
$stmt=$dbh->prepare($sql);
$stmt->execute();
//ここまでが注文した商品の情報

//データベース切断
$dbh=null;

//ここから振込先のご案内やお店の情報
//メール本文の続き
$honbun.="送料は無料です。\n";
$honbun.="--------------------\n";
$honbun.="\n";
$honbun.="代金は以下の口座にお振込ください。\n";
$honbun.="ろくまる銀行 やさい支店 普通口座 １２３４５６７\n";
$honbun.="入金確認が取れ次第、梱包、発送させていただきます。\n";
$honbun.="\n";
$honbun.="□□□□□□□□□□□□□□\n";
$honbun.="　～安心野菜のろくまる農園～\n";
$honbun.="\n";
$honbun.="○○県六丸郡六丸村123-4\n";
$honbun.="電話 090-6060-xxxx\n";
$honbun.="メール info@rokumarunouen.co.jp\n";
$honbun.="□□□□□□□□□□□□□□\n";
print '<br />';
print nl2br($honbun);

$title='ご注文ありがとうございます。'; //メールのタイトル
$header='From:info@rokumarunouen.co.jp'; //送信元(お店側のメールアドレス)
//HTML エンティティを対応する文字に変換する
//html_entity_decode ( string $string , int $flags = ENT_COMPAT , string|null $encoding = null ) : string
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese'); //言語
mb_internal_encoding('UTF-8'); //文字コード
mb_send_mail($email,$title,$honbun,$header); //メールを送信する命令

$title='お客様からご注文がありました。'; //メールのタイトル
$header='From:'.$email; //送信元(お客様のメールアドレス)
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese'); //言語
mb_internal_encoding('UTF-8');  //文字コード
mb_send_mail('info@rokumarunouen.co.jp',$title,$honbun,$header); //メールを送信する命令

}
//障害時
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

<br />
<a href="shop_list.php">商品画面へ</a>

</body>
</html>