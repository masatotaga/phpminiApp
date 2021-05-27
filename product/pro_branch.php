<?php
//loginチェック
session_start();//session開始
session_regenerate_id(true);//loginID新しく入れ替え
if(isset($_SESSION['login'])==false)//sessionにlogin変数が入っていなかったら
{
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}

//もし$_POSTにdisp変数があったら
if(isset($_POST['disp'])==true)
{
	//スタッフを選んでいなかったら(procode変数がなかったら)
	if(isset($_POST['procode'])==false)
	{
		//NG画面へとぶ
		header('Location:pro_ng.php');
		exit();
	}
	//スタッフコードともに参照画面へとぶ
	$pro_code=$_POST['procode'];
	header('Location:pro_disp.php?procode='.$pro_code);
	exit();
}

//もし$_POSTにadd変数があったら
if(isset($_POST['add'])==true)
{
	//追加画面へとぶ
	header('Location:pro_add.php');
	exit();
}

//もしPOSTにeditがあったら
if(isset($_POST['edit'])==true)
{
	//スタッフを選ばなかったら(procode変数がなかったら)
	if(isset($_POST['procode'])==false)
	{
		//NG画面へとぶ
		header('Location:pro_ng.php');
		exit();
	}
	//$pro_codeをもってスタッフ修正画面へとぶ
	$pro_code=$_POST['procode'];
	header('Location:pro_edit.php?procode='.$pro_code);
	exit();
}

//もし$_POSTにdeleteがあったら
if(isset($_POST['delete'])==true)
{
	//スタッフを選ばなかったら(procode変数がなかったら)
	if(isset($_POST['procode'])==false)
	{
		//NG画面へ飛ぶ
		header('Location:pro_ng.php');
		exit();
	}
	 //$pro_codeをもってスタッフ削除画面へとぶ
	$pro_code=$_POST['procode'];
	header('Location:pro_delete.php?procode='.$pro_code);
	exit();
}

?>