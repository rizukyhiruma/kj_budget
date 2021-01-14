<?php
	include "header.php";
	include "db_konek.php";
	include "cek_session.php";
?>
<div class="container">
	<?php
	include "navigasi.php";
	
	$id_periode = $_GET['periode'];
	$id_user = $_SESSION['idus'];
	
	$sql = "SELECT *
	FROM tb_periode 
	LEFT JOIN tb_approval ON tb_periode.id_periode = tb_approval.id_periode
	WHERE tb_periode.id_periode = '$id_periode'
	AND tb_periode.id_user = '$id_user'";
	$sql2 = $db->query($sql);
	$sql3 = $sql2->fetch_array();
	
	?>
	<h1 class="display-4">Pengajuan Budget</h1>
	Pengajuan Oleh: <b><?php echo $_SESSION['user'];?></b><br/>
	Periode: <b><?php echo $sql3['bulan'].', '.$sql3['tahun']; ?></b><br/>
	<br/>
	<div class="row">
		<div class="col-sm-4">
			<?php 
			$sent = $sql3['sent'];
			
			if($sent == '1')
			{
				echo "Status:";
				
				if($sql3['approval_1'] == '1')
				{
					echo "<br/>Approved by Finance.";
				}
				else if($sql3['approval_1'] != '1')
				{
					echo "<br/>Waiting for Approval Finance.";
				}
				
				if($sql3['approval_2'] == '1')
				{
					if($sql3['id_user'] != '8')
					{
						echo "<br/>Approved by MD.";
					}
					else if($sql3['id_user'] == '8')
					{
						echo "<br/>Approved by Pemred.";
					}
				}
				else if($sql3['approval_2'] != '1')
				{
					if($sql3['id_user'] != '8')
					{
						echo "<br/>Waiting for Approval MD.";
					}
					else if($sql3['id_user'] == '8')
					{
						echo "<br/>Waiting for Approval Pemred.";
					}
				}
				
				if($sql3['approval_3'] == '1')
				{
					echo "<br/>Approved by CEO.";
				}
				else if($sql3['approval_3'] != '1')
				{
					echo "<br/>Waiting for Approval CEO.";
				}
				
				if(isset($_GET['edit'])) 
				{
					$edit = $_GET['edit'];
					
					$cek_reject = "SELECT 
					tb_budget.keterangan,
					tb_budget_2.id_budget_2,
					tb_budget_2.id_user,
					tb_budget_2.id_periode,
					tb_budget_2.id_budget,
					tb_budget_2.jumlah_unit,
					tb_budget_2.jumlah_waktu,
					tb_budget_2.biaya,
					tb_budget_2.total_budget
					FROM tb_budget_2
					JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
					WHERE tb_budget.id_budget='$edit' 
					AND tb_budget.approval_1='2' OR tb_budget.approval_2='2'";
					$cek_reject2 = $db->query($cek_reject);
					$cek_reject3 = $cek_reject2->fetch_array();
					
					if($cek_reject3!=NULL)
					{
						?>
						<form action="do_edit_rjct.php">
							<div class="form-group">
								<label for="keterangan">Keterangan</label>
								<input type="text" class="form-control" placeholder="Enter Keterangan" id="keterangan" name="keterangan" value="<?php echo $cek_reject3['keterangan'];?>">
							</div>
							<div class="form-group">
								<label for="jumlahunit">Jumlah(Orang/Unit)</label>
								<input type="text" class="form-control" placeholder="Enter Jumlah" id="jumlahunit" name="jumlahunit" value="<?php echo $cek_reject3['jumlah_unit'];?>">
							</div>
							<div class="form-group">
								<label for="jumlahwaktu">Jumlah Waktu(Hari/Minggu/Bulan)</label>
								<input type="text" class="form-control" placeholder="Enter Jumlah Waktu" id="jumlahwaktu" name="jumlahwaktu" value="<?php echo $cek_reject3['jumlah_waktu'];?>">
							</div>
							<div class="form-group">
								<label for="biaya">Biaya(Per Unit)</label>
								<input type="text" class="form-control" placeholder="Enter Biaya" id="biaya" name="biaya" value="<?php echo $cek_reject3['biaya'];?>">
								<input type="hidden" id="periode" name="periode" value="<?php echo $id_periode; ?>">
								<input type="hidden" id="idbud" name="idbud" value="<?php echo $edit; ?>">
							</div>
							<a href="delete_rjct.php?id_budget=<?php echo $edit ?>&id_periode=<?php echo $cek_reject3['id_periode']; ?>" type="button" class="btn btn-outline-danger">delete</a>
							<button type="submit" class="btn btn-primary">Edit</button>
						</form>
						<?php
					}
				}
			}
			else
			{
				?>
				<form action="do_pengajuan2.php">
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<input type="text" class="form-control" placeholder="Enter Keterangan" id="keterangan" name="keterangan">
					</div>
					<div class="form-group">
						<label for="jumlahunit">Jumlah(Orang/Unit)</label>
						<input type="text" class="form-control" placeholder="Enter Jumlah" id="jumlahunit" name="jumlahunit">
					</div>
					<div class="form-group">
						<label for="jumlahwaktu">Jumlah Waktu(Hari/Minggu/Bulan)</label>
						<input type="text" class="form-control" placeholder="Enter Jumlah Waktu" id="jumlahwaktu" name="jumlahwaktu">
					</div>
					<div class="form-group">
						<label for="biaya">Biaya(Per Unit)</label>
						<input type="text" class="form-control" placeholder="Enter Biaya" id="biaya" name="biaya">
						<input type="hidden" id="periode" name="periode" value="<?php echo $id_periode; ?>">
					</div>
					<button type="submit" class="btn btn-primary">Tambah <!--Non Rutin--></button>
				</form>
				<?php
			}
			?>
		</div>
	</div>
	<br/>
	<table class="table table-sm table-hover">
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
			tb_budget_2.total_budget
			FROM tb_budget_2
			JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
			WHERE tb_budget_2.id_user='$id_user' 
			AND tb_budget_2.id_periode='$id_periode'";
			
			$sql2 = $db->query($sql);
			while($result = $sql2->fetch_array())
			{
				if($result == NULL)
				{
					echo "";
				}
				else
				{
					if($result['biaya']==null and $result['total_budget']==null)
					{
						$biaya = 0;
						$totalbud = 0;
					}
					else if($result['biaya']==0 and $result['total_budget']==0)
					{
						$biaya = 0;
						$totalbud = 0;
					}
					else
					{
						$biaya = number_format($result['biaya']);
						$totalbud = number_format($result['total_budget']);
					}
					?>
					<tr>
						<td><?php echo $no."."; ?></td>
						<td><?php echo $result['keterangan']; ?></td>
						<td class="text-right"><?php echo $result['jumlah_unit']; ?></td>
						<td class="text-right"><?php echo $result['jumlah_waktu']; ?></td>
						<td class="text-right"><?php echo number_format($result['biaya']); ?></td>
						<td class="text-right"><?php echo number_format($result['total_budget']); ?></td>
						<?php 
						if($sent=='1')
						{
							$idbud = $result['id_budget'];
							$cekapp1 = "SELECT 
										tb_budget.id_budget,
										tb_budget.id_periode,
										tb_budget.approval_1,
										tb_budget.approval_2,
										tb_reject.reject_notes
										FROM tb_budget
										JOIN tb_reject ON tb_reject.id_budget = tb_budget.id_budget
										WHERE tb_budget.id_budget ='$idbud'";
							$cekapp2 = $db->query($cekapp1);
							$cekapp3 = $cekapp2->fetch_array();
							if($cekapp3['approval_1']=='2')
							{
								?>
								<td class="text-right">
									<?php echo "Rejected, notes:<br/>".$cekapp3['reject_notes'];?>
									<a href="pengajuan2.php?periode=<?php echo $cekapp3['id_periode']; ?>&edit=<?php echo $cekapp3['id_budget'];?>" type="button" class="btn btn-outline-danger btn-sm">edit budget</a>
								</td>
								<?php
							}
							else if($cekapp3['approval_2']=='2')
							{
								?>
								<td class="text-right">
									<?php echo "Rejected, notes:<br/>".$cekapp3['reject_notes'];?>
									<a href="pengajuan2.php?periode=<?php echo $cekapp3['id_periode']; ?>&edit=<?php echo $cekapp3['id_budget'];?>" type="button" class="btn btn-outline-danger btn-sm">edit budget</a>
								</td>
								<?php
							}
							else
							{
								echo "<td></td>";
							}
						}
						else
						{
							?>
							<td class="text-right"><a href="delete.php?id_budget=<?php echo $result['id_budget']; ?>&id_periode=<?php echo $result['id_periode']; ?>" type="button" class="btn btn-outline-danger btn-sm">delete</a></td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				$no++;				
			}
			
			$total = $db->query("SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$id_user' and id_periode='$id_periode'");
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
					<?php 
				
					if($sent == '1')
					{
						echo "";
					}
					else if ($total2['total']!=null)
					{
						?>
						<a href="send.php?id_user=<?php echo $id_user; ?>&id_periode=<?php echo $id_periode; ?>" class="btn btn-primary" role="button" disabled>Send for Approval</a>
						<?php
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<br/> <!--batas-->
	
	<?php
	
		$sql_1 = "SELECT * 
		FROM tb_periode 
		WHERE id_periode = '$id_periode' ";
		
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
	<table class="table table-sm table-hover">
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
				<th></th>
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
							<td class="text-right"></td>
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
			</tr>
		</tbody>
	</table>
</div>
<?php
include "footer.php";
?>