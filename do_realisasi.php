<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$no = $_GET['no'];
$id_periode = $_GET['id_periode'];

for($i='1'; $i<=$no; $i++)
{
	$total_budget = $_GET['total_budget_'.$i];
	$realisasi = $_GET['realisasi_'.$i];
	$total_budget = $_GET['total_budget_'.$i];
	$id_budget = $_GET['id_budget_'.$i];
	$id_budget_2 = $_GET['id_budget_2_'.$i];
	
	$cek_realisasi = "SELECT realisasi FROM tb_budget_2 
					WHERE 
					id_periode = '$id_periode'
					AND
					id_budget_2 = '$id_budget_2'
					AND
					id_budget = '$id_budget'";
	$cek_realisasi2 = $db->query($cek_realisasi);
	$cek_realisasi3 = $cek_realisasi2->fetch_array();
	$cek_realisasi4 = $cek_realisasi3['realisasi'];

	if($cek_realisasi4 == NULL)
	{
		if($realisasi==null)
		{
			$sql = "UPDATE tb_budget_2
				SET
				realisasi = '',
				selisih  = ''
				WHERE 
				id_periode = '$id_periode'
				AND
				id_budget_2 = '$id_budget_2'
				AND
				id_budget = '$id_budget'
				";
		}
		else
		{
			$selisih = $total_budget - $realisasi;
			$sql = "UPDATE tb_budget_2
				SET
				realisasi = '$realisasi',
				selisih  = '$selisih'
				WHERE 
				id_periode = '$id_periode'
				AND
				id_budget_2 = '$id_budget_2'
				AND
				id_budget = '$id_budget'
				";
		}
	}
	else if($cek_realisasi4 != NULL)
	{
		$selisih = $total_budget - $cek_realisasi4;
		$sql = "UPDATE tb_budget_2
				SET
				realisasi = '$cek_realisasi4',
				selisih  = '$selisih'
				WHERE 
				id_periode = '$id_periode'
				AND
				id_budget_2 = '$id_budget_2'
				AND
				id_budget = '$id_budget'
				";
	}
	//echo $sql;
	//echo "<br/><br/>";
	$db->query($sql);
}

//break;

header("Location: realisasi2.php?periode=$id_periode");

?>
