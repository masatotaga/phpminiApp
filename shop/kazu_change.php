<?php
	session_start(); //sessionを開始
	session_regenerate_id(true); //現在のセッションIDを新しく生成したものと置き換える

	require_once('../common/common.php'); //共通関数を読み込む

	$post=sanitize($_POST); //安全対策を実施し$postにコピー

	$max=$post['max']; //商品の数を$maxにコピー
	for($i=0;$i<$max;$i++) //$postから$kazuの配列(各商品の個数をまとめた配列)を作成 (ループ開始)
	{
		if(preg_match("/\A[0-9]+\z/", $post['kazu'.$i])==0) //$post['kazu'.$i]が先頭から最後まで0~9であった場合
		{
			print '数量に誤りがあります。';
			print '<a href="shop_cartlook.php">カートに戻る</a>';
			exit();
		}
		if($post['kazu'.$i]<1 || 10<$post['kazu'.$i]) //カートの中身の数が１より小さいもしくは１０より大きい
		{
			print '数量は必ず1個以上、10個までです。';
			print '<a href="shop_cartlook.php">カートに戻る</a>';
			exit();
		}
		$kazu[]=$post['kazu'.$i]; //前の画面で入力された数量を配列に入れていく　(ループここまで)
	}

	$cart=$_SESSION['cart']; //sessionに含まれるcartを変数に置き換える

	for($i=$max;0<=$i;$i--) //商品の数分だけループ
	{
		if(isset($_POST['sakujo'.$i])==true) //削除ボタンを押したら 変数の値sakujoが存在したら
		{
			array_splice($cart,$i,1); //array_splice ( $配列, $開始位置[, $削除する要素の数 [, $置き換える要素を含んだ配列 ]] )
			array_splice($kazu,$i,1);
		}
	}

	$_SESSION['cart']=$cart; //cartとkazuをsessionに戻す
	$_SESSION['kazu']=$kazu;

	header('Location:shop_cartlook.php'); //shop_cartlook.phpへとぶ
?>