<?php
//loginチェック
session_start();//session開始
session_regenerate_id(true);//loginID新しく入れ替え
if(isset($_SESSION['login'])==false)//sessionにlogin変数が入っていなかったら
{
	print 'ログインされていません<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}

//もし$_POSTにdisp変数が存在したら
if(isset($_POST['disp'])==true)
{
	//もし$_POSTにstaffcode変数が存在しなかったら
	if(isset($_POST['staffcode'])==false)
	{
		//NG画面へとぶ
		header('Location:staff_ng.php');
		exit();
	}
	//スタッフコードともに参照画面へとぶ
	$staff_code=$_POST['staffcode'];
	header('Location:staff_disp.php?staffcode='.$staff_code);
	exit();
}

//もし$_POSTにadd変数が存在したら
if(isset($_POST['add'])==true)
{
	//追加画面へとぶ
	header('Location:staff_add.php');
	exit();
}

//もし$_POSTにedit変数が存在したら
if(isset($_POST['edit'])==true)
{
	//もし$_POSTにstaffcode変数が存在しなかったら
	if(isset($_POST['staffcode'])==false)
	{
		//NG画面へとぶ
		header('Location:staff_ng.php');
		exit();
	}
	//スタッフコードともにスタッフ修正画面へとぶ
	$staff_code=$_POST['staffcode'];
	header('Location:staff_edit.php?staffcode='.$staff_code);
	exit();
}

//もし$_POSTにdelete変数が存在したら
if(isset($_POST['delete'])==true)
{
	//もし$_POSTにstaffcode変数が存在しなかったら
	if(isset($_POST['staffcode'])==false)
	{
		//NG画面へ飛ぶ
		header('Location:staff_ng.php');
		exit();
	}
	//スタッフコードともにスタッフ削除画面へとぶ
	$staff_code=$_POST['staffcode'];
	header('Location:staff_delete.php?staffcode='.$staff_code);
	exit();
}

?>