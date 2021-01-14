<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$idus = $_SESSION['idus'];
$periode = $_GET['periode'];
$keterangan = $_GET['keterangan'];

$cek = "SELECT * FROM tb_budget WHERE keterangan='$keterangan' AND id_user='$idus'";
$cek2 = $db->query($cek);
$cek3 = $cek2->fetch_array();

$keterangan2 = $cek3['keterangan'];

if($keterangan == null)
{
	header("Location: pengajuan2.php?periode=$periode");
}
else if($keterangan == $keterangan2)
{
	header("Location: pengajuan2.php?periode=$periode");
}
else
{
	$sql1 = "INSERT INTO tb_budget 
	(id_budget, id_user, id_periode, keterangan, rutin, sent, approval_1, approval_2, approval_3) 
	VALUES 
	('', '$idus', '$periode', '$keterangan', '1', '', '', '', '')";
	$db->query($sql1);
	
	$sql1_2a = "SELECT id_budget FROM tb_budget 
	WHERE id_user='$idus' 
	AND id_periode='$periode' 
	AND keterangan='$keterangan'";
	$sql1_2b = $db->query($sql1_2a);
	$sql1_2c = $sql1_2b->fetch_array();
	
	$idbudget = $sql1_2c['id_budget'];
	
	$sql2 = "INSERT INTO tb_rutin 
	(id_rutin, id_user, id_periode, id_budget, jumlah_unit, jumlah_waktu, biaya, total_budget) 
	VALUES 
	('', '$idus', '$periode', '$idbudget', '', '', '', '')";
	$db->query($sql2);
	
	header("Location: pengajuan2.php?periode=$periode");
}
?>