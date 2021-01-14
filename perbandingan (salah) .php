<?php

include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";?>
	<br/>
	
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Periode</th>
			<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		
		<?php 

		$idus = $_SESSION['idus'];
		$sql = "SELECT * FROM tb_periode WHERE id_user='$idus' ";
		$sql2 = $db->query($sql);

		while($result = $sql2->fetch_array())
		{
			?>
			<tr>
				<td><?php echo $result['bulan'].', '.$result['tahun'];?></td>
				<td><a href="perbandingan2.php?periode=<?php echo $result['id_periode'];?>" type="button" class="btn btn-primary">Open</a></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	
	<div class="table-responsive">
		<table class="table table-borderless table-sm">
			<thead>
				<tr>
					<th>Maret</th>
					<th></th>
					<th>April</th>
					<th></th>
					<th>Mei</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									<th>No.</th>
									<th>Keterangan</th>
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
									WHERE tb_budget_2.id_periode='18'";
								
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
								</form>
							</tbody>
						</table>
					
					</td>
					<td></td>
					<td>
					
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									
									
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
									WHERE tb_budget_2.id_periode='18'";
								
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
								</form>
							</tbody>
						</table>
					
					</td>
					<td></td>
					<td>
					
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									
									
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
									WHERE tb_budget_2.id_periode='18'";
								
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
								</form>
							</tbody>
						</table>
					
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>

</div>
<?php
include "footer.php"
?>