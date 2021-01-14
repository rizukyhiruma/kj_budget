<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$id_user = $_GET['id_user'];
$id_periode = $_GET['id_periode'];

$send = "UPDATE tb_budget SET sent = '1' WHERE id_user='$id_user' AND id_periode='$id_periode' ";
$db->query($send);

$cek_tbapp = "SELECT * FROM tb_approval WHERE id_user = '$id_user' AND id_periode = '$id_periode'";
$cek_tbapp2 = $db->query($cek_tbapp);
$cek_tbapp3 = $cek_tbapp2->fetch_array();

if($cek_tbapp3 != null)
{
	$send2 = "UPDATE tb_approval 
	SET sent = '1'
	WHERE id_user='$id_user' AND id_periode='$id_periode'
	";
	$db->query($send2);
}
else
{
	$send2 = "INSERT INTO tb_approval 
	(id_approval, id_user, id_periode, sent, approval_1, approval_2, approval_3) 
	VALUES 
	('', '$id_user', '$id_periode', '1', '0', '0', '0')";
	$db->query($send2);
}

header("Location: pengajuan2.php?periode=$id_periode");
?>