<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$username = $_GET["username"];
$id_departemen = $_GET["departemen"];
$user_type = $_GET["utype"];
$password = $_GET["password"];
$password2 = md5($password);
$repasswd = $_GET["repasswd"];
$id_user = $_GET["id_user"];

if($password == $repasswd)
{
	$sql_update = "UPDATE tb_user 
	SET
	id_departemen = '$id_departemen',
	username = '$username',
	password = '$password2',
	type = '$user_type'
	WHERE
	id_user = '$id_user'
	";

	$db->query($sql_update);
	
	header("Location: user.php");
}
else
{
	header("Location: user.php?errmssg=error");
}



?>