<?php
	include "header.php";
	include "db_konek.php";
	include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php"; ?>
	<br/>
	<form class="form-inline" action="do_periode2.php">
		<select class="form-control mb-2 mr-sm-2" id="periode" name="periode">
			<option>Select</option>
			<?php
			$start = strtotime('first day of this month');
			for($i=-3; $i<6; $i++)
			{
				$month = date('Y-m', strtotime(sprintf('+%d months', $i),$start));
				$month2 = date('M, Y', strtotime(sprintf('+%d months', $i),$start));
				?>
				<option value='<?php echo $month."-01|".$month2; ?>'><?php echo $month2; ?></option>
				<?php
			}
			?>
		</select>
		<button type="submit" class="btn btn-primary mb-2">Set Periode</button>
	</form>
	<?php
	if(isset($_GET['errmss']))
	{
		echo $_GET['errmss']."<br/>"; 
	}
	?>
	<br/>
	<table class="table table-hover">
		<thead>
			<tr>
			<th>Periode</th>
			<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$idus = $_SESSION['idus'];
			$sql = "SELECT * 
			FROM tb_periode 
			WHERE id_user='$idus' 
			ORDER BY periode DESC";
			$sql2 = $db->query($sql);
			while($result = $sql2->fetch_array())
			{
				?>
				<tr>
					<td><?php echo $result['bulan'].', '.$result['tahun'];?></td>
					<td><a href="pengajuan2.php?periode=<?php echo $result['id_periode'];?>" type="button" class="btn btn-primary">Open</a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
<?php
	include "footer.php";
?>