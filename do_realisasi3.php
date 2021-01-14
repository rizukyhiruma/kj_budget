<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$id_budget = $_GET['id_budget'];
$id_periode = $_GET['id_periode'];
$keterangan1 = $_GET['keterangan1'];
$keterangan2 = $_GET['keterangan2'];
$keterangan3 = $_GET['keterangan3'];
$keterangan4 = $_GET['keterangan4'];
$biaya = $_GET['biaya'];
$total_budget = $_GET['total_budget'];
$id_budget_2 = $_GET['id_budget_2'];

if($keterangan1!=null and $biaya!=null)
{
	$sql = "INSERT INTO tb_realisasi
	(id_realisasi, id_budget, keterangan_1, keterangan_2, keterangan_3, keterangan_4, biaya, total_realisasi)
	VALUES
	('', '$id_budget', '$keterangan1', '$keterangan2', '$keterangan3', '$keterangan4', '$biaya', '')
	";
	$db->query($sql);
	
	$sql2 = "SELECT SUM(biaya) AS total FROM tb_realisasi where id_budget='$id_budget'";
	$sql2a = $db->query($sql2);
	$sql2b = $sql2a->fetch_array();
	$sql2c = $sql2b['total'];
	
	$selisih = $total_budget - $sql2c;
	
	$sql3 = "UPDATE tb_budget_2
			SET
			realisasi = '$sql2c',
			selisih  = '$selisih'
			WHERE 
			id_periode = '$id_periode'
			AND
			id_budget_2 = '$id_budget_2'
			AND
			id_budget = '$id_budget'
			";
	$db->query($sql3);
	
	header("Location: realisasi3.php?id_budget=$id_budget&id_periode=$id_periode");
}

?>