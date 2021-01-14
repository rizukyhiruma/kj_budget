<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";?>
	<?php 
	
	$id_user = $_GET['id_user'];
	$id_periode = $_GET['id_periode'];
	$no = 1;
	
	$sql_0 = "SELECT 
			tb_periode.id_periode,
			tb_periode.id_user,
			tb_user.username,
			tb_departemen.id_departemen,
			tb_departemen.nama_departemen,
			tb_periode.bulan,
			tb_periode.tahun,
			tb_periode.periode
			FROM tb_periode
			JOIN tb_user ON tb_user.id_user = tb_periode.id_user
			JOIN tb_departemen ON tb_departemen.id_departemen = tb_user.id_departemen
			WHERE tb_periode.id_periode = $id_periode AND tb_periode.id_user = $id_user
			";
	$sql_01 = $db->query($sql_0);
	$sql_02 = $sql_01->fetch_array();
	
	?>
	
	<h1 class="display-4">Approval</h1>
	Pengajuan oleh: <b><?php echo $sql_02['username']." - ".$sql_02['nama_departemen'];?></b><br/>
	Periode: <b><?php echo $sql_02['bulan'].", ".$sql_02['tahun']; ?></b><br/><br/>
	
	<?php
	
	$idperiode = $sql_02['id_periode'];
	
	$appstt = "SELECT * FROM tb_approval WHERE approval_1 = '1' AND id_periode = '$idperiode'";
	$appstt2 = $db->query($appstt);
	$appstt3 = $appstt2->fetch_array();
	
	echo "Status:";	
	if($appstt3['approval_1'] == '1')
	{
		echo "<br/>Approved by Finance.";
	}
	
	// if($appstt3['approval_2'] == '1')
	// {
		// if($appstt3['id_user'] != '8')
		// {
			// echo "<br/>Approved by MD.";
		// }
		// else if($appstt3['id_user'] == '8')
		// {
			// echo "<br/>Approved by Pemred.";
		// }
	// }
	
	if($appstt3['approval_3'] == '1')
	{
		echo "<br/>Approved by CEO.";
	}
	
	?>
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
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = "SELECT 
					tb_periode.id_periode,
					tb_periode.id_user,
					tb_periode.bulan,
					tb_periode.tahun,
					tb_periode.periode,
					tb_budget.keterangan,
					tb_budget.sent,
					tb_budget.id_budget,
					tb_budget.approval_3,
					tb_budget_2.jumlah_unit,
					tb_budget_2.jumlah_waktu,
					tb_budget_2.biaya,
					tb_budget_2.total_budget,
					tb_reject.reject_notes
					FROM tb_periode
					JOIN tb_budget ON tb_budget.id_periode=tb_periode.id_periode
					JOIN tb_budget_2 ON tb_budget_2.id_budget=tb_budget.id_budget
					LEFT JOIN tb_reject ON tb_reject.id_budget=tb_budget.id_budget
					WHERE tb_periode.id_periode = $id_periode AND tb_periode.id_user = $id_user
					ORDER BY tb_budget.id_budget ASC";
			$sql2 = $db->query($sql);
			while($result = $sql2->fetch_array())
			{
				?>
				<form action="do_approval_3.php">
				<tr>
					<td><?php echo $no."."; ?></td>
					<td><?php echo $result['keterangan']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_unit']; ?></td>
					<td class="text-right"><?php echo $result['jumlah_waktu']; ?></td>
					<td class="text-right"><?php echo number_format($result['biaya']); ?></td>
					<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
					<td> 
						<?php 
						
						if($result['approval_3']=='1')
						{
							echo "";
						}
						else
						{
							?>							
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="rejected_<?php echo $no;?>" id="rejected_<?php echo $no;?>" value="rejected" <?php if($result['approval_3']=='2'){echo "disabled checked";}?>>Reject
									<input type="hidden" name="rjct_<?php echo $no;?>" value="<?php echo $result['id_budget'];?>">
									<?php 
									
									if($result['reject_notes']!=NULL)
									{
										echo ", notes: ".$result['reject_notes'];
									}
									else
									{
										?><input type="text" name="rjct_notes_<?php echo $no; ?>" placeholder="Enter Notes"><?php
									}
									?>
								</label>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
				$no++;
			}
			$total = $db->query("SELECT SUM(total_budget) AS total, 
			id_user, 
			id_periode,
			id_budget
			FROM tb_budget_2 where id_user='$id_user' and id_periode='$id_periode'");
			$total2 = $total->fetch_array();
			?>
			<tr class="table-primary">
				<td>Total</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo number_format($total2['total']); ?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="7" class="text-right">
					<input type="hidden" name="id_user" id="id_user" value="<?php echo $total2['id_user']; ?>"></input>
					<input type="hidden" name="id_periode" id="id_periode" value="<?php echo $total2['id_periode'];?>"></input>
					<?php $nominsatu = $no-1;?>
					<input type="hidden" name="no" id="no" value="<?php echo $nominsatu; ?>"></input>
					
					<?php
					
					$id_periode = $total2['id_periode'];
					
					$ckpprvd = "SELECT sent, approval_3
					FROM tb_approval
					WHERE id_periode='$id_periode'
					";
					$ckpprvd2 = $db->query($ckpprvd);
					$ckpprvd3 = $ckpprvd2->fetch_array();
					
					if($ckpprvd3['approval_3']=='1')
					{
						?>
						<button type="submit" class="btn btn-primary" name="approve" id="approve" value="approve" disabled>Approved</button>
						<?php
					}
					else if($ckpprvd3['sent']=='0')
					{
						?>
						<button type="submit" class="btn btn-danger" name="reject_all" id="reject_all" value="reject_all" disabled>Rejected</button>
						<?php
					}
					else
					{
						?>
						<button type="submit" class="btn btn-primary" name="approve" id="approve" value="approve">Approve All</button>
						<button type="submit" class="btn btn-outline-danger" name="reject_all" id="reject_all" value="reject_all">Reject All</button>
						<button type="submit" class="btn btn-outline-danger" name="reject" id="reject" value="reject">Reject Selected</button>
						<?php
					}
					?>
				</td>
			</tr>
			
			</form>
		</tbody>
	</table>
	
	<br/> <!--batas-->
	
	<?php
	
		$sql_1 = "SELECT periode 
		FROM tb_periode 
		WHERE id_periode = '$id_periode' 
		";
		$sql_1a = $db->query($sql_1);
		$sql_1b = $sql_1a->fetch_array();
		$sql_1c = $sql_1b['periode'];
		
		$sql_1d = strtotime($sql_1c);
		$periode1 = date("Y-m-d", strtotime("-1 month", $sql_1d));
		
		$sql_2 = "SELECT id_periode 
		FROM tb_periode 
		WHERE periode = '$periode1'
		AND id_user = '$id_user'
		";
		$sql_2a = $db->query($sql_2);
		$sql_2b = $sql_2a->fetch_array();
		$sql_2c = $sql_2b['id_periode'];
		
	?>
	Tabel budget periode sebelumnya: <b><?php echo date("M, Y", strtotime("-1 month", $sql_1d)); ?></b>
	<table class="table table-hover table-sm">
		<thead>
			<tr>
				<th>no.</th>
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
				
				$sql = "SELECT *
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
				JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_budget_2.id_periode = '$sql_2c'
				";
				
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
			<tr>
				<td><?php echo $no."."; ?></td>
				<td><?php echo $result['keterangan']; ?></td>
				<td class="text-right"><?php echo $result['jumlah_unit']; ?></td>
				<td class="text-right"><?php echo $result['jumlah_waktu']; ?></td>
				<td class="text-right"><?php echo number_format($result['biaya']); ?></td>
				<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
				<td class="text-right">
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_<?php echo $no;?>"><?php echo $realisasi; ?></button>
					
					<!-- modal start-->
					<div class="modal fade" id="myModal_<?php echo $no;?>">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">

								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title">Detail Realisasi</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Modal body -->
								<div class="modal-body text-left">
									Pengajuan oleh: <b><?php echo $_SESSION['user'];?></b><br/>
									Periode: <b><?php echo $result['bulan'].", ".$result['tahun'];?></b><br/>
									Keterangan: <b><?php echo $result['keterangan']; ?></b><br/>
									Total Budget: <b><?php echo number_format($result['total_budget']); ?></b><br/>
									<br/>
									<table class="table table-hover table-sm">
										<thead>
											<tr class="table-primary">
												<td><b>Total Budget</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
											</tr>
											<tr>
												<th>No.</th>
												<th>No. PO / Memo</th>
												<th>Supplier</th>
												<th>Deskripsi</th>
												<th>Tanggal Bayar</th>
												<th class="text-right">Biaya</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$nom = 1;
											$idbud = $result['id_budget'];
											$sql_detilrealisasi = "SELECT * FROM tb_realisasi 
													WHERE id_budget = '$idbud'";
											$sql_detilrealisasi_2 = $db->query($sql_detilrealisasi);
											while ($sql_detilrealisasi_3 = $sql_detilrealisasi_2->fetch_array())
											{				
												?>
												<tr>
													<td><?php echo $nom."."; ?></td>
													<td><?php echo $sql_detilrealisasi_3['keterangan_1'];?></td>
													<td><?php echo $sql_detilrealisasi_3['keterangan_2'];?></td>
													<td><?php echo $sql_detilrealisasi_3['keterangan_3'];?></td>
													<td><?php echo date("d M, Y", strtotime($sql_detilrealisasi_3['keterangan_4']));?></td>
													<td class="text-right"><?php echo number_format($sql_detilrealisasi_3['biaya']);?></td>
												</tr>
												<?php
												$nom++;
											}
											?>
											<tr class="table-primary">
											<?php
											
											$total_detilrealisasi = $db->query("SELECT SUM(biaya) AS total FROM tb_realisasi where id_budget='$idbud'");
											$total_detilrealisasi_2 = $total_detilrealisasi->fetch_array();
											$total_detilrealisasi_3 = $total_detilrealisasi_2['total'];
											?>
												<td><b>Total Realisasi</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td class="text-right"><?php echo number_format($total_detilrealisasi_3);?></td>
											</tr>
											<tr class="table-primary">
												<td><b>Sisa</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td class="text-right"><?php echo number_format($result['total_budget'] - $total_detilrealisasi_3); ?></td>
											</tr>
											<tr>
												<td colspan="6" class="text-right">
													<!-- <button type="submit" class="btn btn-primary">Submit Realisasi</button> -->
												</td>
											</tr>
											<!-- </form> -->
										</tbody>
									</table>
								</div>

								<!-- Modal footer -->
								<div class="modal-footer">
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
								</div>

							</div>
						</div>
					</div>
					<!--modal end-->
				
				</td>
				<td class="text-right"><?php echo $selisih; ?></td>
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
				<td class="text-right">
					<?php 
					
					$total_query = "SELECT SUM(total_budget) AS total 
					FROM tb_budget_2 
					WHERE id_periode='$sql_2c'";
					$total = $db->query($total_query);
					$total2 = $total->fetch_array();
					
					echo number_format($total2['total']); 
					?>
				</td>
				<td class="text-right">
				
				<?php 
				
				$reali = $db->query("SELECT SUM(realisasi) AS total_realisasi 
									FROM tb_budget_2 
									WHERE id_periode='$sql_2c'");
				$reali2 = $reali->fetch_array();
				$reali3 = $reali2['total_realisasi'];
				
				echo number_format($reali3);
				
				?>
				
				</td>
				<td class="text-right">
					<?php
					
					$total_selisih = $db->query("SELECT SUM(selisih) AS total_selisih 
												FROM tb_budget_2 
												WHERE id_periode='$sql_2c'");
					$total_selisih2 = $total_selisih->fetch_array();
					
					$total_selisih3 = $total_selisih2['total_selisih'];
					
					echo number_format($total_selisih3);
					
					?>
				</td>
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
			</tr>
		</tbody>
	</table>
	
</div>