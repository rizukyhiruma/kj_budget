<?php

include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";?>
	<br/>
	<div class="table-responsive">
		<table class="table table-bordered">
		<thead>
			<?php
		
				$idperiode = $_GET['periode'];
				
				$sql_1 = "SELECT * FROM tb_periode WHERE id_periode = '$idperiode' ";
				
				//https://stackoverflow.com/questions/9911330/php-get-date-1-month/9911612
				//https://blog.osmosys.asia/2015/04/24/using-1-month-with-strtotime-function-in-php/
				//month - 1 php
				
				$sql_1a = $db->query($sql_1);
				$sql_1b = $sql_1a->fetch_array();
				$sql_1c = $sql_1b['periode'];
				
				$sql_1d = strtotime($sql_1c);
				$sql_1e = date("Y-m-d", strtotime("0 month", $sql_1d));
				$sql_1f = date("Y-m-d", strtotime("-1 month", $sql_1d));
				$sql_1g = date("Y-m-d", strtotime("-2 month", $sql_1d));
				
			?>
			<tr>
				<td colspan="2"></td>
				<td colspan="6" class="text-center"><?php echo $sql_1g; ?></td>
				<td></td>
				<td colspan="6" class="text-center"><?php echo $sql_1f; ?></td>
				<td></td>
				<td colspan="6" class="text-center"><?php echo $sql_1e; ?></td>
			</tr>
			<tr>
				<th>no.</th>
				<th>Keterangan</th>
				<th>Jumlah<br/>(Orang/Unit)</th>
				<th>Jumlah Waktu<br/>(Hari/Minggu/Bulan)</th>
				<th>Biaya<br/>(Per Unit)</th>
				<th>Total Budget</th>
				<th>Realisasi</th>
				<th>Selisih</th>
				<th></th>
				<th>Jumlah<br/>(Orang/Unit)</th>
				<th>Jumlah Waktu<br/>(Hari/Minggu/Bulan)</th>
				<th>Biaya<br/>(Per Unit)</th>
				<th>Total Budget</th>
				<th>Realisasi</th>
				<th>Selisih</th>
				<th></th>
				<th>Jumlah<br/>(Orang/Unit)</th>
				<th>Jumlah Waktu<br/>(Hari/Minggu/Bulan)</th>
				<th>Biaya<br/>(Per Unit)</th>
				<th>Total Budget</th>
				<th>Realisasi</th>
				<th>Selisih</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			$idus = $_SESSION['idus'];
			$sql_2 = "SELECT DISTINCT keterangan
					FROM tb_budget
					WHERE id_periode = '$idperiode' ";
			$sql_2a = $db->query($sql_2);
			while($sql_2b = $sql_2a->fetch_array())
			{
				$bulan1 = "SELECT 
				tb_budget.keterangan,
				tb_budget_2.id_budget_2,
				tb_budget_2.id_user,
				tb_budget_2.id_periode,
				tb_budget_2.id_budget,
				tb_budget_2.jumlah_unit,
				tb_budget_2.jumlah_waktu,
				tb_budget_2.biaya,
				tb_budget_2.total_budget,
				tb_budget_2.realisasi,
				tb_budget_2.selisih,
                tb_periode.periode
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$sql_1g'
				AND tb_budget_2.id_user = '$idus'
				";
				$bulan1a = $db->query($bulan1);
				$bulan1b = $bulan1a->fetch_array();
				
				$bulan2 = "SELECT 
				tb_budget.keterangan,
				tb_budget_2.id_budget_2,
				tb_budget_2.id_user,
				tb_budget_2.id_periode,
				tb_budget_2.id_budget,
				tb_budget_2.jumlah_unit,
				tb_budget_2.jumlah_waktu,
				tb_budget_2.biaya,
				tb_budget_2.total_budget,
				tb_budget_2.realisasi,
				tb_budget_2.selisih,
                tb_periode.periode
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$sql_1f'
				AND tb_budget_2.id_user = '$idus'
				";
				$bulan2a = $db->query($bulan2);
				$bulan2b = $bulan2a->fetch_array();
				
				$bulan3 = "SELECT 
				tb_budget.keterangan,
				tb_budget_2.id_budget_2,
				tb_budget_2.id_user,
				tb_budget_2.id_periode,
				tb_budget_2.id_budget,
				tb_budget_2.jumlah_unit,
				tb_budget_2.jumlah_waktu,
				tb_budget_2.biaya,
				tb_budget_2.total_budget,
				tb_budget_2.realisasi,
				tb_budget_2.selisih,
                tb_periode.periode
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$sql_1e'
				AND tb_budget_2.id_user = '$idus'
				";
				$bulan3a = $db->query($bulan3);
				$bulan3b = $bulan3a->fetch_array();
				
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $sql_2b['keterangan']; ?></td>
				<td><?php echo $bulan1b['jumlah_unit'];?></td>
				<td><?php echo $bulan1b['jumlah_waktu'];?></td>
				<td><?php echo $bulan1b['biaya'];?></td>
				<td><?php echo $bulan1b['total_budget'];?></td>
				<td><?php echo $bulan1b['realisasi'];?></td>
				<td><?php echo $bulan1b['selisih'];?></td>
				<td></td>
				<td><?php echo $bulan2b['jumlah_unit'];?></td>
				<td><?php echo $bulan2b['jumlah_waktu'];?></td>
				<td><?php echo $bulan2b['biaya'];?></td>
				<td><?php echo $bulan2b['total_budget'];?></td>
				<td><?php echo $bulan2b['realisasi'];?></td>
				<td><?php echo $bulan2b['selisih'];?></td>
				<td></td>
				<td><?php echo $bulan3b['jumlah_unit'];?></td>
				<td><?php echo $bulan3b['jumlah_waktu'];?></td>
				<td><?php echo $bulan3b['biaya'];?></td>
				<td><?php echo $bulan3b['total_budget'];?></td>
				<td><?php echo $bulan3b['realisasi'];?></td>
				<td><?php echo $bulan3b['selisih'];?></td>
			</tr>
			<?php
			$no++;
			}
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	  </table>
  </div>

</div>
<?php
include "footer.php"
?>