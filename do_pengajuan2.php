<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

//$perihal = $_GET["perihal"];
//$budget = $_GET["budget"];

$idus = $_SESSION['idus'];
$periode = $_GET['periode'];
$keterangan = $_GET['keterangan'];
$jumlahunit = $_GET['jumlahunit'];
$jumlahwaktu = $_GET['jumlahwaktu'];
$biaya = $_GET['biaya'];

$total_budget = $jumlahunit * $jumlahwaktu * $biaya;

//$cek = "SELECT * FROM tb_budget where keterangan='$keterangan' and id_user='$idus' and periode='$periode'";

if($keterangan == null
or $jumlahunit == null
or $jumlahwaktu == null
or $biaya == null)
{
	header("Location: pengajuan2.php?periode=$periode");
}
else
{
	$sql = "INSERT INTO tb_budget 
	(id_budget, id_user, id_periode, keterangan, rutin, sent, approval_1, approval_2, approval_3) 
	VALUES 
	('', '$idus', '$periode', '$keterangan', '', '', '', '', '')";
	$db->query($sql);
	
	$sql2 = "SELECT id_budget FROM tb_budget WHERE id_user='$idus' AND id_periode='$periode' AND keterangan='$keterangan' ";
	$sql2a = $db->query($sql2);
	$sql2b = $sql2a->fetch_array();
	$id_budget = $sql2b['id_budget'];
	
	$sql3 = "INSERT INTO tb_budget_2
	(id_budget_2, id_user, id_periode, id_budget, jumlah_unit, jumlah_waktu, biaya, total_budget)
	VALUES
	('', '$idus', '$periode', '$id_budget', '$jumlahunit', '$jumlahwaktu', '$biaya', '$total_budget')";
	$db->query($sql3);
	
	header("Location: pengajuan2.php?periode=$periode");
}



?>