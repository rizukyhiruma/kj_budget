<?php

include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";?>
	<h1 class="display-4">Perbandingan</h1>
	<br/>
	<?php
		
		$idperiode = $_GET['periode'];
		$idus = $_SESSION['idus'];
		
		$sql_1 = "SELECT * FROM tb_periode WHERE id_periode = '$idperiode' ";
		
		//https://stackoverflow.com/questions/9911330/php-get-date-1-month/9911612
		//https://blog.osmosys.asia/2015/04/24/using-1-month-with-strtotime-function-in-php/
		//month - 1 php
		
		$sql_1a = $db->query($sql_1);
		$sql_1b = $sql_1a->fetch_array();
		$sql_1c = $sql_1b['periode'];
		
		$sql_1d = strtotime($sql_1c);
		$periode1 = date("Y-m-d", strtotime("0 month", $sql_1d));
		$periode2 = date("Y-m-d", strtotime("-1 month", $sql_1d));
		$periode3 = date("Y-m-d", strtotime("-2 month", $sql_1d));
		
	?>
	<h3><?php echo date("M, Y", strtotime("0 month", $sql_1d)); ?></h3>
	<div class="table-responsive">
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
				tb_budget_2.selisih,
                tb_periode.periode,
				tb_periode.bulan,
				tb_periode.tahun
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$periode1'
				AND tb_budget_2.id_user = '$idus'
				ORDER BY tb_budget_2.total_budget ASC
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
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1_<?php echo $no;?>"><?php echo $realisasi; ?></button>
					
					<!-- modal start-->
					<div class="modal fade" id="myModal1_<?php echo $no;?>">
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
					
					$cek_total = "SELECT
					tb_budget_2.id_periode,
					tb_periode.id_periode
					FROM tb_budget_2
					JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
					WHERE tb_periode.periode = '$periode1'
					AND tb_budget_2.id_user = '$idus'
					";
					$cek_total2 = $db->query($cek_total);
					$cek_total3 = $cek_total2->fetch_array();
					$cek_total4 = $cek_total3['id_periode'];
					
					
					$total_query = "SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'";
					$total = $db->query($total_query);
					$total2 = $total->fetch_array();
					
					echo number_format($total2['total']); 
					?>
				</td>
				<td class="text-right">
				
				<?php 
				
				$reali = $db->query("SELECT SUM(realisasi) AS total_realisasi 
									FROM tb_budget_2 
									where id_user='$idus' and id_periode='$cek_total4'");
				$reali2 = $reali->fetch_array();
				$reali3 = $reali2['total_realisasi'];
				
				echo number_format($reali3);
				
				?>
				
				</td>
				<td class="text-right">
					<?php
					
					$total_selisih = $db->query("SELECT SUM(selisih) AS total_selisih FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'");
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
  
	<br/>
	<h3><?php echo date("M, Y", strtotime("-1 month", $sql_1d)); ?></h3>
	<div class="table-responsive">
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
				tb_budget_2.selisih,
                tb_periode.periode,
				tb_periode.bulan,
				tb_periode.tahun
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$periode2'
				AND tb_budget_2.id_user = '$idus'
				ORDER BY tb_budget_2.total_budget ASC
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
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal2_<?php echo $no;?>"><?php echo $realisasi; ?></button>
					
					<!-- modal start-->
					<div class="modal fade" id="myModal2_<?php echo $no;?>">
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
					
					$cek_total = "SELECT
					tb_budget_2.id_periode,
					tb_periode.id_periode
					FROM tb_budget_2
					JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
					WHERE tb_periode.periode = '$periode2'
					AND tb_budget_2.id_user = '$idus'
					";
					$cek_total2 = $db->query($cek_total);
					$cek_total3 = $cek_total2->fetch_array();
					$cek_total4 = $cek_total3['id_periode'];
					
					
					$total_query = "SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'";
					$total = $db->query($total_query);
					$total2 = $total->fetch_array();
					
					echo number_format($total2['total']); 
					?>
				</td>
				<td class="text-right">
				
				<?php 
				
				$reali = $db->query("SELECT SUM(realisasi) AS total_realisasi 
									FROM tb_budget_2 
									where id_user='$idus' and id_periode='$cek_total4'");
				$reali2 = $reali->fetch_array();
				$reali3 = $reali2['total_realisasi'];
				
				echo number_format($reali3);
				
				?>
				
				</td>
				<td class="text-right">
					<?php
					
					$total_selisih = $db->query("SELECT SUM(selisih) AS total_selisih FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'");
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
  
	<br/>
	<h3><?php echo date("M, Y", strtotime("-2 month", $sql_1d)); ?></h3>
	<div class="table-responsive">
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
				
				$sql = "SELECT 
				tb_budget.keterangan,
				tb_budget.id_budget,
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
                tb_periode.periode,
				tb_periode.bulan,
				tb_periode.tahun
				FROM tb_budget_2
				JOIN tb_budget ON tb_budget_2.id_budget = tb_budget.id_budget
                JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
				WHERE tb_periode.periode = '$periode3'
				AND tb_budget_2.id_user = '$idus'
				ORDER BY tb_budget_2.total_budget ASC
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
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal3_<?php echo $no;?>"><?php echo $realisasi; ?></button>
					
					<!-- modal start-->
					<div class="modal fade" id="myModal3_<?php echo $no;?>">
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
					
					$cek_total = "SELECT
					tb_budget_2.id_periode,
					tb_periode.id_periode
					FROM tb_budget_2
					JOIN tb_periode ON tb_budget_2.id_periode = tb_periode.id_periode
					WHERE tb_periode.periode = '$periode3'
					AND tb_budget_2.id_user = '$idus'
					";
					$cek_total2 = $db->query($cek_total);
					$cek_total3 = $cek_total2->fetch_array();
					$cek_total4 = $cek_total3['id_periode'];
					
					
					$total_query = "SELECT SUM(total_budget) AS total FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'";
					$total = $db->query($total_query);
					$total2 = $total->fetch_array();
					
					echo number_format($total2['total']); 
					?>
				</td>
				<td class="text-right">
				
				<?php 
				
				$reali = $db->query("SELECT SUM(realisasi) AS total_realisasi 
									FROM tb_budget_2 
									where id_user='$idus' and id_periode='$cek_total4'");
				$reali2 = $reali->fetch_array();
				$reali3 = $reali2['total_realisasi'];
				
				echo number_format($reali3);
				
				?>
				
				</td>
				<td class="text-right">
					<?php
					
					$total_selisih = $db->query("SELECT SUM(selisih) AS total_selisih FROM tb_budget_2 where id_user='$idus' and id_periode='$cek_total4'");
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

</div>
<?php
include "footer.php"
?>