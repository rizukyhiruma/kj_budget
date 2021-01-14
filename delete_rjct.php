<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$id_budget = $_GET['id_budget'];
$id_periode = $_GET['id_periode'];

$delete1 = "DELETE FROM tb_budget WHERE id_budget='$id_budget'";
$db->query($delete1);

$delete2 = "DELETE FROM tb_budget_2 WHERE id_budget='$id_budget'";
$db->query($delete2);

$delete3 = "DELETE FROM tb_reject WHERE id_budget='$id_budget'";
$db->query($sql3);

$delete4 = "DELETE FROM tb_approval WHERE id_budget='$id_budget'";
$db->query($sql4);

header("Location: pengajuan2.php?periode=$id_periode");
?>