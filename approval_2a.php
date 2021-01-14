<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";
	
	if($_SESSION['type'] == "MD" || $_SESSION['type'] == "Pemred" || $_SESSION['type'] == "Super Admin")
	{
	
		$idus = $_SESSION['idus'];
		$periode = $_GET['periode'];
		
		$sql = "SELECT * 
		FROM tb_periode 
		JOIN tb_user ON tb_periode.id_user = tb_user.id_user 
		WHERE periode='$periode'";
		$sql2 = $db->query($sql);
		$sql3 = $sql2->fetch_array();
		echo "<h1 class='display-4'>Approval ".$sql3['bulan'].", ".$sql3['tahun']."</h1>";
		//echo $periode2;
		?>
		<br/>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Departement</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			
			<?php 
			
			if($_SESSION['type']=='Pemred')
			{
				$periode2 = "SELECT 
				tb_periode.id_periode,
				tb_periode.bulan, 
				tb_periode.tahun,
				tb_periode.periode,
				tb_user.id_user,
				tb_user.username,
				tb_departemen.id_departemen,
				tb_departemen.nama_departemen,
				tb_approval.id_approval,
				tb_approval.approval_1
				FROM tb_periode
				JOIN tb_user ON tb_user.id_user = tb_periode.id_user
				JOIN tb_departemen ON tb_departemen.id_departemen = tb_user.id_departemen
				JOIN tb_approval ON tb_approval.id_periode = tb_periode.id_periode
				WHERE periode='$periode' and approval_1 = '1'
				AND tb_departemen.id_departemen = '12'";
			}
			else if($_SESSION['type']=='MD' || $_SESSION['type']=='Super Admin')
			{
				$periode2 = "SELECT 
				tb_periode.id_periode,
				tb_periode.bulan, 
				tb_periode.tahun,
				tb_periode.periode,
				tb_user.id_user,
				tb_user.username,
				tb_departemen.id_departemen,
				tb_departemen.nama_departemen,
				tb_approval.id_approval,
				tb_approval.approval_1
				FROM tb_periode
				JOIN tb_user ON tb_user.id_user = tb_periode.id_user
				JOIN tb_departemen ON tb_departemen.id_departemen = tb_user.id_departemen
				JOIN tb_approval ON tb_approval.id_periode = tb_periode.id_periode
				WHERE periode='$periode' and approval_1 = '1' 
				AND NOT tb_departemen.id_departemen = '12'";
			}
			$periode2a = $db->query($periode2);
			while($periode2b = $periode2a->fetch_array())
			{
				?>
				<tr>
					<td><?php echo $periode2b['username']." - ".$periode2b['nama_departemen'];?></td>
					<td><a href="approval_2b.php?id_periode=<?php echo $periode2b['id_periode'];?>&id_user=<?php echo $periode2b['id_user'];?>" type="button" class="btn btn-primary">Open</a></td>
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
<?php
include "footer.php";
?>