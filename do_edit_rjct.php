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
$idbud = $_GET['idbud'];

$total_budget = $jumlahunit * $jumlahwaktu * $biaya;

//$cek = "SELECT * FROM tb_budget where keterangan='$keterangan' and id_user='$idus' and periode='$periode'";

if($keterangan == null
&& $jumlahunit == null
&& $jumlahwaktu == null
&& $biaya == null)
{
	header("Location: pengajuan2.php?periode=$periode");
}
else
{
	$cek = "SELECT * FROM tb_budget WHERE id_budget = '$idbud'";
	$cek2 = $db->query($cek);
	$cek3 = $cek2->fetch_array();
	
	if($cek3['approval_1']=='2')
	{
		$sql = "UPDATE tb_budget
		SET
		approval_1 = '0'
		WHERE
		id_budget = '$idbud'
		";
		$db->query($sql);
	}
	else if($cek3['approval_2']=='2')
	{
		$sql = "UPDATE tb_budget
		SET
		approval_2 = '0'
		WHERE
		id_budget = '$idbud'
		";
		$db->query($sql);
	}
	else if($cek3['approval_3']=='2')
	{
		$sql = "UPDATE tb_budget
		SET
		approval_3 = '0'
		WHERE
		id_budget = '$idbud'
		";
		$db->query($sql);
	}
	
	$sql2 = "UPDATE tb_budget_2 
	SET
	jumlah_unit = '$jumlahunit',
	jumlah_waktu = '$jumlahwaktu',
	biaya = '$biaya',
	total_budget = '$total_budget'
	WHERE id_budget = '$idbud'
	";
	$db->query($sql2);
	
	$sql3 = "DELETE FROM tb_reject
	WHERE id_budget='$idbud'
	";
	$db->query($sql3);
	
	$sql4 = "UPDATE tb_budget
	SET
	keterangan = '$keterangan'
	WHERE
	id_budget = '$idbud'
	";
	$db->query($sql4);
	
	header("Location: pengajuan2.php?periode=$periode");
}



?>