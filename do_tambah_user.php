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
	$sql_update = "INSERT INTO tb_user 
	(id_user, id_departemen, username, password, type)
	VALUES
	('', '$id_departemen', '$username', '$password2', '$user_type')
	";

	$db->query($sql_update);

	header("Location: user.php");
}
else
{
	header("Location: user.php?errmssg=error");
}

?>