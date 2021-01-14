<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$id_realisasi = $_GET['id_realisasi'];
$id_budget = $_GET['id_budget'];
$id_periode = $_GET['id_periode'];

$sql = "SELECT *
		FROM tb_budget
		JOIN tb_budget_2 ON tb_budget_2.id_budget = tb_budget.id_budget
		JOIN tb_realisasi ON tb_budget.id_budget = tb_realisasi.id_budget
		WHERE tb_realisasi.id_realisasi = '$id_realisasi'
		";
$sql2 = $db->query($sql);
$sql3 = $sql2->fetch_array();

$id_budget_2 = $sql3['id_budget_2'];

$realisasi = $sql3['realisasi'] - $sql3['biaya'];

$selisih = $sql3['total_budget'] - $realisasi;
	
$sql_update = "UPDATE tb_budget_2
		SET
		realisasi = '$realisasi',
		selisih  = '$selisih'
		WHERE
		id_budget_2 = '$id_budget_2'
		AND		
		id_periode = '$id_periode'
		AND
		id_budget = '$id_budget'
		";
$db->query($sql_update);

$delete = "DELETE FROM tb_realisasi WHERE id_realisasi='$id_realisasi'";
$db->query($delete);
	
/* echo "id realisasi: ".$id_realisasi;
echo "<br/>";
echo "id budget: ".$id_budget;
echo "<br/>";
echo "id periode: ".$id_periode;
echo "<br/>";
echo "delete1: ".$delete1;
echo "<br/>";
echo "sql: ".$sql;
echo "<br/>";
echo "id bud 2: ".$id_budget_2;
echo "<br/>";
echo "realisasi: ".$realisasi;
echo "<br/>";
echo "selisih: ".$selisih;
echo "<br/>";
echo "sql update: ".$sql_up;

break; */

header("Location: realisasi3.php?id_budget=$id_budget&id_periode=$id_periode");
?>