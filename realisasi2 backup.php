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
	<h1 class="display-4"><?php echo $periode2; ?></h1>
	<h3><?php echo $_SESSION['user'];?></h3>
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
			</tr>
		</thead>
		<tbody>
			<?php 
			
			$no = 1;
			
			$sql = "SELECT 
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
					if($result['biaya']==null and $result['total_budget']==null and $result['realisasi']==null)
					{
						$biaya = 0;
						$totalbud = 0;
						$realisasi = 0;
					}
					else if($result['biaya']==0 and $result['total_budget']==0 and $result['realisasi']==0)
					{
						$biaya = 0;
						$totalbud = 0;
						$realisasi = 0;
						
					}
					else if($result['biaya']!=null and $result['total_budget']!=null and $result['realisasi']!=null)
					{
						$biaya = number_format($result['biaya']);
						$totalbud = number_format($result['total_budget']);
						$realisasi = number_format($result['realisasi']);
					}
				?>
				<form action="do_realisasi.php">
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $result['keterangan']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_unit']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_waktu']; ?></td>
					<td class="text-right"><?php echo number_format($result['biaya']); ?></td>
					<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
					<td class="text-right">
						<?php 
						
						if($result['realisasi']!=null)
						{
							echo number_format($result['realisasi']);
						}
						else
						{
							?>
							<input type="text" name="realisasi_<?php echo $no;?>" value="<?php echo $result['realisasi'];?>">
							<?php
						}
						
						?>
						
					</td>
					<td class="text-right">
						<?php 
						$selisih = $result['selisih'];
						if ($selisih == null)
						{
							echo $selisih;
						}
						else
						{
							echo number_format($selisih); 
						}
						?>
					</td>
					<input type="hidden" name="no" id="no" value="<?php echo $no;?>">
					<input type="hidden" name="total_budget_<?php echo $no;?>" id="total_budget_<?php echo $no;?>" value="<?php echo $result['total_budget'];?>">
					<input type="hidden" name="id_budget_<?php echo $no;?>" id="id_budget_<?php echo $no;?>" value="<?php echo $result['id_budget'];?>">
					<input type="hidden" name="id_budget_2_<?php echo $no;?>" id="id_budget_2_<?php echo $no;?>" value="<?php echo $result['id_budget_2'];?>">
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
					if($result['approval_3']=='1')
					{
					$total = $db->query("SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$idus' and id_periode='$idperiode'");
					$total2 = $total->fetch_array();
					
					echo number_format($total2['total']); 
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
			</tr>
			<tr>
				<td colspan="8" class="text-right">
					<button type="submit" class="btn btn-primary">Submit Realisasi</button>
				</td>
			</tr>
			</form>
		</tbody>
	</table>
	
</div>
<?php
include "footer.php";
?>