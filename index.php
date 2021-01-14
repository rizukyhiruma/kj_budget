<?php
	include "header.php";
	include "db_konek.php";
	include "cek_session.php";
?>
<div class="container">
	<?php 
	include "navigasi.php";
	if($_SESSION['type'] == "User" || $_SESSION['type'] == "Finance" || $_SESSION['type'] == "Super Admin")
	{
		?>
		<h1 class="display-4">Status Pengajuan</h1>
		<br/>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Periode</th>
					<th>Approval Finance</th>
					<th>Approval MD</th>
					<th>Approval CEO</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$id_user = $_SESSION["idus"];
				$no = 1;
				$sql_approval = "SELECT * 
								FROM tb_approval
								JOIN tb_periode ON tb_approval.id_periode = tb_periode.id_periode
								WHERE tb_approval.id_user = '$id_user'
								ORDER BY tb_periode.periode DESC";
				$sql_approval2 = $db->query($sql_approval);
				
				while($sql_approval3 = $sql_approval2->fetch_array())
				{
					?>
					<tr>
						<td><?php echo $no.".";?></td>
						<td><?php echo $sql_approval3['bulan'].", ".$sql_approval3['tahun'];?></td>
						<td>
							<?php
							if($sql_approval3['approval_1']==0)
							{
								echo "Waiting...";
							}
							else if($sql_approval3['approval_1']==1)
							{
								echo "Approved!";
							}
							?>
						</td>
						<td>
							<?php
							if($sql_approval3['approval_2']==0)
							{
								echo "Waiting...";
							}
							else if($sql_approval3['approval_2']==1)
							{
								echo "Approved!";
							}
							?>
						</td>
						<td>
							<?php
							if($sql_approval3['approval_3']==0)
							{
								echo "Waiting...";
							}
							else if($sql_approval3['approval_3']==1)
							{
								echo "Approved!";
							}
							?>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		<?php
	}
	?>
</div>
<?php
	include "footer.php"
?>