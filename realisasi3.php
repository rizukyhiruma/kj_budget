<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php 
		include "navigasi.php";
		
		$id_periode = $_GET['id_periode'];
		$id_budget = $_GET['id_budget'];
		
		$sql = "SELECT *
				FROM tb_budget
				JOIN tb_budget_2 ON tb_budget_2.id_budget = tb_budget.id_budget
				JOIN tb_periode ON tb_budget.id_periode = tb_periode.id_periode
				WHERE tb_budget.id_periode = '$id_periode' and tb_budget.id_budget = '$id_budget'
				";
		$sql2 = $db->query($sql);
		$sql3 = $sql2->fetch_array();
		$periode = $sql3['bulan'].', '.$sql3['tahun'];
		$budget = number_format($sql3['total_budget']);
		$budget2 = $sql3['total_budget'];
		$id_bud_2 = $sql3['id_budget_2'];
	?>
	<h1 class="display-4">Realisasi</h1>
	Periode: <b><?php echo $periode; ?></b><br/>
	Pengajuan oleh: <b><?php echo $_SESSION['user'];?></b><br/>
	Keterangan: <b><?php echo $sql3['keterangan']; ?></b><br/>
	Jumlah(Orang/Unit): <b><?php echo $sql3['jumlah_unit']; ?></b><br/>
	Jumlah Waktu(Hari/Minggu/Bulan): <b><?php echo $sql3['jumlah_waktu']; ?></b><br/>
	Biaya: <b><?php echo number_format($sql3['biaya']); ?></b><br/>
	Total Budget: <b><?php echo $budget; ?></b>
	<br/>
	<br/>
	<div class="row">
		<div class="col-sm-4">
			<form action="do_realisasi3.php">
				<div class="form-group">
					<label for="keterangan1">No. PO / Memo</label>
					<input type="text" class="form-control" placeholder="Enter Keterangan 1" id="keterangan1" name="keterangan1">
				</div>
				<div class="form-group">
					<label for="keterangan2">Supplier</label>
					<input type="text" class="form-control" placeholder="Enter Supplier" id="keterangan2" name="keterangan2">
				</div>
				<div class="form-group">
					<label for="keterangan3">Deskripsi</label>
					<input type="text" class="form-control" placeholder="Enter Deskripsi" id="keterangan3" name="keterangan3">
				</div>
				<div class="form-group">
					<label for="keterangan4">Tanggal Bayar</label>
					<input type="date" class="form-control" placeholder="Enter Tanggal Bayar" id="keterangan4" name="keterangan4">
				</div>
				<div class="form-group">
					<label for="biaya">Biaya</label>
					<input type="text" class="form-control" placeholder="Enter biaya" id="biaya" name="biaya">
				</div>
				<input type="hidden" id="id_budget" name="id_budget" value="<?php echo $id_budget;?>">
				<input type="hidden" id="id_periode" name="id_periode" value="<?php echo $id_periode;?>">
				<input type="hidden" id="total_budget" name="total_budget" value="<?php echo $budget2;?>">
				<input type="hidden" id="id_budget_2" name="id_budget_2" value="<?php echo $id_bud_2;?>">
				<button type="submit" class="btn btn-primary">Tambah Realisasi</button>
			</form>
		</div>
	</div>
	<br/>
	<table class="table table-hover table-sm">
		<thead>
			<tr class="table-primary">
				<td>Budget</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo $budget; ?></td>
				<td></td>
			</tr>
			<tr>
				<th>No.</th>
				<th>No. PO / Memo</th>
				<th>Supplier</th>
				<th>Deskripsi</th>
				<th>Tanggal Bayar</th>
				<th class="text-right">Biaya</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			$sql = "SELECT * FROM tb_realisasi 
					WHERE id_budget = '$id_budget'";
			$sql2 = $db->query($sql);
			while ($sql3 = $sql2->fetch_array())
			{				
				?>
				<tr>
					<td><?php echo $no."."; ?></td>
					<td><?php echo $sql3['keterangan_1'];?></td>
					<td><?php echo $sql3['keterangan_2'];?></td>
					<td><?php echo $sql3['keterangan_3'];?></td>
					<td><?php echo date("d M, Y", strtotime($sql3['keterangan_4']));?></td>
					<td class="text-right"><?php echo number_format($sql3['biaya']);?></td>
					<td class="text-right"><a href="delete_realisasi.php?id_budget=<?php echo $sql3['id_budget']; ?>&id_periode=<?php echo $id_periode; ?>&id_realisasi=<?php echo $sql3['id_realisasi'];?>" type="button" class="btn btn-outline-danger btn-sm">delete</a></td>
				</tr>
				<?php
				$no++;
			}
			?>
			<tr class="table-primary">
			<?php
			
			$total = $db->query("SELECT SUM(biaya) AS total FROM tb_realisasi where id_budget='$id_budget'");
			$total2 = $total->fetch_array();
			$total3 = $total2['total'];
			?>
				<td>Total</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo number_format($total3);?></td>
				<td></td>
			</tr>
			<tr class="table-primary">
				<td>Sisa</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo number_format($budget2 - $total3); ?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5" class="text-right">
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