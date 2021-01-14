<?php

include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php"; ?>
	<h1 class="display-4">Realisasi</h1>
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
		$sql = "SELECT * FROM tb_periode WHERE id_user='$idus' ORDER BY periode DESC";
		$sql2 = $db->query($sql);

		while($result = $sql2->fetch_array())
		{
			?>
			<tr>
				<td><?php echo $result['bulan'].', '.$result['tahun'];?></td>
				<td><a href="realisasi2.php?periode=<?php echo $result['id_periode'];?>" type="button" class="btn btn-primary">Open</a></td>
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