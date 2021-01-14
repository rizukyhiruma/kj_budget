<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$idus = $_SESSION['idus'];
$count = $_GET['no'];
$periode = $_GET['periode'];

//periode
//keterangan
//jumlah waktu
//jumlah unit
//biaya

for($i=1;$i<=$count; $i++)
{
	$id_rutin = $_GET['id_rutin_'.$i];
	$id_budget = $_GET['id_budget_'.$i];
	$keterangan = $_GET['keterangan_'.$i];
	$jumlahwaktu = $_GET['jumlahwaktu_'.$i];
	$jumlahunit = $_GET['jumlahunit_'.$i];
	$biaya = $_GET['biaya_'.$i];
	$total_budget = $jumlahwaktu * $jumlahunit * $biaya;
	
	$sql_1 = "SELECT id_rutin FROM tb_rutin WHERE id_rutin='$id_rutin' ";
	$sql_1a = $db->query($sql_1);
	$sql_1b = $sql_1a->fetch_array();
	$id_rutin_cek = $sql_1b['id_rutin'];
	
	if($id_rutin == $id_rutin_cek)
	{
		$sql_2 = "UPDATE tb_rutin 
		SET 
		jumlah_unit='$jumlahunit'
		, jumlah_waktu='$jumlahwaktu'
		, biaya='$biaya'
		, total_budget='$total_budget'
		WHERE 
		id_rutin='$id_rutin'";
		$db->query($sql_2);
	}
	else
	{
		$sql2 = "INSERT INTO tb_rutin 
		(id_rutin, id_user, id_periode, id_budget, jumlah_unit, jumlah_waktu, biaya, total_budget) 
		VALUES 
		('', '$idus', '$periode', '$id_budget', '$jumlahunit', '$jumlahwaktu', '$biaya', '$total_budget')";
		$db->query($sql2);
	}	
}

// echo $sql_1;
// echo "<br/><br/>";
// echo $sql_2;
// echo "<br/><br/>";
// echo $count;
// break;

header("Location: pengajuan2.php?periode=$periode");

?>