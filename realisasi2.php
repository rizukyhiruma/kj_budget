<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>

<div class="container">
	<?php 
		include "navigasi.php";
	
		$id_periode = $_GET['periode'];
		
		$sql = "SELECT * FROM tb_periode where id_periode = '$id_periode'";
		$sql2 = $db->query($sql);
		$periode = $sql2->fetch_array();
		
		$periode2 = $periode['bulan'].', '.$periode['tahun'];
		$idperiode = $periode['id_periode'];
		
		//$periode = $_GET['periode'];
		$idus = $_SESSION['idus'];
		
		$ceksent = "SELECT sent FROM tb_approval WHERE id_user='$idus' and id_periode='$idperiode' ";
		$ceksent2 = $db->query($ceksent);
		$ceksent3 = $ceksent2->fetch_array();
		$sent = $ceksent3['sent'];
	?>
	<h1 class="display-4">Realisasi</h1>
	Periode: <b><?php echo $periode2; ?></b><br/>
	Pengajuan oleh: <b><?php echo $_SESSION['user'];?></b>
	<br/>
	<br/>
	<table class="table table-hover table-sm">
		<thead>
			<tr>
				<th>No.</th>
				<th>Keterangan</th>
				<th class="text-right">Jumlah<br/>(Orang/Unit)</th>
				<th class="text-right">Jumlah Waktu<br/>(Hari/Minggu/Bulan)</th>
				<th class="text-right">Biaya<br/>(Per Unit)</th>
				<th class="text-right">Total Budget</th>
				<th class="text-right">Realisasi</th>
				<th class="text-right">Selisih</th>
				<th class="text-right"></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			$no = 1;
			
			$sql = "SELECT 
				tb_budget.keterangan,
				tb_budget.approval_3,
				tb_budget_2.id_budget_2,
				tb_budget_2.id_user,
				tb_budget_2.id_periode,
				tb_budget_2.id_budget,
				tb_budget_2.jumlah_unit,
				tb_budget_2.jumlah_waktu,
				tb_budget_2.biaya,
				tb_budget_2.total_budget,
				tb_budget_2.realisasi,
				tb_budget_2.selisih
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
				WHERE tb_budget_2.id_user='$idus' AND tb_budget_2.id_periode='$idperiode' AND tb_budget.approval_3='1'";
			
			$sql2 = $db->query($sql);
			while($result = $sql2->fetch_array())
			{
				if($result == NULL)
				{
					echo "";
				}
				else
				{
					if($result['realisasi']==null and $result['selisih']==null)
					{
						$realisasi = 0;
						$selisih = 0;
					}
					else if($result['realisasi']!=null and $result['selisih']!=null)
					{
						$realisasi = number_format($result['realisasi']);
						$selisih = number_format($result['selisih']);
					}
				?>
				<!-- <form action="do_realisasi.php"> -->
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $result['keterangan']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_unit']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_waktu']; ?></td>
					<td class="text-right"><?php echo number_format($result['biaya']); ?></td>
					<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
					<td class="text-right"><?php echo $realisasi; ?></td>
					<td class="text-right"><?php echo $selisih; ?></td>
					<td class="text-right"><a href="realisasi3.php?id_budget=<?php echo $result['id_budget']; ?>&id_periode=<?php echo $result['id_periode']; ?>" type="button" class="btn btn-primary btn-sm">Input</a></td>
				</tr>
				
				<?php
				}
				$no++;				
			}
			
			?>
			<tr class="table-primary">
				<td>Total</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<input type="hidden" name="id_periode" id="id_periode" value="<?php echo $idperiode;?>">
				<td class="text-right">
					<?php
						
						$cek_apprvl = "SELECT approval_3 FROM tb_approval WHERE id_periode = '$idperiode'";
						$cek_apprvl2 = $db->query($cek_apprvl);
						$cek_apprvl3 = $cek_apprvl2->fetch_array();
						
						if($cek_apprvl3['approval_3'] == 1)
						{
							$total = $db->query("SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$idus' and id_periode='$idperiode'");
							$total2 = $total->fetch_array();
							
							echo number_format($total2['total']); 
						}
						else
						{
							echo "0";
						}
					?>
				</td>
				<td class="text-right">
				
				<?php 
				
				$reali = $db->query("SELECT SUM(realisasi) AS total_realisasi 
									FROM tb_budget_2 
									where id_user='$idus' and id_periode='$idperiode'");
				$reali2 = $reali->fetch_array();
				$reali3 = $reali2['total_realisasi'];
				
				echo number_format($reali3);
				
				?>
				
				</td>
				<td class="text-right">
					<?php
					
					$total_selisih = $db->query("SELECT SUM(selisih) AS total_selisih FROM tb_budget_2 where id_user='$idus' and id_periode='$idperiode'");
					$total_selisih2 = $total_selisih->fetch_array();
					
					$total_selisih3 = $total_selisih2['total_selisih'];
					
					echo number_format($total_selisih3);
					
					?>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="9" class="text-right">
					<!-- <button type="submit" class="btn btn-primary">Submit Realisasi</button> -->
				</td>
			</tr>
			<!-- </form> -->
		</tbody>
	</table>
</div>
<?php
include "footer.php";
?>