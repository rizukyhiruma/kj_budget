<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php 
	include "navigasi.php";

	if($_SESSION['type'] == "CEO" || $_SESSION['type'] == "Super Admin")
	{
		?>
		<h1 class="display-4">Periode Approval</h1>
		<?php
		if(isset($_GET['errmss']))
		{
			echo $_GET['errmss']; 
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

			//$idus = $_SESSION['idus'];
			$sql = "SELECT DISTINCT periode, bulan, tahun
					FROM
					tb_periode
					ORDER BY periode DESC
					";
			$sql2 = $db->query($sql);

			while($result = $sql2->fetch_array())
			{
				?>
				<tr>
					<td><?php echo $result['bulan'].', '.$result['tahun'];?></td>
					<td><a href="approval_3a.php?periode=<?php echo $result['periode'];?>" type="button" class="btn btn-primary">Open</a></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}
	else
	{
		header('location:index.php');
	}
	?>
</div>