<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$periode = $_GET['periode'];
$idus = $_SESSION['idus'];

list($bulan, $tahun) = explode(", ", $periode);
	
$cek_periode = "SELECT * FROM tb_periode WHERE id_user='$idus' and bulan='$bulan' and tahun='$tahun'";
$cek_periode2 = $db->query($cek_periode);
$result = $cek_periode2->fetch_array();
$periode2 = $result['bulan'].', '.$result['tahun'];

if($periode == "Select")
{
	header('Location: pengajuan.php?errmss=silahkan pilih periode');
}
else if($result['id_user']==$idus and $periode==$periode2)
{
	header('Location: pengajuan.php?errmss=perioda sudah ada');
}
else
{
	$sql = "INSERT INTO tb_periode(id_periode, id_user, bulan, tahun) VALUE('', '$idus', '$bulan', '$tahun')";

	$db->query($sql);

	header('Location: pengajuan.php');
}

?>