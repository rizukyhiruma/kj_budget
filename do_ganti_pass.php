<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$password = $_GET["password"];
$password2 = md5($password);
$repasswd = $_GET["repasswd"];

$username = $_SESSION["user"];
$id_user = $_SESSION["idus"];

if($password == $repasswd)
{
	$sql_update = "UPDATE tb_user 
	SET
	password = '$password2'
	WHERE
	id_user = '$id_user'
	";

	$db->query($sql_update);
	
	header("Location: logout.php");
}
else
{
	header("Location: ganti_pass.php?errmssg=error");
}



?>